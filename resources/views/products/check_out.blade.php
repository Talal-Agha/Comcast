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
            <h1 class="pageTitle">Shipping information</h1>
            <div class="row">
                <div class="col-sm-12">
                    {!! Form::open(['route' => 'post_check_out', 'class' => 'form-horizontal']) !!}
                    <div class="row form-group">
                        <div class="col-sm-12">
                            {!! Form::label('email', null, ['class' => 'control-label']) !!}
                            {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-6">
                            {!! Form::label('first_name', null, ['class' => 'control-label']) !!}
                            {!! Form::text('first_name', null, ['placeholder' => 'First Name', 'class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-6">
                            {!! Form::label('last_name', null, ['class' => 'control-label']) !!}
                            {!! Form::text('last_name', null, ['placeholder' => 'Last Name', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-12">
                            {!! Form::label('address_1', null, ['class' => 'control-label']) !!}
                            {!! Form::text('address_1', null, ['placeholder' => 'Address 1', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-12">
                            {!! Form::label('address_2', null, ['class' => 'control-label']) !!}
                            {!! Form::text('address_2', null, ['placeholder' => 'Address 2', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-4">
                            {!! Form::label('city', null, ['class' => 'control-label']) !!}
                            {!! Form::text('city', null, ['placeholder' => 'City', 'class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-4">
                            {!! Form::label('state', null, ['class' => 'control-label']) !!}
                            {!! Form::select('state', App\Models\State::pluck('name', 'id'), [], ['placeholder' => 'State', 'class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-4">
                            {!! Form::label('zip', null, ['class' => 'control-label']) !!}
                            {!! Form::text('zip', null, ['placeholder' => 'Zip', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-12">
                            {!! Form::label('phone_number', null, ['class' => 'control-label']) !!}
                            {!! Form::text('phone_number', null, ['placeholder' => 'Phone Number', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <hr>
                    <h1 class="pageTitle">Billing information</h1>
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <label>
                                {!! Form::checkbox('same_address', true, true, ['id' => 'same_address']) !!} My Billing address is the same as my Shipping address.
                            </label>
                        </div>
                    </div>
                    <div id="billing_address" class="hide">
                        <div class="row form-group">
                            <div class="col-sm-12">
                                {!! Form::label('billing_full_name', 'Full Name', ['class' => 'control-label']) !!}
                                {!! Form::text('billing_full_name', null, ['placeholder' => 'Billing Full Name', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-12">
                                {!! Form::label('billing_address_1', 'Address 1', ['class' => 'control-label']) !!}
                                {!! Form::text('billing_address_1', null, ['placeholder' => 'Billing Address 1', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-12">
                                {!! Form::label('billing_address_2', 'Address 2', ['class' => 'control-label']) !!}
                                {!! Form::text('billing_address_2', null, ['placeholder' => 'Billing Address 2', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-4">
                                {!! Form::label('billing_city', 'City', ['class' => 'control-label']) !!}
                                {!! Form::text('billing_city', null, ['placeholder' => 'Billing City', 'class' => 'form-control']) !!}
                            </div>
                            <div class="col-sm-4">
                                {!! Form::label('billing_state', 'State', ['class' => 'control-label']) !!}
                                {!! Form::select('billing_state', App\Models\State::pluck('name', 'id'), [], ['placeholder' => 'Billing State', 'class' => 'form-control']) !!}
                            </div>
                            <div class="col-sm-4">
                                {!! Form::label('billing_zip', 'Zip', ['class' => 'control-label']) !!}
                                {!! Form::text('billing_zip', null, ['placeholder' => 'Billing Zip', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-12">
                                {!! Form::label('billing_phone_number', 'Phone Number', ['class' => 'control-label']) !!}
                                {!! Form::text('billing_phone_number', null, ['placeholder' => 'Billing Phone Number', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
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
    $(document).on('change', '#same_address', function(e) {
        $('#billing_address').toggleClass('hide');
    });
</script>
@endsection
