<div class="form-group">
    {!! Form::label('coupon_code', null, []) !!}
    {!! Form::text('coupon_code', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('type', null, []) !!}
    {!! Form::select('type', ['percentage', 'number'], null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('amount', null, []) !!}
    {!! Form::text('amount', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <label>{!! Form::checkbox('active', true, !empty($coupon_code) && $coupon_code->active, []) !!} Active</label>
</div>
<div class="form-group">
    {!! Form::submit($button, ['class' => 'btn btn-primary']) !!}
    <a href="{{ url('admin?coupon-codes=1') }}" class="btn btn-default pull-right">List coupon codes</a>
</div>
