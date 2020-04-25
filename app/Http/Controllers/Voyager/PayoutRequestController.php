<?php

namespace App\Http\Controllers\Voyager;

use App\User;
use App\Earning;
use App\PayoutRequest;
use App\PaymentMethod;
use App\CustomSetting;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\PayoutRequestCollection;

class PayoutRequestController extends Controller
{
    public function index(Request $request)
    {
        $view = 'vendor.voyager.request-payout.browse';
        return view($view);
    }

    public function fetchAllPayoutRequests(Request $request)
    {
        try {
            $user = Auth::user();
            $filter = $request->filters;
            if($user->role_id == User::CUSTOMER_ROLE){
                array_push($filter['constraints'], ['user_id', $user->getAuthIdentifier()]);
            }

            $collection = get_collection_by_applying_filters($filter, PayoutRequest::class);
            return new PayoutRequestCollection($collection);

        } catch (\Exception $exception) {
            return [];
        }
    }

    public function create(Request $request){

        $view = 'vendor.voyager.request-payout.create';
        return view($view);
    }

    public function fetchAllPaymentMethod(Request $request){

        $pms = PaymentMethod::all();

        $pms_json =  $pms->transform(function ($pm) {
            return [
                'code' => $pm->id,
                'label' => $pm->name
            ];
        });

        $data = [
            'payment_methods'=> $pms_json,
            'phone'=> Auth::user()->mobile,
            'admin_percentage'=> CustomSetting::find(1)->admin_charges_percentage
        ];

        return self::apiSuccessResponse('', 200, $data);
    }

    public function addPayoutRequest(Request $request){

        $this->validate($request, [
            'pm_id'=> 'required',
            'amount'=> 'required|numeric|min:1000',
            'phone'=> 'required',
            'password'=> 'required',
            'donation'=> 'required|numeric|min:20'
        ], [
            'pm_id.required'=> 'Payment method is required.',
            'amount.required'=> 'Amount is required.',
            'phone.required'=> 'Phone is required.',
        ]);


        $user = Auth::user();
        if (!Hash::check($request->password , $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Password does not match.'],
            ]);
        }

        $admin_percentage = 0;
        $admin_charges = 0;
        $payable_amount = 0;
        $custom_setting = CustomSetting::find(1);
        if(!empty($custom_setting)){
            $admin_percentage = $custom_setting->admin_charges_percentage;
            $admin_charges = $admin_percentage * ((float) $request->amount /100);
            $payable_amount = (float) $request->amount - $admin_charges - (float) $request->donation;
        }

        PayoutRequest::create([
            'user_id'=> $user->id,
            'customer_id'=> empty($user->customer_id) ? 0 : $user->customer_id,
            'payment_method_id'=> $request->pm_id,
            'amount'=> $request->amount,
            'phone'=> $request->phone,
            'donation'=> $request->donation,
            'admin_percentage'=> $admin_percentage,
            'admin_charges'=> $admin_charges,
            'payable_amount'=> $payable_amount,
            'status'=> PayoutRequest::PENDING_STATUS,
            'date_requested'=> now()->toDateTimeString(),
            'date_cleared'=> null
        ]);

        return self::apiSuccessResponse('Payout Request submitted successfully.', 200, null);

    }

    public function adminIndex(){

        $view = 'vendor.voyager.request-payout.payout-requests-list';
        return view($view);
    }

    public function updatePayoutRequestStatus(Request $request){

        try{

            $status = $request->status;
            $payout_request_id = $request->request_id;

            $p_request = PayoutRequest::find($payout_request_id);
            if(!empty($p_request)){
                $p_request->status = $status;
                $p_request->save();

                if($status == PayoutRequest::PAID_STATUS){
                    $earning = Earning::where('user_id', $p_request->user_id)->first();
                    $earning->paid += $p_request->amount;
                    $earning->save();
                }

                return self::apiSuccessResponse('Status updated.', 200, null);
            }

            return self::apiErrorResponse('Record not found.');
        }catch (\Exception $e){
            Log::error($e->getMessage(), ['stacktrace: '=>$e->getTraceAsString()]);
            return self::apiErrorResponse('Something went wrong, contact support for assistance.');
        }
    }
}
