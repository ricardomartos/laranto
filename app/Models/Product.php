<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['tags','simple'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','description','sku','in_stock','price','product_id'];

    /**
     * Get all tags of a product.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function simple()
    {
        return $this->hasMany(__CLASS__);
    }

}
