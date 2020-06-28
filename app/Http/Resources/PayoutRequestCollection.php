<?php

namespace App\Http\Resources;

use App\PayoutRequest;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PayoutRequestCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $status_arr = [
            PayoutRequest::PENDING_STATUS=> ['status'=>'Pending', 'class'=> 'badge badge-warning', 'allow_update'=> true],
            PayoutRequest::PAID_STATUS=> ['status'=> 'Paid', 'class'=> 'badge badge-success', 'allow_update'=> false],
            PayoutRequest::REJECTED_STATUS=> ['status'=> 'Rejected', 'class'=> 'badge badge-danger', 'allow_update'=> true]
        ];
        return [
            'data' => $this->collection->transform(function ($list) use($status_arr){
                return [
                    'id' => $list->id,
                    'user_id' => $list->user_id,
                    'status_info' => $status_arr[$list->status],
                    'amount' => $list->amount,
                    'admin_charges' => $list->admin_charges,
                    'admin_percentage' => $list->admin_percentage,
                    'donation' => $list->donation,
                    'phone' => $list->phone,
                    'date_requested' => $list->date_requested,
                    'date_cleared' => $list->date_cleared,
                ];
            }),
        ];
    }
}
