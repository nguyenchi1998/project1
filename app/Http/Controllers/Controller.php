<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function successRouteRedirect($routeName, $routeParam = null, $message = 'Action Success', $params = [])
    {
        if ($routeName) {
            return redirect()->route($routeName, $routeParam)
                ->with(
                    array_merge([
                        'message' => $message
                    ], $params)
                );
        }

        return back()
            ->with(
                array_merge([
                    'message' => $message
                ], $params)
            );
    }

    protected function failRouteRedirect($message = 'Action Fail', $params = [])
    {
        return back()->withErrors(['msg' => $message])
            ->with($params);
    }
}
