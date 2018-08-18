@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <span>Create new coupon code</span>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="pull-right"> Logout </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>

        <div class="panel-body">
            @include('errors.list')
            {!! Form::open(['route' => 'coupon-codes.store']) !!}
                @include('coupon_codes.form', ['button' => 'Save'])
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
