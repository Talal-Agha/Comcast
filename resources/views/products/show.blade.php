@extends('layouts.app')

@section('content')
<?php
    // read items in the cart
    $cookie = isset($_COOKIE['comcast_cart_items_cookie']) ? $_COOKIE['comcast_cart_items_cookie'] : "";
    $cookie = stripslashes($cookie);
    $saved_cart_items = json_decode($cookie, true);
    if ($saved_cart_items == null) {
        $saved_cart_items = [];
    }
?>
<style type="text/css">
.text-center{
    background: white;
}
.productImage{
width:100%;
}
</style>

<div id="learn-more" class="container">
    <div class="row">
        <div class="col-md-4">
            <img class="productImage" src="{{ $product->image }}">
        </div>
        <div class="col-md-8">
            <h2>{{ $product->name }}</h2>
            <hr>
            <h3>${{ $product->price }}</h3>
            <hr>
            <p>{{ $product->description}}</p>
            <div>
                <hr>
            @if (array_key_exists($product->id, $saved_cart_items))
            <a class="btn btn-default" style="background:#ccc" href="https://xfinity.easyzigbee.com/cart">Go to Cart </a>            
            @else
            {!! Form::open(['route' => 'add_to_cart',]) !!}
            {!! Form::hidden('product_id', $product->id, []) !!}
            {!! Form::hidden('quantity', 1, ['min' => 1]) !!}
           Quantity: {!! Form::number('quantity', 1, ['min' => 1]) !!}
            {!! Form::submit('Buy Now', ['class' => 'btn btn-default float-right']) !!}
            {!! Form::close() !!}
            @endif
        </div>
        <hr>

        </div>
        <div class="row">
        </div>
        </div>
<br><br><br>
    <div class="page-banner text-center">
        <h2>More Info:</h2>
</div>
       @foreach ($product->detail_images as $key => $detail_image)
        <img class="productImage" alt="{{ $product->name }}" src="{{ $product->getDetailImage($detail_image) }}" height="auto">
        @endforeach 
    
</div>

   {{-- <!-- <div class="container">
        <div class="default-region">
            <h1 class="pageTitle">{{ $product->name }}</h1>
            <h3 class="text-center">Installation Guide: {{ $product->name }}<iframe src="{{ $product->video_link }}" width="640" height="360" frameborder="0"></iframe></h3>
        </div>
    </div> -->--}}
@endsection
