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

        //$orders->addSelect('C.id');
        $orders->orderBy('ORD.id');
        $orders->orderBy('ORD.delivery_method', 'desc');
        $orders->limit(10)->offset(($page - 1) * 10);

        //dd($orders->toSql());

        return view('shop.orders.index', [
            'orders' => $orders->get()
        ]);
    }

    public function distinctPayment()
    {
        //SELECT DISTINCT payment_method FROM orders
        $paymentMethods = DB::table('orders')
            ->select('payment_method')
            ->distinct()
        ;

        dump($paymentMethods->toSql());

        $paymentMethods = $paymentMethods->get();
        dd($paymentMethods);
    }

    public function ordersCountByDeliveryType()
    {
        //SELECT delivery_method, COUNT(order_id) order_count FROM orders GROUP BY delivery_method
        $orders = DB::table('orders')
            ->select(DB::raw('delivery_method, COUNT(*) as order_count'))
            ->groupBy('delivery_method')
        ;

        dump($orders->toSql());

        $orders = $orders->get();
        dd($orders);
    }

    public function productData()
    {
        //SELECT SUM(price) as price, MIN(price) as min_price, MAX(price) as max_price FROM products
        $products = DB::table('products')
            ->select(DB::raw('SUM(price) as price, MIN(price) as min_price, MAX(price) as max_price'))
        ;

        dump($products->toSql());

        $products = $products->get();
        dd($products);
    }

    public function ordersCountByDeliveryTypeHaving()
    {
        $ordersCount = 5;
        //SELECT delivery_method, COUNT(order_id) order_count FROM orders GROUP BY delivery_method HAVING order_count > 5
        $orders = DB::table('orders')
            ->select(DB::raw('delivery_method, COUNT(*) as order_count'))
            ->groupBy('delivery_method')
            ->havingRaw('order_count > ?', [$ordersCount])
        ;

        dump($orders->toSql());

        $orders = $orders->get();
        dd($orders);
    }
}
