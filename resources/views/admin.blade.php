@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <ul class="nav nav-tabs">
        <li class="{{ request('products') ? 'active' : '' }}"><a data-toggle="tab" href="#products">Products</a></li>
        <li class="{{ request('product-types') ? 'active' : '' }}"><a href="{{ url('admin?product-types=1') }}">Product Types</a></li>
        <li class="{{ request('orders') ? 'active' : '' }}"><a href="{{ url('admin?orders=1') }}">Orders</a></li>
        <li class="{{ request('coupon-codes') ? 'active' : '' }}"><a href="{{ url('admin?coupon-codes=1') }}">Coupon Codes</a></li>
    </ul>
    <div class="tab-content">
        <div id="products" class="tab-pane fade {{ request('products') ? 'in active' : '' }}">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span>Products management</span>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="pull-right"> Logout </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>

                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="{{ route('products.create') }}" class="btn btn-success">Create new product</a>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Detail Images</th>
                                            <th>Price</th>
                                            <th>Product Type</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $key => $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td><img alt="{{ $product->name }}" src="{{ $product->image }}"></td>
                                            <td>
@if(count($product->detail_images))
                                                @foreach ($product->detail_images as $detail_image)
                                                <img alt="{{ $product->name }}" src="{{ $product->getDetailImage($detail_image) }}" width="50%">
                                                @endforeach
@endif
                                            </td>
                                            <td>${{ $product->price }}</td>
                                            <td>{{ $product->product_type->name }}</td>
                                            <td>{{ $product->created_at->diffForHumans() }}</td>
                                            <td>{{ $product->updated_at->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Update</a>
                                                <br>
                                                <br>
                                                <a href="{{ route('products.destroy', $product->id) }}" class="btn btn-danger" data-method="delete">Delete</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $products->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="product_types" class="tab-pane fade {{ request('product-types') ? 'in active' : '' }}">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span>Product Types management</span>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="pull-right"> Logout </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>

                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="{{ route('product-types.create') }}" class="btn btn-success">Create new product type</a>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Products</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product_types as $key => $product_type)
                                        <tr>
                                            <td>{{ $product_type->name }}</td>
                                            <td>
                                                @foreach ($product_type->products as $product)
                                                <p>{{ $product->name }}</p>
                                                @endforeach
                                            </td>
                                            <td>{{ $product_type->created_at->diffForHumans() }}</td>
                                            <td>{{ $product_type->updated_at->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('product-types.edit', $product_type->id) }}" class="btn btn-primary">Update</a>
                                                <br>
                                                <br>
                                                <a href="{{ route('product-types.destroy', $product_type->id) }}" class="btn btn-danger" data-method="delete">Delete</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $product_types->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="orders" class="tab-pane fade {{ request('orders') ? 'in active' : '' }}">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span>Orders</span>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="pull-right"> Logout </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Order Tracking</th>
                                            <th>Label</th>
                                            <th>Products - Quantity</th>
                                            <th>Total Value</th>
                                            <th>Status</th>
                                            <th>Email</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $key => $order)
                                        <tr>
                                            <td>{{ $order->tracking_number }}</td>
                                            <td><a href="{{ $order->tracking_url_provider }}" target="_blank">Click to view order tracking</a></td>
                                            <td><a href="{{ $order->label_url }}" target="_blank">Click to open</a></td>
                                            <td>
                                                @foreach ($order->products as $product)
                                                {{ $product->name }} - {{ $product->pivot->quantity }}
                                                @endforeach
                                            </td>
                                            <td>${{ $order->total }}</td>
                                            <td class="{{ $order->paid ? 'success' : 'danger' }}">{{ $order->paid ? 'Paid' : 'Unpaid' }}</td>
                                            <td>{{ $order->email }}</td>
                                            <td>{{ $order->created_at->diffForHumans() }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="coupon_codes" class="tab-pane fade {{ request('coupon-codes') ? 'in active' : '' }}">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span>Coupon Codes</span>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="pull-right"> Logout </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="{{ route('coupon-codes.create') }}" class="btn btn-success">Create new coupon code</a>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Active</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($coupon_codes as $key => $code)
                                        <tr>
                                            <td>{{ $code->coupon_code }}</td>
                                            <td>{{ $code->type }}</td>
                                            <td>{{ $code->amount }}</td>
                                            <td class="{{ $code->active ? 'success' : 'danger' }}">{{ $code->active ? 'Active' : 'Un-active' }}</td>
                                            <td>{{ $code->created_at->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('coupon-codes.edit', $code->id) }}" class="btn btn-primary">Update</a>
                                                <br>
                                                <br>
                                                <a href="{{ route('coupon-codes.destroy', $code->id) }}" class="btn btn-danger" data-method="delete">Delete</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_js')
<script>
    $(document).on('click', 'a.btn-danger', function(e) {
        e.preventDefault();
        var $this = $(this);
        if (confirm('Are you sure you want to delete?')) {
            $.post({
                type: $this.data('method'),
                url: $this.attr('href'),
                data: {
                  "_token": "{{ csrf_token() }}"
              }
            }).done(function (data) {
                $this.closest('td').closest('tr').remove();
            });
        }
    });
</script>
@endsection
