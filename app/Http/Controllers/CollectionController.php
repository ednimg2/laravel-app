<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CollectionController extends Controller
{
    public function collect()
    {
        $collection = collect([1, 2, 3, 4]);

        dd($collection);
    }

    public function extendingCollection()
    {
        Collection::macro('toUpper', function () {
            return $this->map(function ($value) {
                return Str::upper($value);
                //strtoupper()
            });
        });

        $collection = collect(['first', 'second']);

        $upper = $collection->toUpper();

        dd($upper);
    }

    public function collectionAll()
    {
        $collection = collect([1, 2, 3, 4])->all();

        dd($collection);
    }

    public function collectionAvg()
    {
        $average = collect([1, 1, 2, 4, 5])->avg();

        dd($average);
    }

    public function collectionChunk()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8]);
        //array_chunk($array, 2);

        $chunks = $collection->chunk(3);

        dd($chunks);
    }

    public function collectionChunkView(): View
    {
        $products = Product::latest()->paginate(9);

        return view('collection.chunk', compact('products'));
    }

    public function collectionCollapse()
    {
        $collection = collect([
            [1, 2, 3],
            [4, 5, 6],
            [7, 8, 9],
        ]);

        $collapsed = $collection->collapse();

        dd($collapsed);
    }

    public function collectionCombine()
    {
        $collection = collect(['name', 'age', 'city']);

        $combined = $collection->combine(['Antanas', 30, 'Vilnius']);
        //array_combine
        $php_combine = array_combine(
            ['key'],
            ['value']
        );

        dump($php_combine);

        dd($combined);
    }

    public function collectionConcat()
    {
        $collection = collect(['Vardas1']);

        $concatenated = $collection->concat(['Vardas2'])->concat(['name' => 'Vardas3'])->concat(['Vardas4']);

        dd($concatenated);
    }

    public function collectionContains()
    {
        $collection = collect([1, 5, 3, 4, 6, 5]);

        $contained = $collection->contains(function ($value, $key) {
            //dump($value > 4);
            return $value > 5;
        });

        dd($contained);
    }

    public function collectionContains2()
    {
        $collection = collect([
            'product' => 'Desk', 'price' => 200
            //['product' => 'Desk', 'price' => 200],
            //['product' => 'Chair', 'price' => 100],
        ]);

        //$contained = $collection->contains('product', 'Desk');
        //$contained = $collection->contains('price', 201);
        $contained = $collection->contains('Desk');

        dd($contained);
    }

    public function collectionCount()
    {
        $collection = collect([1, 2, 3, 4]);

        $counted = $collection->count();
        //count

        dd($counted);
    }

    public function collectionCountBy()
    {
        $collection = collect([1, 2, 2, 2, 3, 3, 4, 5, 5, 'mindaugas', 'mindaugas']);

        $counted = $collection->countBy();

        dd($counted);
    }

    public function collectionCountBy2()
    {
        $collection = collect(['alice@gmail.com', 'bob@yahoo.com', 'carlos@gmail.com', 'mindaugas.g@rrr.lt']);

        $counted = $collection->countBy(function ($email) {
            //dump(substr(strrchr($email, "@"), 1));
            return substr(strrchr($email, "@"), 1);
        });

        dd($counted);
    }

    public function collectionCrossJoin()
    {
        $collection = collect([1, 2, 3]);

        $matrix = $collection->crossJoin(['a', 'b', 'c']);
        // 1, a
        // 1, b
        // 2, a
        // 2, b

        dd($matrix);
    }

    public function collectionCrossJoin2()
    {
        $collection = collect([1, 2]);

        $matrix = $collection->crossJoin(['a', 'b'], ['I', 'II']);

        dd($matrix);
    }

    public function collectionDiff()
    {
        $collection = collect(['orange', 'apple', 'pear', 'kiwi', 'strawberry']);

        $diff = $collection->diff(['orange', 'banana', 'apple', 'pineapple', 'pear']);

        dd($diff);
    }

    public function collectionDiffAsoc()
    {
        $collection = collect([
            'name' => 'Desk',
            'color' => 'Black',
            'price' => 200,
        ]);

        $diff = $collection->diffAssoc([
            'name' => 'Table',
            'color' => 'Red',
            'price' => 200,
            'discount' => 20,
        ]);

        dd($diff);
    }

    public function collectionDiffKeys()
    {
        $collection = collect([
            'name' => 'Desk',
            'color' => 'Black',
            'price' => 200,
            'discount' => 20,
        ]);

        //array_diff_keys
        $diff = $collection->diffKeys([
            'name' => 'Desk',
            'color' => 'Black',
            'price' => 200,
            'used' => true,
        ]);

        dd($diff);
    }

    public function collectionDoesntContains()
    {
        $collection = collect([
            'product' => 'Desk', 'price' => 200
            //['product' => 'Desk', 'price' => 200],
            //['product' => 'Chair', 'price' => 100],
        ]);

        //$contained = $collection->contains('product', 'Desk');
        //$contained = $collection->contains('price', 201);
        $contained = $collection->doesntContain('Table');

        dd($contained);
    }

    public function collectionDuplicates()
    {
        //$collection = collect([1, 2, 3, 4, 1, '4']);
        //$duplicated = $collection->duplicates();
        $collection = collect([1, 2, 3, 4, 1, '4']);
        $duplicated = $collection->duplicatesStrict();

        //in_array('value', $array, true);


        dd($duplicated);
    }

    public function collectionEach()
    {
        $collection = collect([
            ['product' => 'Desk', 'price' => 200],
            ['product' => 'Chair', 'price' => 100],
        ]);

        // foreach ($collection as $key => $item)

        $collection->each(function ($item, $key) {
            if ($item['price'] > 100) {
                $item['discount'] = 5;
                dump($item);
            }
        });
    }

    public function collectionExcept()
    {
        $collection = collect(['product' => 'Desk', 'price' => 200, 'discount' => 10]);

        $excepted = $collection->except(['price', 'discount']);
        $only = $collection->only(['product', 'price']); // ['product' => 'Desk', 'price' => 200]

        dd($excepted);
    }

    public function collectionFilter()
    {
        $collection = collect([1, 2, 3, 4, 5]);

        $filtered = $collection->filter(function ($value, $key) {
           return $value > 2;
        });

        dd($filtered);
    }

    public function collectionFilterProducts()
    {
        $products = Product::latest()->paginate(10);
        //dd($products);

        $filtered = $products->filter(function ($value, $key) {
            return $value->price > 70;
        });

        dd($filtered);
    }

    public function collectionFirst()
    {
        $products = Product::latest()->paginate(10);

        $first = $products->first(function ($item, $key) {
            return $item->price > 100;
        });

        /*$first = $products->firstOrFail(function ($item, $key) {
            return $item->price > 100;
        });*/

        dd($first);
    }

    public function collectionForget()
    {
        $collection = collect(['product' => 'Desk', 'price' => 200, 'discount' => 10]);

        $forgeted = $collection->forget('price');

        dd($forgeted);
    }

    public function collectionGet()
    {
        $collection = collect(['product' => 'Desk', 'price' => 200, 'discount' => 10]);

        //$array['product']
        $value = $collection->get('product');
        //$value = $collection->get('products', 'Default name');

        dd($value);
    }

    public function collectionHas()
    {
        //$collection = collect(['product' => 'Desk', 'price' => 200, 'discount' => 10]);
        //dd($collection->has('products'));
        //dd($collection->has(['product', 'price']));

        $products = Product::latest()->paginate(10);

        $filtered = $products->filter(function ($item, $key) {
            //$collection = collect($item);
            //return $collection->has('price', 'name');
            return isset($item->price) && isset($item->name);
        });

        dd($filtered);
    }

    public function collectionImplode()
    {
        $collection = collect([
            ['product' => 'Desk', 'price' => 200, 'discount' => 10],
            ['product' => 'Table', 'price' => 100, 'discount' => 10]
        ]);

        $imploded = $collection->implode('product', '-');

        //implode('-', $array);
        $collection = collect(['product' => 'Desk', 'price' => 200, 'discount' => 10]);
        $imploded = $collection->implode('-');

        dd($imploded);
    }

    public function collectionIntersect()
    {
        $collection = collect(['orange', 'apple', 'pear', 'kiwi']);

        //array_intersect($array1, $array2);
        $intersected = $collection->intersect(['orange', 'apple', 'pear', 'strawberry']);

        dd($intersected);
    }

    public function collectionIntersectKey()
    {
        $collection = collect(['product' => 'Desk', 'price' => 300, 'discount' => 10]);

        //array_intersect_key($array1, $array2);
        $intersected = $collection->intersectByKeys(['product' => 'Desk', 'price' => 200]);

        dd($intersected);
    }

    public function collectionEmpty()
    {
        $collection = collect([]);

        dd($collection->isEmpty()); // true
        dd($collection->isNotEmpty()); // false
    }

    public function collectionMinMax()
    {
        $collection = collect([1, 2, 3, 5, 4]);

        dd($collection->max()); // 5
        dd($collection->min()); // 1
    }
}
