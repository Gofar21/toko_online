<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Categories;
use App\Variant;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        //membawa data produk yang di join dengan table kategori
        $products = Product::join('categories', 'categories.id', '=', 'products.categories_id')
            ->select('products.*', 'categories.name as nama_kategori')
            ->get();

        return view('admin.product.index', compact('products'));
    }

    public function tambah()
    {
        //menampilkan form tambah kategori

        $categories = Categories::all();

        return view('admin.product.tambah', compact('categories'));
    }

    public function store(Request $request)
    {
        if ($request->file('image')) {
            //simpan foto produk yang di upload ke direkteri public/storage/imageproduct
            $file = $request->file('image')->store('imageproduct', 'public');

            $product = Product::create([
                'name'          => $request->name,
                'description'   => $request->description,
                'price'         => $request->price,
                'stok'          => $request->stok,
                'weigth'        => $request->weigth,
                'categories_id' => $request->categories_id,
                'image'         => $file

            ]);

            if ($request->has('ukuran') && $request->has('warna')) {
                // echo "ada variant";
                foreach ($request->ukuran as $index => $ukuran) {
                    // echo 'ukuran'.$ukuran;
                    // echo '<br>';
                    // echo 'warnanya:' .$request->warna[$index];
                    $variant = new Variant();
                    $variant->produk_id = $product->id;
                    $variant->ukuran = $ukuran;
                    $variant->warna = $request->warna[$index];
                    if (isset($request->gambarVariant[$index])) {
                        $variant->gambar = $request->gambarVariant[$index]->store('variants', 'public');
                    }
                    $variant->save();
                }
            }

            return redirect()->route('admin.product')->with('status', 'Berhasil Menambah Produk Baru');
        }
    }

    public function edit(Product $id)
    {
        $product = Product::with('variants')->find($id->id);

        return view('admin.product.edit', [
            'product' => $product,
            'categories' => Categories::all(),
            'variants' => $product->variants
        ]);
    }

    public function update(Product $id, Request $request)
    {
        $prod = $id;
    
        if ($request->file('image')) {
            Storage::delete('public/' . $prod->image);
            $file = $request->file('image')->store('imageproduct', 'public');
            $prod->image = $file;
        }
    
        $prod->name = $request->name;
        $prod->description = $request->description;
        $prod->price = $request->price;
        $prod->weigth = $request->weigth;
        $prod->categories_id = $request->categories_id;
        $prod->stok = $request->stok;
        $prod->promo = $request->promo;
        $prod->save();
    
        // Update Variants
        if ($request->has('variants')) {
            foreach ($request->variants as $variant) {
                if (isset($variant['id'])) {
                    // Update existing variant
                    $existingVariant = Variant::find($variant['id']);
                    if ($existingVariant) {
                        if (isset($variant['delete']) && $variant['delete'] == 'true') {
                            // Delete variant
                            Storage::delete('public/' . $existingVariant->gambar);
                            $existingVariant->delete();
                        } else {
                            $existingVariant->ukuran = $variant['ukuran'];
                            $existingVariant->warna = $variant['warna'];
    
                            if (isset($variant['gambar'])) {
                                Storage::delete('public/' . $existingVariant->gambar);
                                $file = $variant['gambar']->store('imagevariant', 'public');
                                $existingVariant->gambar = $file;
                            }
    
                            $existingVariant->save();
                        }
                    }
                } else {
                    // Create new variant
                    $newVariant = new Variant();
                    $newVariant->produk_id = $prod->id;
                    $newVariant->ukuran = $variant['ukuran'];
                    $newVariant->warna = $variant['warna'];
    
                    if (isset($variant['gambar'])) {
                        $file = $variant['gambar']->store('imagevariant', 'public');
                        $newVariant->gambar = $file;
                    }
    
                    $newVariant->save();
                }
            }
        }
    
        return redirect()->route('admin.product')->with('status', 'Berhasil Mengubah Produk');
    }
    

    public function delete(Product $id)
    {
        //mengahapus produk
        Storage::delete('public/' . $id->image);
        $id->delete();

        return redirect()->route('admin.product')->with('status', 'Berhasil Mengahapus Produk');
    }
}
