<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
