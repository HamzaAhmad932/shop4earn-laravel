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


    protected static $childs = [];
    protected static $user_id = [1];
    protected static $customers = [];
    protected static $upline = [];
    protected $customer;
    public $tries = 5;


    /**
     * Create a new job instance.
     *
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('max_execution_time', 0);
        $upline_user_ids = $this->getUplineIDs($this->customer->parent_id);

        $users = User::select('id')
            ->where('role_id', 3)
            ->whereIn('id', $upline_user_ids)
            ->with(['customer', 'salesBonusDetail'])
            ->get();

        $now = now()->toDateTimeString();
        $percentage = 100;
        $capped = false;

        //Recalculate trigger
        recalculate_sales_bonus:

        // this variable store sales bonus detail in bulk
        // and insert all entries at once in sales detail table
        $bulk_sales_bonus_detail = [];
        // this variable store information of earning of a user
        $earning_info = [];
        $total_product_bv = 0;
        $total_sales_bonus_to_be_deliver = 0;

        foreach ($users as $user) {

            //continue inactive customer
            $customer = $user->customer;
            if($customer->status == 0){
                //dump(['continue 1', $user->id]);
                continue;
            }

            self::$user_id = [$user->id];
            self::$childs = [];

            $right_last_earning = $user->salesBonusDetail->where('position', Customer::POSITION_RIGHT)->last();
            $left_last_earning = $user->salesBonusDetail->where('position', Customer::POSITION_LEFT)->last();

            $left_childs = [];
            $right_childs = [];
            if($this->customer->position == Customer::POSITION_LEFT){
                $left_childs = [$this->customer->user_id];
            }
            self::$childs = [];
            self::$user_id = [$user->id];

            if($this->customer->position == Customer::POSITION_RIGHT){
                $right_childs = [$this->customer->user_id];
            }

            $c_user_id = $this->customer->user_id;

            $left_childs_bv = 0;
            $right_childs_bv = 0;

            if (!empty($left_childs)) {
                $sale = DB::select(DB::raw("select sum((quantity*bv)-discount) as total_bv from sale_details where user_id = ". $c_user_id));
                $left_childs_bv += $sale[0]->total_bv ?? 0;
                $total_product_bv = $left_childs_bv;
            }

            if (!empty($right_childs)) {
                $sale = DB::select(DB::raw("select sum((quantity*bv)-discount) as total_bv from sale_details where user_id = ". $c_user_id));
                $right_childs_bv += $sale[0]->total_bv ?? 0;
                $total_product_bv = $right_childs_bv;
            }

            if(empty($left_childs) && empty($right_childs)) {
                //dump(['continue 2', $user->id]);
                continue;
            }


//            $update_is_paired_ids = array_filter(array_merge(
//                array_merge(
//                    explode(',', $left_childs),
//                    explode(',', $right_childs)
//                ), $update_is_paired_ids));

            //dd($update_is_paired_ids);
            //dump([$left_childs_bv, $right_childs_bv]);
            $left_childs_bv += $left_last_earning->carry_forward ?? 0;
            $right_childs_bv += $right_last_earning->carry_forward ?? 0;

//            dump(empty($right_childs) && !empty($left_childs), $user->id);
//            dump(!empty($right_childs) && empty($left_childs), $user->id);
//            dd([$left_childs_bv, $right_childs_bv]);

            if(empty($left_childs_bv) && empty($right_childs_bv)) {
                continue;
            } elseif (empty($right_childs_bv) && !empty($left_childs_bv)) {
                $this->noWeakerSideFound(Customer::POSITION_LEFT, $left_childs_bv, $user->id, $capped, $percentage);
                continue;
            } elseif (!empty($right_childs_bv) && empty($left_childs_bv)) {
                $this->noWeakerSideFound(Customer::POSITION_RIGHT, $right_childs_bv, $user->id, $capped, $percentage);
                continue;
            }

            //dd([$user, $left_childs_bv, $right_childs_bv, $left_childs, $right_childs]);

            $left_points = ($left_childs_bv / $percentage) * $user->customer->criteria->percentage;
            $right_points = ($right_childs_bv / $percentage) * $user->customer->criteria->percentage;

            if(empty($left_points) && empty($right_points)){
                continue;
            }

            //dd([$user, $left_childs_bv, $right_childs_bv, $left_childs, $right_childs, $left_points, $right_points]);

            //dump($left_childs_bv < $right_childs_bv);
            $sales_bonus_detail = [];
            $carry_forward = 0;
            if (round($left_childs_bv) < round($right_childs_bv)) { // Left Weaker

                $carry_forward = $right_childs_bv - $left_childs_bv;
                $total_sales_bonus_to_be_deliver = $total_sales_bonus_to_be_deliver + $left_points;

                $sales_bonus_detail = [
                    [
                        'user_id' => $user->id,
                        'sales_bonus' => $left_points,
                        'carry_forward' => 0,
                        'position' => Customer::POSITION_LEFT,
                        'capped'=> $capped,
                        'dividing_percentage'=> $percentage,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ],
                    [
                        'user_id' => $user->id,
                        'sales_bonus' => 0,
                        'carry_forward' => $carry_forward,
                        'position' => Customer::POSITION_RIGHT,
                        'capped'=> $capped,
                        'dividing_percentage'=> $percentage,
                        'created_at' => $now,
                        'updated_at' => $now,

                    ]
                ];

            }
            //dump($right_childs_bv < $left_childs_bv);
            if (round($right_childs_bv) < round($left_childs_bv)) { //Right Weaker

                $carry_forward = $left_childs_bv - $right_childs_bv;
                $total_sales_bonus_to_be_deliver = $total_sales_bonus_to_be_deliver + $right_points;

                $sales_bonus_detail = [
                    [
                        'user_id' => $user->id,
                        'sales_bonus' => $right_points,
                        'carry_forward' => 0,
                        'position' => Customer::POSITION_RIGHT,
                        'capped'=> $capped,
                        'dividing_percentage'=> $percentage,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ],
                    [
                        'user_id' => $user->id,
                        'sales_bonus' => 0,
                        'carry_forward' => $carry_forward,
                        'position' => Customer::POSITION_LEFT,
                        'capped'=> $capped,
                        'dividing_percentage'=> $percentage,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                ];

            }
            //dump(['right_child_bv'=>$right_childs_bv, 'left_child_bv'=> $left_childs_bv]);
            //dump([$left_points, $right_points, !empty($carry_forward) ? $carry_forward : 'cf=0', !empty($sales_bonus_detail) ? $sales_bonus_detail : 'sales_detail=[]', $user->id]);

//            if(($left_points > 0) || ($right_points > 0)){

                if(!empty($sales_bonus_detail)) {
                    //SalesBonusDetail::insert($sales_bonus_detail);
//                    $this->updateEarning(
//                        $user->id,
//                        $left_points < $right_points ? $left_points : $right_points,
//                        !empty($carry_forward) ? $carry_forward : 0
//                    );

                    $e_info = [
                        'user_id'=>$user->id,
                        'bv'=> ($left_points < $right_points ? $left_points : $right_points),
                        'cf'=> !empty($carry_forward) ? $carry_forward : 0
                    ];

                    array_push($bulk_sales_bonus_detail, $sales_bonus_detail);
                    array_push($earning_info, $e_info);
                }else{

                    $total_sales_bonus_to_be_deliver = $total_sales_bonus_to_be_deliver + $left_points;
                    //points are equal
                    $sales_bonus_detail = array(
                        [
                            'user_id' => $user->id,
                            'sales_bonus' => $left_points,
                            'carry_forward' => 0,
                            'position' => Customer::POSITION_LEFT,
                            'capped'=> $capped,
                            'dividing_percentage'=> $percentage,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ],
                        [
                            'user_id' => $user->id,
                            'sales_bonus' => 0,
                            'carry_forward' => 0,
                            'position' => Customer::POSITION_RIGHT,
                            'capped'=> $capped,
                            'dividing_percentage'=> $percentage,
                            'created_at' => $now,
                            'updated_at' => $now,

                        ]
                    );

                    //SalesBonusDetail::insert($sales_bonus_detail);
                    $e_info = [
                        'user_id'=>$user->id,
                        'bv'=> $left_points,
                        'cf'=> 0
                    ];

                    array_push($bulk_sales_bonus_detail, $sales_bonus_detail);
                    array_push($earning_info, $e_info);
                    //$this->updateEarning($user->id, $left_points, 0);
                }
//            }
        }

        // Capping condition
        if(round($total_sales_bonus_to_be_deliver) > round($total_product_bv)){
            $percentage = ($total_sales_bonus_to_be_deliver/$total_product_bv)*100;
            $capped = true;

//            dump([
//                'sales_detail'=>$bulk_sales_bonus_detail,
//                'earning_info'=>$earning_info,
//                'total_bv'=>$total_sales_bonus_to_be_deliver,
//                'product_bv'=>$total_product_bv,
//                'percentage'=> $percentage
//            ]);

            goto recalculate_sales_bonus;

        }
        else{

            $bulk_sales_bonus_detail = call_user_func_array('array_merge', $bulk_sales_bonus_detail);
            SalesBonusDetail::insert($bulk_sales_bonus_detail);

            foreach($earning_info as $k => $earning){

                $this->updateEarning($earning['user_id'], $earning['bv'], $earning['cf']);
            }
        }

        $this->customer->update(['is_paired'=> 1]);
    }


    /**
     * @param $position
     * @param int $iteration
     * @return array
     * $position of root's Child
     * $iteration always pass as Zero
     */

     public function getAllChilds($position, $iteration = 0) {

        if (empty(self::$customers)) {
            self::$customers = Customer::all();
        }

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
         $earnings->sales_bonus = (float) $earnings->sales_bonus + (float) $bv;
         $earnings->carry_forward = $carry_forward;
         $earnings->earned = (float) $earnings->team_bonus + (float) $earnings->sales_bonus;
         $earnings->save();

         return $earnings;
     }


    /**
     * @param $position
     * @param $bv
     * @param $user_id
     */
     private function noWeakerSideFound($position, $bv, $user_id, $capped, $percentage) {
         // use this bv as carry forward because binary tree, second leg not found.
         $now = now()->toDateTimeString();
         SalesBonusDetail::insert(array(
             [
                 'user_id' => $user_id,
                 'sales_bonus' => 0,
                 'carry_forward' => $bv,
                 'position' => $position,
                 'capped'=> $capped,
                 'dividing_percentage'=> $percentage,
                 'created_at' => $now,
                 'updated_at' => $now,
             ],
             [
                 'user_id' => $user_id,
                 'sales_bonus' => 0,
                 'carry_forward' => 0,
                 'position' => $position == Customer::POSITION_RIGHT ? Customer::POSITION_LEFT : Customer::POSITION_RIGHT,
                 'capped'=> $capped,
                 'dividing_percentage'=> $percentage,
                 'created_at' => $now,
                 'updated_at' => $now,

             ]
         ));
         $this->updateEarning($user_id, 0, $bv);
         //Log::notice('no weaker side found for user id#' .$user_id);
     }

    public function getUplineIDs(int $parent_id){

        self::$upline = [];
        $this->getUpline($parent_id);
        return self::$upline;
    }

    private function getUpline($parent_id){

        array_push(self::$upline, $parent_id);
        if (empty(self::$customers)) {
            self::$customers = Customer::all();
        }
        $parent = self::$customers->where('user_id', $parent_id)->first();
        if(!empty($parent)){

            if($parent->parent_id == 2){
                return false;
            }
            return $this->getUpline($parent->parent_id);
        }
    }

    public function fail($exception = null)
    {
        Log::debug($exception, ['File'=> __FILE__]);
    }

}
