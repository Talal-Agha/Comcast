<div class="form-group">
    {!! Form::label('name', null, []) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('description', null, []) !!}
    {!! Form::textArea('description', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('image', null, []) !!}
    {!! Form::file('image', ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('price', null, []) !!}
    {!! Form::number('price', null, ['class' => 'form-control', 'step' => 0.01, 'min' => 0]) !!}
</div>
<div class="form-group">
    {!! Form::label('sku', null, []) !!}
    {!! Form::number('sku', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('detail_images', null, []) !!}
    {!! Form::file('detail_images[]', ['class' => 'form-control', 'multiple']) !!}
</div>
<div class="form-group">
    {!! Form::label('product_type', null, []) !!}
    {!! Form::select('product_type_id', App\Models\ProductType::pluck('name', 'id'), empty($product) ? null : $product->product_type->id, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('video_link', null, []) !!}
    {!! Form::text('video_link', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::submit($button, ['class' => 'btn btn-primary']) !!}
    <a href="{{ url('admin?products=1') }}" class="btn btn-default pull-right">List products</a>
</div>
