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
        $status_arr = [PayoutRequest::PENDING_STATUS=> 'Pending', PayoutRequest::PAID_STATUS=> 'Paid', PayoutRequest::REJECTED_STATUS=> 'Rejected'];
        return [
            'data' => $this->collection->transform(function ($list) use($status_arr){
                return [
                    'id' => $list->id,
                    'user_id' => $list->user_id,
                    'status' => $status_arr[$list->status],
                    'amount' => $list->amount,
                    'phone' => $list->phone,
                    'date_requested' => $list->date_requested,
                    'date_cleared' => $list->date_cleared,
                ];
            }),
        ];
    }
}
