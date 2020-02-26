<?php

namespace App\Jobs;

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
        Log::notice(__CLASS__ . 'Dispatched');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::select('id')->where('role_id', 3)->where('id', '=', 13)->with(['customer', 'salesBonusDetail'])->get();

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

            $update_is_paired_ids = array_merge(array_merge(explode(',', $left_childs), explode(',', $right_childs)), $update_is_paired_ids);

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

            if(!($left_childs_bv > 0) && !($right_childs_bv > 0)){
                continue;
            }

            $left_childs_bv += $left_last_earning->carry_forward ?? 0;
            $right_childs_bv += $right_last_earning->carry_forward ?? 0;

            $left_points = ($left_childs_bv / 100) * $user->customer->criteria->percentage;
            $right_points = ($right_childs_bv / 100) * $user->customer->criteria->percentage;

            if ($left_childs_bv < $right_childs_bv) { // Left Weaker

                $carry_forward = $right_childs_bv - $left_childs_bv;

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
                        'carry_forward' => $carry_forward,
                        'position' => Customer::POSITION_RIGHT,
                        'created_at' => $now,
                        'updated_at' => $now,

                    ]
                );

            }

            if ($right_childs_bv < $left_childs_bv) { //Right Weaker

                $carry_forward = $left_childs_bv - $right_childs_bv;

                $sales_bonus_detail = array(
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
                );

            }

            //dd([$left_points, $right_points, $carry_forward, $sales_bonus_detail]);

            if(($left_points > 0) || ($right_points > 0)){

                SalesBonusDetail::insert($sales_bonus_detail);

                $earnings = Earning::firstOrNew(['user_id'=> $user->id]);
                $earnings->sales_bonus += $left_points < $right_points ? $left_points : $right_points;
                $earnings->carry_forward = $carry_forward;
                $earnings->save();
            }
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
            $this->getAllChilds($iteration, $position);
        } else {
            self::$childs = self::$customers->where('is_paired', Customer::NOT_PAIRED)->whereIn('user_id', self::$childs)->pluck('user_id')->toArray();
        }

        return self::$childs;
     }

}
