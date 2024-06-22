@extends('user.app')
@section('content')
<div class="bg-light py-3">
    <div class="container">
    <div class="row">
        <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Tank Top T-Shirt</strong></div>
    </div>
    </div>
</div>  

<div class="site-section">
    <div class="container">
    <div class="row">
        <div class="col-md-6">
        <img  id="mainImage" src="{{ asset('storage/'.$produk->image) }}" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6">
        <h2 class="text-black">{{ $produk->name }}</h2>
        <p>
            {{ $produk->description }}
        </p>
        <p><strong class="text-primary h4">Rp {{ $produk->price }} </strong></p>
        <div class="mb-5">
            <form action="{{ route('user.keranjang.simpan') }}" method="post">
                @csrf
                @if(Route::has('login'))
                    @auth
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    @endauth
                @endif
            <input type="hidden" name="products_id" value="{{ $produk->id }}">
            <small>Sisa Stok {{ $produk->stok }}</small>
            <input type="hidden" value="{{ $produk->stok }}" id="sisastok">
            <div class="input-group mb-3" style="max-width: 120px;">
            <div class="input-group-prepend">
            <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
            </div>
            <input type="text" name="qty" class="form-control text-center" value="1" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
            <div class="input-group-append">
            <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
            </div>
        </div>

        <div class="row">
            @foreach($variants as $variant)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <a href="javascript:void(0);" onclick="gantiGambar('{{ asset('storage/' . $variant->gambar) }}', this, {{ $variant->id }})" class="pointer-cursor">
                            <p>Ukuran: {{ $variant->ukuran }}</p>
                            <p>Warna: {{ $variant->warna }}</p>
                            @if($variant->gambar)
                            {{-- <img src="{{ asset('storage/' . $variant->gambar) }}" alt="Variant Image" class="img-fluid"> --}}
                            @endif
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <input type="hidden" id="idVariant" name="variant_id" value="">
        </div>
        <p><button type="submit" class="buy-now btn btn-sm btn-primary">Add To Cart</button></p>
        </form>
        </div>
    </div>
    </div>
</div>

<script>
    function gantiGambar(gambar, el, id){
        document.getElementById('mainImage').src = gambar;
        
        // Remove active class from all variants
        var variants = document.querySelectorAll('.variant-active');
        variants.forEach(function(variant) {
            variant.classList.remove('variant-active');
        });

        // Add active class to clicked variant
        el.closest('.card-body').classList.add('variant-active');
        document.getElementById('idVariant').value = id;
    }
</script>

<style>
    .variant-active {
        border: 2px solid #007bff;
    }
</style>
@endsection