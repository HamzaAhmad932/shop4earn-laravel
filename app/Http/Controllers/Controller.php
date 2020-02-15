<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public static function apiSuccessResponse($message, $code, $data)
    {
        return response()->json([
            'status'=> true,
            'status_code'=> $code,
            'message'=> $message,
            'data'=> $data
        ]);
    }

    public static function apiErrorResponse($message, $code=500, $data=null){
        return response()->json([
            'status'=> false,
            'status_code'=> $code,
            'message'=> $message,
            'data'=> $data
        ]);
    }
}
