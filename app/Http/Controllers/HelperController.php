<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class HelperController extends Controller
{
    public function arrayHelper()
    {
        $array = [
            'a' => 1,
            'b' => 2,
        ];

        dump($array);

        // is_array -> accessible
        $isAccessible = Arr::accessible($array);
        dump($isAccessible);

        $isAccessible = Arr::accessible(new Collection());
        dump($isAccessible);

        //array_push -> add

        $array = Arr::add($array, 'c', null);
        dump($array);

        $array = Arr::add($array, 'c', 4);
        dump($array);

        //array_merge -> collapse
        $collapsed_array = Arr::collapse([
            [1, 2, 3],
            [4, 5, 6],
            [7, 8, 9],
            [10, 11, 12],
        ]);
        dump($collapsed_array);

        //crossJoin
        $crossed_array = Arr::crossJoin(
            [1, 2],
            ['a', 'b'],
            //['I', 'II']
        );
        dump($crossed_array);

        //array_keys, array_values divide
        [$keys, $values] = Arr::divide([
            'name' => 'Table',
            'price' => 100
        ]);
        dump($keys, $values);

        //except
        $array = [
            'name' => 'Table',
            'price' => 100,
            'discount' => 20,
        ];
        $filtered_array = Arr::except($array, ['price', 'name']);
        dump($filtered_array);

        //get
        // $array_get['products']['table']['price]
        $array_get = [
            'products' => [
                'table' => [
                    'price' => 100
                ],
                'desk' => [
                    'price' => 200,
                    'discount' => 20,
                ]
            ],
            'item' => [
                'name' => 'car',
            ],
        ];

        $price = Arr::get($array_get, 'products.table.price');
        dump(Arr::get($array_get, 'products.desk.discount'));
        dump($price);

        //forget
        echo 'forget';
        Arr::forget($array_get, 'products.desk');
        dump($array_get);

        //has
        $array_has = [
            'products' => [
                'name' => 'Table',
                'price' => 100
            ]
        ];

        $contains = Arr::has($array_has, 'products.name');
        dump($contains);

        $array = [1, 2, 3, 4, 5];

        $random = Arr::random($array);

        dump($random);

        $array = [
            [1, 3, 2],
            ['one' => 1, 'two' => 2, 'three' => 3],
            [6, 5, 8],
        ];

        $sorted = Arr::sortRecursive($array);
        dump($sorted);
    }

    public function pathHelper()
    {
        dump(app_path());
        dump(base_path());
        dump(config_path());
        dump(database_path());
        dump(lang_path());
        dump(public_path());
        dump(resource_path());
        dump(storage_path());
    }

    public function stringsHelper()
    {
        dump(__('message.welcome'));

        $class = class_basename('App\Models\Book');
        dump($class);

        dump(e('<html>PHP</html>'));

        $string = 'The event will take place between :start: and :end:';
        $replaced = preg_replace_array('/:[a-z_]+:/', ['8:30', '9:00'], $string);
        dump($replaced);

        $after = Str::after('example@localhost.lc', '@');
        dump($after);

        $before = Str::before('example@localhost.lc', '@');
        dump($before);

        $between = Str::between('This is my dfdsf name dsf df df', 'This', 'name');
        dump($between);

        $camel = Str::camel('first_name'); //firstName first-second-kazkas firstSecondKazkas
        dump(Str::kebab('BlogController')); // blog-controller
        dump($camel);
        dump(Str::snake('blogTitle')); // blog_title

        $ucFirst = Str::ucfirst('laravel');
        dump($ucFirst);
        dump(Str::lower('LOWER'));
        dump(Str::upper('upper'));
        dump(Str::length($ucFirst));
        dump(Str::limit('Lorem ipsum dolor set', 10));

        dump(Str::replace('8.x', '9.x', 'Laravel 8.x version 8.x'));
        dump(Str::reverse('Hello World')); // dlroW olleH

        dump(Str::slug('Тарифы на почтовые отправления', '-'));

        $contains = Str::contains('This is my name', 'my name');
        dump($contains);

        dump(Str::uuid());

        dump(Str::random(40));

        dump(Str::remove('bc', 'AbcdAbde'));

        $string = 'The event will take place between ::var:: and ::var::';
        dump(Str::replaceArray('::var::', ['8:30', '9:00'], $string));
    }

    public function urlsHelper()
    {
        dump(action([BlogController::class, 'index']));
        dump(action([BlogController::class, 'show'], ['blog' => 2]));

        dump(asset('assets/images/photo.jpg'));
        dump(secure_asset('assets/images/photo.jpg'));

        echo 'Route';
        dump(route('app.helper.urls'));
        dump(url('helper/urls'));

        echo '-- URL ';
        dump(
            url()->current(),
            url()->full(),
            url()->previous()
        );
        echo ' URL --';

        dump(secure_url('books'));

        dump(to_route('books.show', ['book' => 1]));
        //return redirect('blogs', 301);
        return to_route('books.show', ['book' => 1]);

    }

    public function othersHelper()
    {

    }
}
