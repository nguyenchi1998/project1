<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function successRouteRedirect($data = null, $message = 'Xử lý thành công')
    {
        return response([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ]);
    }

    protected function failRouteRedirect($message = 'Xử lý thất bại', $status = 500)
    {
        return response([
            'success' => false,
            'message' => $message,
        ], $status);
    }
}
