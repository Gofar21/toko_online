@extends('user.app')
@section('content')
<style>
    .imgpromo{
        max-width: 300px;
    }

    .test{
        background-image: url('{{ asset('shopper') }}/images/bg1.png');
        background-size: cover; /* Mengatur gambar agar menutupi seluruh elemen */
        background-position: center; /* Mengatur posisi gambar di tengah */
        width: 100%;
        height: 100vh; /* Mengatur tinggi elemen sesuai dengan tinggi viewport */
    }

    .test:hover::before {
            transform: scale(1.1); /* Zoom in sedikit ketika di-hover */
        }
        .border-shadow {
            box-shadow: 0 30px 50px rgba(0, 0, 0, 0.2); /* Menambahkan bayangan */
        }
</style>
<div class="bg-light py-3">
    <div class="container">
    <div class="row">
        <div class="col-md-12 mb-0"><a href="{{ route('home')}}">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Contact</strong></div>
    </div>
    </div>
</div>  

<div class="site-section test">
    <div class="container">
    <div class="row">
        <div class="col-md-12">
        <h2 class="h3 mb-3 text-black">Tentang Kami</h2>
        </div>
        <div class="col-md-7 border-shadow" style="border: 1px solid rgb(255, 255, 255); ">
            <h4 class="text-black mt-2">HM Konveksi</h4>
            <h5 class="text-black">Merupakan usaha konveksi rumahan prmbuatan celana kekinian dengan beragam motif dan warna. Produk yang kami buat selalu mengedepankan kualitas dengan didukung SDM yang profesional dan ahli dibidangnya.
            </h5><br>
            <img src="{{ asset('shopper') }}/images/celana.jpeg " class="imgpromo">
            <img src="{{ asset('shopper') }}/images/celana1.jpeg " class="imgpromo">

        
        </div>
        <div class="col-md-5 ml-auto">
            <div class="p-4 border mb-3">
                <img src="{{ asset('shopper') }}/images/contact.png " class="imgpromo">
                <span class="text-black d-block text-primary h6 text-uppercase">Jalan Welahan</span>
                <p class="text-black mb-0">DS.Kalipucang Kulon, Kec.Welahan, Kab.Jepara</p>
                <span class="text-black d-block text-primary h6 text-uppercase">Phone</span>
                <a href="https://wa.me/6289677591700" target="_blank">
                    <p class="text-black mb-0">+6289 677 591 700</p>
                </a>
                <span class="text-black d-block text-primary h6 text-uppercase">Email</span>
                <p class="text-black mb-0">abdulgofarm@gmail.com</p>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection