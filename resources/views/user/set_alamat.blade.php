@extends('user.app')
@section('content')

<style>
  .border-utama {
      border: 2px solid black; /* Border lebih tebal */
      background-color: #f8f9fa; /* Warna latar belakang yang lebih terang */
      border-radius: 5px; /* Menambahkan radius pada sudut border */
  }
  .border-black {
      border: 1px solid black; /* Border biasa */
      border-radius: 5px; /* Menambahkan radius pada sudut border */
  }
  .font-weight-bold {
      font-weight: bold; /* Teks lebih tebal */
  }
  .col-4 {
      margin-bottom: 20px; /* Jarak vertikal antara kolom */
  }
  .mt-3 {
      margin-top: 20px; /* Margin atas */
  }
  .p-3 {
      padding: 20px; /* Padding dalam kolom */
  }
  .row {
      margin-left: -10px;
      margin-right: -10px;
  }
  .col-4 {
      padding-left: 10px;
      padding-right: 10px;
  }
</style>

<div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <a href="cart.html">Cart</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Checkout</strong></div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <div class="row mb-5">
              <div class="col-md-12">
                <h2 class="h3 mb-3 text-black">Pilih alamat</h2>
                <h4>alamat pengiriman:</h4>
                <h5>{{ $alamatSelect->detail }}, {{ $alamatSelect->kota }}, {{ $alamatSelect->prov }}</h5>
                <hr>
                <div class="row mt-5">
                  @foreach($alamat_pembeli as $alamat)
                      <div class="col-4 mt-3 p-3 {{ $alamat->is_utama == 1 ? 'border-utama' : 'border-black' }}">
                          <a href="{{ route('user.set_alamat_utama', ['id' => $alamat->id]) }}">
                              <p class="{{ $alamat->is_utama == 1 ? 'font-weight-bold' : '' }}">{{$alamat->provinsi}}, {{$alamat->kota}}</p>
                              <p class="{{ $alamat->is_utama == 1 ? 'font-weight-bold' : '' }}">{{$alamat->detail}}</p>
                          </a>
                      </div>
                  @endforeach
                </div>
                <div>
                  <label for="jasa_kirim">Pilih Jasa Kirim</label>
                  <select class="form-control" id="jasa_kirim" name="jasa_kirim">
                      <option value="">Pilih pengiriman</option>
                      <option value="jne">JNE</option>
                      <option value="tiki">TIKI</option>
                      <option value="pos">POS</option>
                  </select>
              </div>
              <br>
              <div class="row">
                  <a href="#" id="checkout-button" class="btn btn-primary btn-lg py-3 btn-block">Checkout</a>
              </div>
              
              </div>
            </div>

          </div>
        </div>
        <!-- </form> -->
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      document.getElementById('checkout-button').addEventListener('click', function(event) {
            event.preventDefault();
            
            // Ambil nilai dari dropdown
            var jasaKirim = document.getElementById('jasa_kirim').value;
            
            // Periksa apakah nilai dropdown kosong
            if (jasaKirim === "") {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Pilih salah satu jasa kirim sebelum melakukan checkout!'
            });
            return; 
            }
            
            // Buat URL baru dengan path parameter jasa kirim
            var checkoutUrl = "{{ url('checkout') }}" + "/" + jasaKirim;
            
            // Arahkan ke URL baru
            window.location.href = checkoutUrl;
        });
    </script>
@endsection