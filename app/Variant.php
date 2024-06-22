<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $table = 'variants';
    protected $fillable = ['produk_id', 'ukuran', 'warna', 'gambar'];
}
