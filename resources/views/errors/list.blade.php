@if($errors->any())
<div class="alert alert-danger">
    <strong>Whoop!</strong> There are something wrong with your data:
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
