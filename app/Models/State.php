<?php

namespace App\Models;

use App\Models\City;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
