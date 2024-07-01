<?php

namespace App\Http\Controllers\user;

use App\Alamat;
use App\Http\Controllers\Controller;
use App\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class CheckoutController extends Controller
{
    public function index($jasa_kirim = 'jne')
    {
        //ambil session user id
        $id_user = Auth::user()->id;

        //ambil produk apa saja yang akan dibeli user dari table keranjang
        $carts = Keranjang::join('users', 'users.id', '=', 'keranjang.user_id')
            ->join('products', 'products.id', '=', 'keranjang.products_id')
            ->select('products.name as nama_produk', 'products.image', 'products.weigth', 'users.name', 'keranjang.*', 'products.price')
            ->where('keranjang.user_id', '=', $id_user)
            ->get();

        //lalu hitung jumlah berat total dari semua produk yang akan di beli
        $berattotal = 0;
        foreach ($carts as $item) {
            $berattotal += ( $item->weigth * $item->qty );
        }

        

        //lalu ambil id kota si pelanngan
        $city_destination = Alamat::where('is_utama', 1)->first()->cities_id;
        
        $alamat_pembeli = Alamat::join('cities', 'cities.city_id', '=', 'alamat.cities_id')
        ->join('provinces', 'provinces.province_id', '=', 'cities.province_id')
        ->select('alamat.*', 'cities.title as kota', 'provinces.title as provinsi')
        ->where('alamat.user_id', $id_user)->get();
        // var_dump($alamat_pembeli);
        // die();

        

        //ambil id kota toko
        $alamat_toko = DB::table('alamat_toko')->first();

        //lalu hitung ongkirnya
        $cost = RajaOngkir::ongkosKirim([
            'origin'        => $alamat_toko->city_id,
            'destination'   => $city_destination,
            'weight'        => $berattotal,
            'courier'       => $jasa_kirim
        ])
        ->get();

        //ambil hasil nya
        $ongkir =  $cost[0]['costs'][0]['cost'][0]['value'];

        //lalu ambil alamat user untuk ditampilkan di view
        $alamat_user = Alamat::join('cities', 'cities.city_id', '=', 'alamat.cities_id')
            ->join('provinces', 'provinces.province_id', '=', 'cities.province_id')
            ->select('alamat.*', 'cities.title as kota', 'provinces.title as prov')
            ->where('alamat.user_id', $id_user)
            ->where('alamat.is_utama', 1)
            ->first();

        //buat kode invoice sesua tanggalbulantahun dan jam
        return view('user.checkout', [
            'invoice' => 'ALV' . Date('Ymdhi'),
            'keranjangs' => $carts,
            'ongkir' => $ongkir,
            'alamat' => $alamat_user,
            'jasa_kirim' => $jasa_kirim,
            'alamat_pembeli' => $alamat_pembeli
        ]);
    }

    public function set_alamat()
    {
        $id_user = Auth::user()->id;
        $alamat_pembeli = Alamat::join('cities', 'cities.city_id', '=', 'alamat.cities_id')
        ->join('provinces', 'provinces.province_id', '=', 'cities.province_id')
        ->select('alamat.*', 'cities.title as kota', 'provinces.title as provinsi')
        ->where('alamat.user_id', $id_user)->get();

        $alamatSelect = Alamat::join('cities', 'cities.city_id', '=', 'alamat.cities_id')
            ->join('provinces', 'provinces.province_id', '=', 'cities.province_id')
            ->select('alamat.*', 'cities.title as kota', 'provinces.title as prov')
            ->where('alamat.user_id', $id_user)
            ->where('alamat.is_utama', 1)
            ->first();
        
        return view('user.set_alamat',[
            'alamat_pembeli' => $alamat_pembeli,
            'alamatSelect' => $alamatSelect
        ]);
    }

    public function set_alamat_utama($id)
    {
        $id_user = Auth::user()->id;

        Alamat::where('user_id', $id_user)->update(['is_utama' => 0]);

        Alamat::where('id', $id)->where('user_id', $id_user)->update(['is_utama' => 1]);

        return redirect()->back()->with('status', 'Alamat utama telah diubah.');
    }
}
