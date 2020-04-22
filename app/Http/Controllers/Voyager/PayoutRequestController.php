<?php

namespace App\Http\Controllers\Voyager;

use App\User;
use App\PayoutRequest;
use App\PaymentMethod;
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
            array_push($filter['constraints'], ['user_id', $user->getAuthIdentifier()]);

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

        return $pms->transform(function ($pm) {
            return [
                'code' => $pm->id,
                'label' => $pm->name
            ];
        });
    }

    public function addPayoutRequest(Request $request){

        $this->validate($request, [
            'pm_id'=> 'required',
            'amount'=> 'required',
            'phone'=> 'required',
            'password'=> 'required'
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

        PayoutRequest::create([
            'user_id'=> $user->id,
            'customer_id'=> empty($user->customer_id) ? 0 : $user->customer_id,
            'payment_method_id'=> $request->pm_id,
            'amount'=> $request->amount,
            'phone'=> $request->phone,
            'status'=> PayoutRequest::PENDING_STATUS,
            'date_requested'=> now()->toDateTimeString(),
            'date_cleared'=> null
        ]);

        return self::apiSuccessResponse('Payout Request submitted successfully.', 200, null);

    }
}
