<?php

namespace App\Http\Controllers\user;

use App\Alamat;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Keranjang;
use App\Variant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{

    public function index()
    {

        $id_user = Auth::user()->id;
        $keranjangs = Keranjang::join('users', 'users.id', '=', 'keranjang.user_id')
            ->join('products', 'products.id', '=', 'keranjang.products_id')
            ->leftJoin('variants', 'variants.id', '=', 'keranjang.variant_id')
            ->select('products.name as nama_produk', 'products.image', 'users.name', 'keranjang.*', 'products.price', 'variants.warna', 'variants.ukuran')
            ->where('keranjang.user_id', '=', $id_user)
            ->get();

        // var_dump($keranjangs);
        // die();
        $cekalamat = Alamat::where('user_id', $id_user)->count();
        $data = [
            'keranjangs' => $keranjangs,
            'cekalamat'  => $cekalamat
        ];
        return view('user.keranjang', $data);
    }

    public function simpan(Request $request)
    {
        Keranjang::create([
            'user_id' => $request->user_id,
            'products_id' => $request->products_id,
            'qty' => $request->qty,
            'variant_id' => $request->variant_id
        ]);

        return redirect()->route('user.keranjang');
    }

    /**
     * I dont know, it seem never used
     */
    // function show_Names($n, $m)
    // {
    //     return ("The name is $n and email is $m, thank you");
    // }

    public function update(Request $request)
    {
        $index = 0;
        foreach ($request->id as $id) {
            $keranjang = Keranjang::findOrFail($id);
            $keranjang->qty = $request->qty[$index];
            $keranjang->save();
            $index++;
        }

        return redirect()->route('user.keranjang');
    }

    public function delete($id)
    {

        Keranjang::destroy($id);

        return redirect()->route('user.keranjang');
    }
}
