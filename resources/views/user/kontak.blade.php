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
            <h4 class="text-black mt-2">ksjhgfgsuoihisodhhjbjhigsdwywhwdgfsdugfhsduyh</h4>
            <h5 class="text-black">Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia aperiam perspiciatis quisquam adipisci fuga. Nemo cumque quis asperiores praesentium cupiditate neque, quasi sequi incidunt minus sit. Ipsam, voluptatem. Labore, ipsam. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis sit est voluptates deserunt iure quas quos, reiciendis quo exercitationem ipsum, totam soluta labore alias aspernatur perspiciatis molestiae. Unde, magnam fugiat. Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam nobis aliquam quis! Necessitatibus error accusamus esse voluptatem odit libero laborum. Nesciunt magnam reprehenderit harum qui laborum maiores? Recusandae, ex ratione! Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod natus dolorem reiciendis ab aspernatur aut tempore dignissimos enim odit, laudantium quas error repellendus voluptas accusantium expedita asperiores! Possimus, unde voluptatem? Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque esse rem quam magni ad doloremque eveniet. Nihil explicabo odit cupiditate sint, sit perspiciatis dolores perferendis, distinctio suscipit blanditiis natus commodi? Lor  em ipsum dolor sit amet consectetur adipisicing elit. Dignissimos facere impedit eligendi blanditiis voluptates assumenda enim excepturi libero maxime ad! Harum id amet quos consequatur sapiente doloribus, dolorum sit maxime. lo    </h5>

        
        </div>
        <div class="col-md-5 ml-auto">
            <div class="p-4 border mb-3">
                <img src="{{ asset('shopper') }}/images/contact.png " class="imgpromo">
                <span class="text-black d-block text-primary h6 text-uppercase">jalan abc</span>
                <p class="text-black mb-0">alan sukses menuju dunia akhirat</p>
                <span class="text-black d-block text-primary h6 text-uppercase">Phone</span>
                <a href="https://wa.me/6233923929210" target="_blank">
                    <p class="text-black mb-0">+62 3392 3929 210</p>
                </a>
                <span class="text-black d-block text-primary h6 text-uppercase">Email</span>
                <p class="text-black mb-0">abdulgofarm@gmail.com</p>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection