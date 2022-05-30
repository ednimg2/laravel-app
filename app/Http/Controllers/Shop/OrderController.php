<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Mail\OrderData;
use App\Mail\OrderShipped;
use App\Mail\OrderStatus;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
            'orders' => $orders->get(),
            'img' => Storage::url('file1.jpg')
        ]);
    }

    public function sendOrderDataViaEmail(Order $order): RedirectResponse
    {
        Mail::to($order->email)->send(new OrderData($order));

        return redirect('orders')
            ->with('success', 'Email send successfully!');
    }

    public function sendOrderShippedEmail(Order $order): RedirectResponse
    {
        $message = (new OrderShipped($order, url('book/show', $order->id)))->onQueue('order');

        Mail::to($order->email)->later(
            now()->addSeconds(5),
            $message
        );

        return redirect('orders')
            ->with('success', 'Email send successfully!');
    }

    public function sendOrderStatus(Order $order): RedirectResponse
    {
        //$message = (new OrderStatus($order, 'Mindaugas'))->onQueue('email');

        //Mail::queue($message);

        Mail::send(new OrderStatus($order, 'Mindaugas'));

        return redirect('orders')
            ->with('success', 'Email send successfully!');
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

    public function productsByPrice()
    {
        $products = DB::table('products')
            ->where('price', '<', 50)
        ;

        dump($products->toSql());

        $products = $products->get();
        dd($products);
    }

    public function productCountByOrders()
    {
        // select ORD.id, COUNT(ORDP.id) AS product_count
        // from `orders` as `ORD`
        // inner join `order_product` as `ORDP` on `ORDP`.`order_id` = `ORD`.`id`
        // group by `ORD`.`id`

        $orders = DB::table('orders', 'ORD')
            ->selectRaw('ORD.id, COUNT(ORDP.id) AS product_count')
            ->join('order_product AS ORDP', 'ORDP.order_id', '=', 'ORD.id', 'inner')
            ->groupBy('ORD.id')
        ;

        dump($orders->toSql());

        $orders = $orders->get();
        dd($orders);
    }

    public function unionQueries()
    {
        // (select * from `orders` where `payment_method` = ?)
        // union
        // (select * from `orders` where `delivery_method` = ?)
        $first = DB::table('orders')
            ->where('delivery_method', '=', 'dpd')
        ;

        $second = DB::table('orders')
            ->where('payment_method', '=', 'paysera')
            ->union($first)
        ;

        dump($second->toSql());

        dd($second->get());

    }

    public function ordersByDate(Request $request)
    {
        $date = $request->get('date');

        $orders = DB::table('orders');

        /*if ($date) {
            $orders->whereDate('created_at', '=', $date);
        }*/

        /*if ($date) {
            $orders->whereRaw('date(created_at) = ?', [$date]);
        }*/

        /*$orders->whereBetween('created_at', [
            '2022-05-01',
            '2022-05-09'
        ]);*/

        $orders->whereNotBetween('created_at', [
            '2022-05-01',
            '2022-05-10'
        ]);

        dump($orders->toSql());

        dd($orders->get());
    }

    public function ordersWhereCreatedAtLessUpdatedAt()
    {
        $orders = DB::table('orders')
            //->whereRaw('updated_at = created_at')
            //->whereRaw('first_name = last_name')
            //->whereColumn('updated_at', '=', 'created_at')
            ->whereColumn([
                ['updated_at', '=', 'created_at'],
                ['first_name', '=', 'last_name']
            ])
        ;

        dump($orders->toSql());

        dd($orders->get());
    }

    public function logicalGrouping()
    {
        // SELECT * FROM orders ORD
        // WHERE ORD.status = 0
        // AND (ORD.delivery_method = 'dpd' OR ORD.payment_method = 'paysera')

        $orders = DB::table('orders')
            ->where('status', '=', 0)
            ->where(function ($query) {
                $query->where('delivery_method', '=', 'dpd')
                    ->orWhere('payment_method', '=', 'paysera');
            })
        ;

        dump($orders->toSql());

        dd($orders->get());
    }

    public function latestOrders()
    {
        $orders = DB::table('orders')->latest();
        //$orders = DB::table('orders')->orderBy('created_at', 'desc');

        dump($orders->toSql());

        dd($orders->get());
    }

    public function oldestOrders()
    {
        $orders = DB::table('orders')->oldest();
        //$orders = DB::table('orders')->orderBy('created_at', 'asc');

        //dump($orders->toSql());
        $orders->dd();

        dd($orders->get());
    }

    public function insertCountry()
    {
        /*$country = [
            'name' => 'Lietuva',
            'iso_code_2' => 'LT',
            'active' => 0
        ];*/

        $country = [
            [
                'name' => 'Lietuva',
                'iso_code_2' => 'LT',
                'active' => 0
            ],
            [
                'name' => 'Latvija',
                'iso_code_2' => 'LV',
                'active' => 1
            ],
            [
                'name' => 'Estija',
                'iso_code_2' => 'EE',
                'active' => 0
            ],
        ];

        /*DB::table('country')
            ->insert($country)
        ;*/

        DB::table('country')
            ->insertOrIgnore($country)
        ;
    }

    public function updateCountry()
    {
        // UPDATE country SET name = 'Germany', iso_code_2 = 'DE' WHERE id = 7

        /*$update = DB::table('country')
            ->where('id', '=', 7)
            ->update(
                [
                    'name' => 'Germany',
                    'iso_code_2' => 'DE'
                ]
            )
        ;*/

         DB::table('country')
            ->updateOrInsert(
                [
                    'name' => 'Vokietija'
                ],
                [
                    'iso_code_2' => 'FR',
                    'active' => 0
                ]
            )
        ;
    }

    public function deleteCountry()
    {
        /*DB::table('country')
            ->delete()
        ;*/

        /*DB::table('country')
            ->truncate()
        ;*/

        DB::table('country')
            ->where('id', '=', 10)
            ->delete()
        ;
    }

    public function exercise1_1()
    {
        $orders = DB::table('orders')
            ->selectRaw('
            id AS order_id,
            IF(status = 0, "naujas", IF(status = 1, "apdorojamas", IF(status = 2, "ivykdytas", NULL))) as status
            ')
        ;

        //$orders->dd();
        dd($orders->get());
    }

    public function exercise1_2()
    {
        $orders = DB::table('orders', 'ORD')
            ->select('ORD.*', 'C.name AS country_name')
            ->join('country AS C', 'C.id', '=', 'ORD.delivery_country_id', 'inner')
        ;

        dd($orders->get());
    }

    public function exercise4()
    {
        $orders = DB::table('orders')
            ->selectRaw('delivery_method, COUNT(id) AS order_count')
            ->groupBy('delivery_method')
        ;

        dd($orders->get());
    }

    public function exercise5()
    {
        $orders = DB::table('orders')
            ->selectRaw()
            ->groupBy()
            ->orderBy()
        ;

        dd($orders->get());
    }

    public function exercise7()
    {
        $orders = DB::table('orders')
            ->selectRaw()
        ;

        dd($orders->get());
    }

    public function exercise9()
    {
        $products = DB::table('products')
            ->join()
        ;

        dd($products->get());
    }

}
