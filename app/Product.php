<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
 * Class Product
 *
 * @mixin \Eloquent
 * */
class Product extends Model
{
    protected $guarded = [];

    public function track()
    {
        return $this->stock->each->track();
    }

    public function inStock()
    {
        return $this->stock()->where('in_stock', true)->exists();
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }
}
