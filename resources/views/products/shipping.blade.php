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
            <h1 class="pageTitle text-center">Shipping</h1>
            <br><br>
            <div class="row">
                <div class="col-sm-12">
                    {!! Form::open(['route' => 'post_shipping', 'class' => 'form-horizontal']) !!}
                      {{ csrf_field() }}
                    <div class="row form-group">
                        {!! Form::hidden('order', request('order'), []) !!}
                        <div class="col-sm-6 text-center">
                            {!! Form::hidden('amount', $ratePriorityMail->Rate, []) !!}
                           <img src="https://rocketdock.com/images/screenshots/USPS-1.png" alt="" width="150px">
                            <br>
                            <br>
                            <label data-rate="{{ $ratePriorityMail->Rate }}">
                                {!! Form::radio('rate',"USPS Priority Mail", false, []) !!} ${{ $ratePriorityMail->Rate }}
                            </label>
                            <p><b>USPS Priority Mail</b></p>
                        </div>
                        <div class="col-sm-6 text-center">
                            {!! Form::hidden('amount', $rateServiceExpress->Rate, []) !!}
                          <img src="https://rocketdock.com/images/screenshots/USPS-1.png" alt="" width="150px">
                            <br>
                            <br>
                            <label data-rate="{{ $rateServiceExpress->Rate }}">
                                {!! Form::radio('rate', "USPS Service Express", false, []) !!} ${{ $rateServiceExpress->Rate }}
                            </label>
                            <p><b>USPS Service Express</b></p>
                        </div>
                    </div><br><br>
                    <div class="form-group text-center">
                        {!! Form::submit('Continue to next step', ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('footer_js')
<script>
    $(document).on('change', 'input[name="rate"]', function(e) {
        $('input[name="amount"]').val($(this).closest('label').data('rate'));
    });
</script>
@endsection
