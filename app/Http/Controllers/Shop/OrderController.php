<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = DB::table('orders', 'ORD')
            ->select('ORD.*', 'C.name AS country_name')
            ->join('country AS C', 'C.id', '=', 'ORD.delivery_country_id', 'left')
            //->whereIn('status', [0, 1])
            //->whereIn('delivery_method', ['dpd', 'dhl'])
        ;

        $delivery_method = $request->get('delivery_method');
        $page = $request->get('page');

        if ($delivery_method == 'dhl') {
            $orders->where('delivery_method', '=', $delivery_method);
        }

        $orders->orderBy('ORD.id');
        //$orders->orderBy('ORD.delivery_method', 'desc');
        //$orders->limit(2)->offset(($page - 1) * 2);

        return view('shop.orders.index', [
            'orders' => $orders->get()
        ]);
    }
}
