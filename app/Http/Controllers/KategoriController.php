<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Categories;
use Illuminate\Support\Facades\DB;
class KategoriController extends Controller
{
    public function produkByKategori($id)
    {
       $produk = Product::where('categories_id',$id)->paginate(5);
       $categories = Categories::where('id', $id)->get();
        return view('user.kategori', [
            'produks' => $produk,
            'categories' => $categories
        ]);
    }
}
