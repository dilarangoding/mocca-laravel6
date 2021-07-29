<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    public function child()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function scopeGetParent($query)
    {
        return $query->whereNull('parent_id');
    }

    // Mutator 

    public function setSlugAttribute($slug)
    {
        $this->attributes['slug'] = Str::slug($slug);
    }

    // Accessor

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
}
