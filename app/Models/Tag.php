<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
//    protected $with = ['products'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Get all the products that have this tag.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
