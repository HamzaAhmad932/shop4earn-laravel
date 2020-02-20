<?php

namespace App\Jobs;

use App\Customer;
use App\Earning;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

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
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::select('id')->where('role_id', 3)->whereNotIn('id',
            Earning::where('created_at', '>=', now()->startOfDay()->toDateTimeString())->pluck('user_id')->toArray()
        )->where('id', '=', 3)->with(['customer', 'earnings'])->get();

        $now = now()->toDateTimeString();

        foreach ($users as $user) {

            self::$user_id = [$user->id];
            self::$childs = [];

            $right_last_earning = $user->earnings->where('position', Customer::POSITION_RIGHT)->last();
            $left_last_earning = $user->earnings->where('position', Customer::POSITION_LEFT)->last();

            $left_childs_bv = $left_last_earning->carry_forward ?? 0;
            $right_childs_bv = $right_last_earning->carry_forward ?? 0;

            $start_date = !empty($right_last_earning)
                ? Carbon::parse($right_last_earning->created_at)->startOfDay()->toDateTimeString()
                : now()->subDays(1)->startOfDay()->toDateTimeString();

            $end_date = Carbon::parse($start_date)->endOfDay()->toDateTimeString();

            $left_childs = implode(',', $this->getAllChilds(Customer::POSITION_LEFT));
            $right_childs = implode(',', $this->getAllChilds(Customer::POSITION_RIGHT));

            if (!empty($left_childs)) {
                $sale = DB::select(DB::raw("select sum(quantity*bv) as total_bv from sale_details where user_id IN($left_childs) and created_at >= '{$start_date}' and created_at <= '{$end_date}'"));
                $left_childs_bv += $sale[0]->total_bv ?? 0;
            }

            if (!empty($right_childs)) {
                $sale = DB::select(DB::raw("select sum(quantity*bv) as total_bv from sale_details where user_id IN ($right_childs) and created_at >= '{$start_date}' and created_at <= '{$end_date}'"));
                $right_childs_bv += $sale[0]->total_bv ?? 0;
            }

            if ($left_childs_bv < $right_childs_bv) { // Left Weaker

                $points = ($left_childs_bv / 100) * $user->customer->criteria->percentage;

                $earnings = array(
                    [
                        'user_id' => $user->id, 'direct_bonus' => 0, 'team_bonus' => 0, 'sales_bonus' => $points,
                        'carry_forward' => 0, 'position' => Customer::POSITION_LEFT, 'paid' => 0, 'created_at' => $now,
                        'updated_at' => $now,
                    ],
                    [
                        'user_id' => $user->id, 'direct_bonus' => 0, 'team_bonus' => 0, 'sales_bonus' => 0,
                        'carry_forward' => abs($left_childs_bv - $right_childs_bv), 'position' => Customer::POSITION_RIGHT,
                        'paid' => 0, 'created_at' => $now, 'updated_at' => $now,

                    ]
                );

            } else { //Right Weaker

                $points = ($right_childs_bv / 100) * $user->customer->criteria->percentage;

                $earnings = array(
                    [
                        'user_id' => $user->id, 'direct_bonus' => 0, 'team_bonus' => 0, 'sales_bonus' => $points,
                        'carry_forward' => 0, 'position' => Customer::POSITION_RIGHT, 'paid' => 0, 'created_at' => $now,
                        'updated_at' => $now,
                    ],
                    [
                        'user_id' => $user->id, 'direct_bonus' => 0, 'team_bonus' => 0, 'sales_bonus' => 0,
                        'carry_forward' => abs($left_childs_bv - $right_childs_bv), 'position' => Customer::POSITION_LEFT,
                        'paid' => 0, 'created_at' => $now, 'updated_at' => $now,
                    ]
                );

            }

            Earning::insert($earnings);
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
        }

        return self::$childs;
     }

}
