@extends('layouts.app')

@section('css')
@endsection

@section('content')
<main class="page-main">
    <div class="container">
        <div class="default-region">
            <div class="row">
                <div class="col-sm-12">
                  <h1>Thank You!</h1>
                  <h3>Your order number is : {{$order->orderId}} </h3>
                    <hr>
                   <p class="order-confirm"> Your order has been placed successfully. Please print this message, or record the Order. You will also be emailed a confirmation message containing important information regarding your order.</p>
  <table class="table table-hover">
    <tbody>
      <tr>
        <td><b>Order Id/Number</b></td>
        <td>{{$order->orderId}}</td>
      </tr>
      <tr>
        <td><b>Shipping Method</b></td>
        <td>{{$order->shipping_option}}</td>
      </tr>
       <tr>
        <td><b>Shipping Amount</b></td>
        <td>{{$order->shipping_amount}}</td>
      </tr>
      <tr>
        <td><b>Payment Status</b></td>
@if($order->paid == 1)
<td>Paid</td>
@elseif($order->paid == 0)
<td>Not Paid</td>
@else
<td>N/A</td>
@endif
      </tr>
 <tr>
        <td><b>Total Amount</b></td>
        <td>{{$order->total}}</td>
      </tr>  
</tbody>
  </table>                
</div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('footer_js')
@endsection
