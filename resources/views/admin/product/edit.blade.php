@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>
            </span> Edit Produk
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <h4 class="card-title">Edit Produk</h4>
                        </div>
                        <div class="col text-right">
                            <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-primary">Kembali</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('admin.product.update', ['id' => $product->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Nama Produk</label>
                                    <input required type="text" class="form-control" name="name" value="{{ $product->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlSelect2">Pilih Kategori</label>
                                    <select class="form-control" name="categories_id" id="exampleFormControlSelect2">
                                        @foreach($categories as $categorie)
                                            <option value="{{ $categorie->id }}" {{ $product->categories_id == $categorie->id ? 'selected' : '' }}>{{ $categorie->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlSelect2">Label Promo</label>
                                    <select class="form-control" name="promo" id="exampleFormControlSelect2">
                                        <option value="1" {{ $product->promo == 1 ? 'selected' : '' }}>Promo</option>
                                        <option value="0" {{ $product->promo == 0 ? 'selected' : '' }}>Tidak Promo</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Berat (gram)</label>
                                    <input required type="number" class="form-control" name="weigth" value="{{ $product->weigth }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Harga</label>
                                    <input required type="number" class="form-control" name="price" value="{{ $product->price }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Stok</label>
                                    <input required type="number" class="form-control" name="stok" value="{{ $product->stok }}">
                                </div>
                                <div class="form-group">
                                    <label>File upload</label>
                                    <input type="file" name="image" class="form-control">
                                    <small>Kosongkan jika tidak mengubah gambar</small>
                                </div>
                                <div class="form-group">
                                    <label for="">Deskripsi</label>
                                    <textarea name="description" id="" cols="30" rows="10" class="form-control" required>{{ $product->description }}</textarea>
                                </div>

                                <!-- Variant Section -->
                                <div id="formContainer">
                                    @foreach($variants as $variant)
                                        <div class="variant">
                                            <div class="row mb-2">
                                                <div class="col-6">
                                                    <label for="variant">Variant</label>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <button type="button" class="btn btn-danger removeVariant">Hapus</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <input type="hidden" name="variants[{{ $loop->index }}][id]" value="{{ $variant->id }}">
                                                <input type="hidden" name="variants[{{ $loop->index }}][delete]" class="variant-delete" value="false">
                                                <div class="col-4">
                                                    <label for="ukuran">Ukuran</label>
                                                    <input type="text" id="ukuran" class="form-control" name="variants[{{ $loop->index }}][ukuran]" value="{{ $variant->ukuran }}">
                                                </div>
                                                <div class="col-4">
                                                    <label for="warna">Warna</label>
                                                    <input type="text" id="warna" class="form-control" name="variants[{{ $loop->index }}][warna]" value="{{ $variant->warna }}">
                                                </div>
                                                <div class="col-4">
                                                    <label for="gambarVariant">Gambar</label>
                                                    <input type="file" id="gambarVariant" class="form-control" name="variants[{{ $loop->index }}][gambar]">
                                                    <small>Kosongkan jika tidak mengubah gambar</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row mb-2">
                                    <div class="col text-right">
                                        <button type="button" class="btn btn-primary" id="tambahVariant">Tambah Variant</button>
                                    </div>
                                </div>
                                <!-- End Variant Section -->

                                <div class="text-right">
                                    <button type="submit" class="btn btn-success text-right">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    success: '#1bcfb4',
                }
            }
        }
    };

    document.getElementById('tambahVariant').addEventListener('click', function() {
        var formContainer = document.getElementById('formContainer');
        var index = formContainer.getElementsByClassName('variant').length;

        var newForm = document.createElement('div');
        newForm.classList.add('variant');
        newForm.innerHTML = `
            <div class="row mb-2">
                <div class="col-6">
                    <label for="variant">Variant</label>
                </div>
                <div class="col-6 text-right">
                    <button type="button" class="btn btn-danger removeVariant">Hapus</button>
                </div>
            </div>
            <div class="row">
                <input type="hidden" name="variants[${index}][id]" value="">
                <input type="hidden" name="variants[${index}][delete]" class="variant-delete" value="false">
                <div class="col-4">
                    <label for="ukuran">Ukuran</label>
                    <input type="text" id="ukuran" class="form-control" name="variants[${index}][ukuran]" value="">
                </div>
                <div class="col-4">
                    <label for="warna">Warna</label>
                    <input type="text" id="warna" class="form-control" name="variants[${index}][warna]" value="">
                </div>
                <div class="col-4">
                    <label for="gambarVariant">Gambar</label>
                    <input type="file" id="gambarVariant" class="form-control" name="variants[${index}][gambar]">
                </div>
            </div>
        `;

        formContainer.appendChild(newForm);

        // Add event listener to remove button
        newForm.querySelector('.removeVariant').addEventListener('click', function() {
            this.parentElement.parentElement.parentElement.remove();
        });
    });

    // Add event listener to existing remove buttons
    document.querySelectorAll('.removeVariant').forEach(function(button) {
        button.addEventListener('click', function() {
            var parentVariant = this.parentElement.parentElement.parentElement;
            parentVariant.querySelector('.variant-delete').value = 'true';
            parentVariant.style.display = 'none';
        });
    });
</script>
@endsection
