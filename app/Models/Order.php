<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'address_1',
        'address_2',
        'city',
        'state',
        'zip',
        'phone_number',
        'same_address',
        'billing_full_name',
        'billing_address_1',
        'billing_address_2',
        'billing_city',
        'billing_state',
        'billing_zip',
        'billing_phone_number',
        'tracking_number',
        'tracking_url_provider',
        'label_url',
        'total',
        'paid',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    public function shippingAddress()
    {
        return [
            'name' => $this->first_name . $this->last_name,
            'street1' => $this->address_1,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'country' => 'US',
            'phone' => $this->phone_number,
            'email' => $this->email,
        ];
    }
}
