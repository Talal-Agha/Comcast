@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <span>Update product type {{ $product_type->name }}</span>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="pull-right"> Logout </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>

        <div class="panel-body">
            @include('errors.list')
            {!! Form::model($product_type, ['route' => ['product-types.update', $product_type->id], 'method' => 'PATCH']) !!}
                @include('product_types.form', ['button' => 'Update'])
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
