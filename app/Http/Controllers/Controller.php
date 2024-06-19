<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\YearlyData;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
       $this->middleware(function ($request, $next) {
            $hightide = YearlyData::whereDate('date', date('Y-m-d'))->first();
            View::share('hightide', $hightide);
            return $next($request);
        });

    }
}
