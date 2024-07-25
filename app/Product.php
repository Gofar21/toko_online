<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = 'products';
    protected $fillable = ['name','image','description','price','weigth','categories_id','stok'];

    public function variants()
    {
        return $this->hasMany(Variant::class, 'produk_id');
    }
}
