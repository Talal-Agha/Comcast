@extends('layouts.app')

@section('content')
<?php
    $cookie = isset($_COOKIE['comcast_cart_items_cookie']) ? $_COOKIE['comcast_cart_items_cookie'] : '';
    $cookie = stripslashes($cookie);
    $saved_cart_items = json_decode($cookie, true);
?>
<main class="page-main">
    <div class="container">
        <hr>
        <div class="default-region">
            <h1 class="pageTitle">Shopping Cart</h1>
            @if (!count($saved_cart_items))
            <p>You don't have any item in the cart! <a href="{{ route('products.index') }}">Shop now!</a></p>
            @else
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Product</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Remove</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total = 0; ?>
                                @foreach ($saved_cart_items as $key => $item)
                                <?php $product = App\Models\Product::findOrFail($key); ?>
                                <?php $total += $product->price*$item['quantity']; ?>
                                <tr>
                                    <td class="text-center">{{ $product->name }}</td>
                                    <td class="text-right">${{$product->price}}</td>
                                    <td class="text-center">
                                        {!! Form::open(['route' => 'update_cart', 'method' => 'PATCH', 'class' => 'text-center']) !!}
                                        {!! Form::hidden('product_id', $product->id, []) !!}
                                        {!! Form::number('quantity', $item['quantity'], ['min' => 1]) !!}
                                        {!! Form::submit('Update', ['class' => '']) !!}
                                        {!! Form::close() !!}
                                    </td>
                                    <td class="text-center">
                                        {!! Form::open(['route' => 'remove_from_cart', 'class' => 'text-center']) !!}
                                        {!! Form::hidden('product_id', $product->id, []) !!}
                                        {!! Form::submit('Remove', ['class' => 'btn-danger']) !!}
                                        {!! Form::close() !!}
                                    </td>
                                    <td class="text-right">${{$product->price*$item['quantity'] }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Subtotal</td>
                                    <td class="text-right ">${{$total}}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Sales Tax</td>
                                    <td class="text-right warning">${{$total*8.375/100}}</td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Discount</td>
                                    <td class="text-right danger">
                                        <?php
                                            $discount = 0;
                                            if (session('discount_type') == 'percent') {
                                                $discount = (($total + ($total*8.375/100)) * session('discount')/100);
                                            } else {
                                                $discount = session('discount');
                                            }
                                        ?>
                                        ${{$discount}}{{ session('discount_type') == 'percent' ? '(' . session('discount') . '%)' : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Order total</td>
                                    <td class="text-right success">${{ $total + ($total*8.375/100) - $discount}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    {!! Form::open(['route' => 'apply_coupon_code']) !!}
                    <div class="form-group">
                        {!! Form::label('coupon_code', null, ['class' => 'control-label']) !!}
                        {!! Form::text('coupon_code', null, ['class' => 'form-control']) !!}
                        <p class="help-block">Enter your coupon code here.</p>
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Add coupon', ['class' => 'btn btn-basic']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-12 text-center">
                        <a href="{{ route('check_out') }}" class="btn btn-primary checkout-btn">Check out</a>
                    </div>
                </div>
            </div>
            @endif
            <br>
        </div>
    </div>
</main>
@endsection

@section('footer_js')
@endsection
