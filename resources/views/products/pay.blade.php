@extends('layouts.app')

@section('css')
@endsection

@section('content')
<main class="page-main">
    <div class="container">
        <div class="default-region">
            <div class="row">
                <div class="col-sm-12">
                    <div class="creditCardForm">
                        <div class="heading text-center">
                            <h1>Confirm Purchase</h1>
                            <h4>Total: ${{ App\Models\Order::find(request('order'))->total }}</h4>
                        </div>
                        <div class="payment">
                            <form accept-charset="UTF-8" action="" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="pk_test_OKWnvvdkVhlMhI7LjnBiu9XN" id="payment-form" method="post">
                                {!! Form::hidden('order', request('order'), []) !!}
                                {{ csrf_field() }}
                                <div class="form-group owner">
                                    <label for="owner">Cardholder name</label>
                                    <input type="text" class="form-control" id="owner">
                                </div>
                                <div class="form-group" id="card-number-field">
                                    <label for="cardNumber">Card Number</label>
                                    <input type="text" class="form-control" id="cardNumber">
                                </div>
                                <div class="form-group" id="expiration-date">
                                    <label>Expiration Date</label>
                                    <select id="expirationMonth">
                                        <option value="01" selected>January</option>
                                        <option value="02">February </option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                    <select id="expirationYear">
                                        <option value="2018" selected> 2018</option>
                                        <option value="2019"> 2019</option>
                                        <option value="2020"> 2020</option>
                                        <option value="2021"> 2021</option>
                                        <option value="2022"> 2022</option>
                                        <option value="2023"> 2023</option>
                                        <option value="2024"> 2024</option>
                                        <option value="2025"> 2025</option>
                                        <option value="2026"> 2026</option>
                                    </select>
                                </div>
                                <div class="form-group CVV">
                                    <label for="cvv">CVV</label>
                                    <input type="text" class="form-control" id="cvv">
                                </div>
                                <div class="form-group" id="credit_cards">
                                    <img src="{{ asset('images/visa.jpg') }}" id="visa" class="hide">
                                    <img src="{{ asset('images/mastercard.jpg') }}" id="mastercard" class="hide">
                                    <img src="{{ asset('images/amex.jpg') }}" id="amex" class="hide">
                                </div>
                                <div class="form-group" id="pay-now">
                                    <button type="button" class="btn btn-default" id="confirm-purchase">Submit <i class="fa fa-spinner fa-spin hide" aria-hidden="true"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('footer_js')
<script src="https://js.stripe.com/v2/"></script>
<script src="{{ asset('js/jquery.payform.min.js') }}"></script>
<script src="{{ asset('js/pay.js') }}"></script>
@endsection
