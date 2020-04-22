<?php

namespace App\Jobs;

use App\Rank;
use App\Customer;
use App\Earning;
use App\User;
use Carbon\Carbon;
use App\SalesBonusDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalesBonusCalculateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public static $childs = [];
    public static $user_id = [1];
    public static $customers = [];


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //Log::notice(__CLASS__ . 'Dispatched');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug('job dispatched');

        $users = User::select('id')->where('role_id', 3)->with(['customer', 'salesBonusDetail'])->get();

        $now = now()->toDateTimeString();
        $update_is_paired_ids = [];

        foreach ($users as $user) {

            self::$user_id = [$user->id];
            self::$childs = [];

            $right_last_earning = $user->salesBonusDetail->where('position', Customer::POSITION_RIGHT)->last();
            $left_last_earning = $user->salesBonusDetail->where('position', Customer::POSITION_LEFT)->last();


            $left_childs = implode(',', $this->getAllChilds(Customer::POSITION_LEFT));

            self::$childs = [];
            self::$user_id = [$user->id];

            $right_childs = implode(',', $this->getAllChilds(Customer::POSITION_RIGHT));
//            dump([$left_childs, $right_childs]);

            $left_childs_bv = 0;
            $right_childs_bv = 0;

            if (!empty($left_childs)) {
                $sale = DB::select(DB::raw("select sum((quantity*bv)-discount) as total_bv from sale_details where user_id IN($left_childs)"));
                $left_childs_bv += $sale[0]->total_bv ?? 0;
            }

            if (!empty($right_childs)) {
                $sale = DB::select(DB::raw("select sum((quantity*bv)-discount) as total_bv from sale_details where user_id IN ($right_childs)"));
                $right_childs_bv += $sale[0]->total_bv ?? 0;
            }


            $update_is_paired_ids = array_merge(array_merge(explode(',', $left_childs), explode(',', $right_childs)), $update_is_paired_ids);

            //dd($update_is_paired_ids);
            $left_childs_bv += $left_last_earning->carry_forward ?? 0;
            $right_childs_bv += $right_last_earning->carry_forward ?? 0;

//            dump(empty($right_childs) && !empty($left_childs), $user->id);
//            dump(!empty($right_childs) && empty($left_childs), $user->id);
//            dd([$left_childs_bv, $right_childs_bv]);

            if(empty($left_childs_bv) && empty($right_childs_bv)) {
                continue;
            } elseif (empty($right_childs_bv) && !empty($left_childs_bv)) {
                $this->noWeakerSideFound(Customer::POSITION_LEFT, $left_childs_bv, $user->id);
                continue;
            } elseif (!empty($right_childs_bv) && empty($left_childs_bv)) {
                $this->noWeakerSideFound(Customer::POSITION_RIGHT, $right_childs_bv, $user->id);
                continue;
            }

//            dd([$user, $left_childs_bv, $right_childs_bv, $left_childs, $right_childs]);

            $left_points = ($left_childs_bv / 100) * $user->customer->criteria->percentage;
            $right_points = ($right_childs_bv / 100) * $user->customer->criteria->percentage;

            //dd([$user, $left_childs_bv, $right_childs_bv, $left_childs, $right_childs, $left_points, $right_points]);

            //dump($left_childs_bv < $right_childs_bv);
            $sales_bonus_detail = [];
            $carry_forward = 0;
            if (round($left_childs_bv) < round($right_childs_bv)) { // Left Weaker

                $carry_forward = $right_childs_bv - $left_childs_bv;

                $sales_bonus_detail = [
                    [
                        'user_id' => $user->id,
                        'sales_bonus' => $left_points,
                        'carry_forward' => 0,
                        'position' => Customer::POSITION_LEFT,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ],
                    [
                        'user_id' => $user->id,
                        'sales_bonus' => 0,
                        'carry_forward' => $carry_forward,
                        'position' => Customer::POSITION_RIGHT,
                        'created_at' => $now,
                        'updated_at' => $now,

                    ]
                ];

            }
            //dump($right_childs_bv < $left_childs_bv);
            if (round($right_childs_bv) < round($left_childs_bv)) { //Right Weaker

                $carry_forward = $left_childs_bv - $right_childs_bv;

                $sales_bonus_detail = [
                    [
                        'user_id' => $user->id,
                        'sales_bonus' => $right_points,
                        'carry_forward' => 0,
                        'position' => Customer::POSITION_RIGHT,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ],
                    [
                        'user_id' => $user->id,
                        'sales_bonus' => 0,
                        'carry_forward' => $carry_forward,
                        'position' => Customer::POSITION_LEFT,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                ];

            }
            //dump(['right_child_bv'=>$right_childs_bv, 'left_child_bv'=> $left_childs_bv]);
            //dump([$left_points, $right_points, !empty($carry_forward) ? $carry_forward : 'cf=0', !empty($sales_bonus_detail) ? $sales_bonus_detail : 'sales_detail=[]', $user->id]);

//            if(($left_points > 0) || ($right_points > 0)){

                if(!empty($sales_bonus_detail)) {
                    SalesBonusDetail::insert($sales_bonus_detail);
                    $this->updateEarning($user->id, ($left_points < $right_points ? $left_points : $right_points), !empty($carry_forward) ? $carry_forward : 0);
                }else{
                    //points are equal
                    $sales_bonus_detail = array(
                        [
                            'user_id' => $user->id,
                            'sales_bonus' => $left_points,
                            'carry_forward' => 0,
                            'position' => Customer::POSITION_LEFT,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ],
                        [
                            'user_id' => $user->id,
                            'sales_bonus' => 0,
                            'carry_forward' => 0,
                            'position' => Customer::POSITION_RIGHT,
                            'created_at' => $now,
                            'updated_at' => $now,

                        ]
                    );

                    SalesBonusDetail::insert($sales_bonus_detail);
                    $this->updateEarning($user->id, $left_points, 0);
                }
//            }
        }
        if(!empty($update_is_paired_ids)){
            Customer::whereIn('user_id', $update_is_paired_ids)->update(['is_paired'=> 1]);
        }
    }


    /**
     * @param $position
     * @param int $iteration
     * @return array
     * $position of root's Child
     * $iteration always pass as Zero
     */

     public function getAllChilds($position, $iteration = 0) {

        if (empty(self::$customers))
            self::$customers = Customer::all();

        $leaves = self::$customers->whereIn('parent_id', self::$user_id);


        if ($iteration == 0) {
            $neglect_child = self::$customers->whereIn('parent_id', self::$user_id)->where('position', '!=', $position)->first();

            if (! empty($neglect_child))
                $leaves = $leaves->where('user_id', '!=', $neglect_child->user_id);

            $iteration++;
        }

        $leaves = $leaves->pluck('user_id')->toArray();

        if (!empty($leaves)) {
            self::$user_id = $leaves;
            self::$childs = array_merge(self::$childs, $leaves);
            $this->getAllChilds($position, $iteration);
        } else {
            self::$childs = self::$customers->where('is_paired', Customer::NOT_PAIRED)->whereIn('user_id', self::$childs)->pluck('user_id')->toArray();
        }

        return self::$childs;
     }

    /**
     * @param $user_id
     * @param $bv
     * @param $carry_forward
     * @return mixed
     */
     private function updateEarning($user_id, $bv, $carry_forward) {
         $earnings = Earning::firstOrNew(['user_id' => $user_id]);
         $earnings->sales_bonus += $bv;
         $earnings->carry_forward = $carry_forward;
         $earnings->save();

         return $earnings;
     }


    /**
     * @param $position
     * @param $bv
     * @param $user_id
     */
     private function noWeakerSideFound($position, $bv, $user_id) {
         // use this bv as carry forward because binary tree, second leg not found.
         $now = now()->toDateTimeString();
         SalesBonusDetail::insert(array(
             [
                 'user_id' => $user_id,
                 'sales_bonus' => 0,
                 'carry_forward' => $bv,
                 'position' => $position,
                 'created_at' => $now,
                 'updated_at' => $now,
             ],
             [
                 'user_id' => $user_id,
                 'sales_bonus' => 0,
                 'carry_forward' => 0,
                 'position' => $position == Customer::POSITION_RIGHT ? Customer::POSITION_LEFT : Customer::POSITION_RIGHT,
                 'created_at' => $now,
                 'updated_at' => $now,

             ]
         ));
         $this->updateEarning($user_id, 0, $bv);
         //Log::notice('no weaker side found for user id#' .$user_id);
     }

}
