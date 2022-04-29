<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CookieController extends Controller
{
    public function __invoke(Request $request)
    {
        return response('Super accpeted cookie')->cookie(
            'accpetCookie', '1', 9999999
        );
    }
}
