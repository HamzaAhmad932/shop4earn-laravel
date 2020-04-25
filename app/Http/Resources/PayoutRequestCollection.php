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
            PayoutRequest::PENDING_STATUS=> ['txt'=>'Pending', 'class'=> 'badge badge-warning'],
            PayoutRequest::PAID_STATUS=> ['txt'=> 'Paid', 'class'=> 'badge badge-success'],
            PayoutRequest::REJECTED_STATUS=> ['txt'=> 'Rejected', 'class'=> 'badge badge-danger']
        ];
        return [
            'data' => $this->collection->transform(function ($list) use($status_arr){
                return [
                    'id' => $list->id,
                    'user_id' => $list->user_id,
                    'status_info' => [
                        'class'=> $status_arr[$list->status]['class'],
                        'status'=> $status_arr[$list->status]['txt']
                    ],
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
