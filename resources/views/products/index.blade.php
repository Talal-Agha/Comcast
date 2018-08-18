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
<main class="page-main">
    <div class="page-banner">
        <img alt="ZigBee Products banner" src="{{ asset('/images/ZigBeeProductsBanner.jpg') }}" height="auto" width="100%">
    </div>
    <div class="container">
        <div class="default-region">
            <h1 class="pageTitle text-center">GE ZigBee Products</h1>
            <br>
            <div id="prod-index" class="container">
  
                    @foreach ($products->chunk(4) as $chunk)
                    <div class="row">
                        @foreach ($chunk as $product)
                        <div id="prod-index" class="prod-tile col-md-3">
                            <p class="text-center">
                                <a href="{{ route('products.show', $product->id) }}"><img alt="{{ $product->name }}" src="{{ $product->image }}"></a>
                            </p>
                            <p class="text-center">
                                <span class="prod-info">{{ $product->name }}</span>
                                <br>
                           {{-- <!--   <span class="prod-info">{{ $product->product_type->name }}</span>
                                <br> --> --}} 
                                <span class="prod-info">${{$product->price}}</span>
                                @if ($product->id == 10)
                                <br><span class="addon-span text-center">  *This item does not function independently</span>
                                @endif
                                <br><br>

                                <a class="btn btn-default" href="{{ route('products.show', $product->id) }}">Learn More</a>
                            </p>
                            <p class="text-center">

                                @if (array_key_exists($product->id, $saved_cart_items))
                                <a class="btn btn-default" style="background:#ccc" href="https://xfinity.easyzigbee.com/cart">Go to Cart </a>

                                @elseif ($product->id == 10)
                                {!! Form::open(['route' => 'add_to_cart', 'class' => 'text-center']) !!}
                                {!! Form::hidden('product_id', $product->id, []) !!}
                                {!! Form::submit('Add To Cart', ['class' => 'btn btn-default', 'id' => 'addon']) !!}<br><br>
                               {{-- <!-- {!! Form::number('quantity', 1, ['min' => 1]) !!}<br> --> --}}
                                {!! Form::close() !!}


                                @else
                                {!! Form::open(['route' => 'add_to_cart', 'class' => 'text-center']) !!}
                                {!! Form::hidden('product_id', $product->id, []) !!}
                                {!! Form::submit('Add To Cart', ['class' => 'btn btn-default']) !!}<br><br>
                               {{-- <!-- {!! Form::number('quantity', 1, ['min' => 1]) !!}<br> --> --}}
                                {!! Form::close() !!}
                                @endif

                            </p>
                            <p class="text-center">&nbsp;</p>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
        </div>
    </div>
    
</main>

        <script>
                window.onload=function()
                {
                    var el=document.getElementById('addon');
                    el.onclick=function(){
                        var my_text=alert('This item does NOT function independently.');
                    }
                }
        </script>
@endsection

@section('footer_js')
@endsection
