<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;

class CountryController extends Controller
{
    public function index(): View
    {
        $countries = DB::table('country', 'C')
            ->where('C.active', '=', 1)
            //->join('orders AS ORD', 'ORD.delivery_country_id', '=', 'C.id', 'inner')
            ->orderBy('C.name')
            ->get();

        return view('country.index', compact('countries'));
    }
}
