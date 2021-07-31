<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderDetail()
    {
        return $this->hasOne(OrderDetail::class);
    }

    // accessor
    public function getStatusLabelAttribute()
    {
        if ($this->status == 0) {
            return '<span class="badge badge-secondary">Draft</span>';
        }
        return '<span class="badge badge-success">Publish</span>';
    }

    public function setSlugAttribute($slug)
    {
        $this->attributes['slug'] = Str::slug($slug);
    }
}
