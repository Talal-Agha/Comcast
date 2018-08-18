<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function create()
    {
        return view('product_types.create');
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required|string',
        ]);
        ProductType::create($data);
        flash('Product type has been created successfully!')->success();
        return back();
    }

    public function edit(ProductType $product_type)
    {
        return view('product_types.edit', compact('product_type'));
    }

    public function update(ProductType $product_type)
    {
        $data = request()->validate([
            'name' => 'required|string',
        ]);
        $product_type->update($data);
        flash('Product type has been updated successfully!')->success();
        return back();
    }

    public function destroy(ProductType $product_type)
    {
dd($product_type);
        $product_type->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Product type has been deleted'
        ]);
    }
}
