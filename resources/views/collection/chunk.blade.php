@extends('layout')

@section('content')

    @foreach ($products->chunk(4) as $chunk)
        <div class="card-group">
            @foreach ($chunk as $product)
                <div class="card">
                    <div class="card-header">
                        {{ $product->name }}
                    </div>
                    <div class="card-body">
                        <p>{{ $product->description }}</p>
                        <span>SKU: {{ $product->sku }}</span>
                    </div>
                    <div class="card-footer">
                        Price: {{ $product->price }}
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach

@endsection
