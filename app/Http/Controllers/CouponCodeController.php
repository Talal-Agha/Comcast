<?php

namespace App\Http\Controllers;

use App\Models\CouponCode;
use Illuminate\Http\Request;

class CouponCodeController extends Controller
{
    public function create()
    {
        return view('coupon_codes.create');
    }

    public function store()
    {
        $data = request()->validate([
            'coupon_code' => 'required|string',
            'type' => 'required',
            'amount' => 'required',
            'active' => 'sometimes',
        ]);
        if ($data['type']) {
            $data['type'] = 'number';
        } else {
            $data['type'] = 'percent';
        }
        CouponCode::create($data);
        flash('Coupon code has been created successfully!')->success();
        return back();
    }

    public function edit(CouponCode $coupon_code)
    {
        return view('coupon_codes.edit', compact('coupon_code'));
    }

    public function update(CouponCode $coupon_code)
    {
        $data = request()->validate([
            'coupon_code' => 'required|string',
            'type' => 'required',
            'amount' => 'required',
            'active' => 'sometimes',
        ]);
        if ($data['type']) {
            $data['type'] = 'number';
        } else {
            $data['type'] = 'percent';
        }
        $coupon_code->update($data);
        flash('Coupon code has been updated successfully!')->success();
        return back();
    }

    public function destroy(CouponCode $coupon_code)
    {
        $coupon_code->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Coupon code has been deleted'
        ]);
    }
}
