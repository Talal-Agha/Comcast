<div class="form-group">
    {!! Form::label('name', null, []) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::submit($button, ['class' => 'btn btn-primary']) !!}
    <a href="{{ url('admin?product-types=1') }}" class="btn btn-default pull-right">List product types</a>
</div>
