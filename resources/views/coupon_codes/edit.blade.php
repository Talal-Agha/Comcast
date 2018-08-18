@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <span>Update coupon code {{ $coupon_code->coupon_code }}</span>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="pull-right"> Logout </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>

        <div class="panel-body">
            @include('errors.list')
            {!! Form::model($coupon_code, ['route' => ['coupon-codes.update', $coupon_code->id], 'method' => 'PATCH']) !!}
                @include('coupon_codes.form', ['button' => 'Update'])
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
