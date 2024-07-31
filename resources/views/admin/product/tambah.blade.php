@extends('admin.layout.app')
@section('content')
<div class="content-wrapper">
	<div class="page-header">
		<h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white mr-2">
				<i class="mdi mdi-home"></i>
			</span> Tambah Produk
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
							<h4 class="card-title">Tambah Produk</h4>
						</div>
						<div class="col text-right">
							<a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-primary">Kembali</a>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="flex">
									<div class="w-3/4">
										<div class="form-group">
											<label for="exampleInputUsername1">Nama Produk</label>
											<input required type="text" class="form-control" name="name">
										</div>
										<div class="form-group">
											<label for="exampleFormControlSelect2">Pilih Kategori</label>
											<select class="form-control" name="categories_id" id="exampleFormControlSelect2">
												@foreach($categories as $categorie)
												<option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
												@endforeach
											</select>
										</div>
										<div class="form-group">
											<label for="exampleFormControlSelect2">Label Promo</label>
											<select class="form-control" name="promo" id="exampleFormControlSelect2">
												<option value="1">Promo</option>
												<option value="0">Tidak Promo</option>
											</select>
										</div>
										<div class="form-group">
											<label for="exampleInputUsername1">Berat (gram)</label>
											<input required type="number" class="form-control" name="weigth">
										</div>
										<div class="form-group">
											<label for="exampleInputUsername1">Harga</label>
											<input required type="number" class="form-control" name="price">
										</div>
										<div class="form-group">
											<label for="exampleInputUsername1">Stok</label>
											<input required type="number" class="form-control" name="stok">
										</div>
										<div class="form-group">
											<label for="">Deskripsi</label>
											<textarea name="description" id="" cols="30" rows="10" class="form-control" required>
												</textarea>
										</div>
										<br>
										<div id="formContainer">
											<div class="variant">
												<div class="row mb-2">
													<div class="col-6">
														<label for="variant">Variant</label>
													</div>
													<div class="col-6 text-right">
														<button type="button" class="btn btn-primary" id="tambahVariant">Tambah</button>
													</div>
												</div>
												<div class="row">
													<div class="col-4">
														<label for="ukuran">Ukuran</label>
														<input type="text" id="ukuran" class="form-control" name="ukuran[]"required>
													</div>
													<div class="col-4">
														<label for="warna">Warna</label>
														<input type="text" id="warna" class="form-control" name="warna[]" required>
													</div>
													<div class="col-4">
														<label for="gambarVariant">Gambar</label>
														<input type="file" id="gambarVariant" class="form-control" name="gambarVariant[]" required>
													</div>
												</div>
											</div>
										</div>
										<div class="text-right">
											<button type="submit" class="bg-success btn btn-success text-right">Simpan</button>
										</div>
									</div>
									<div class="w-1/4">
										<div class="form-group">
											<label>File upload</label>
											<input required type="file" name="image" class="form-control">
										</div>
									</div>
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
	}
	document.getElementById('tambahVariant').addEventListener('click', function() {
            var formContainer = document.getElementById('formContainer');
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
                    <div class="col-4">
                        <label for="ukuran">Ukuran</label>
                        <input type="text" class="form-control" name="ukuran[]">
                    </div>
                    <div class="col-4">
                        <label for="warna">Warna</label>
                        <input type="text" class="form-control" name="warna[]">
                    </div>
                    <div class="col-4">
                        <label for="gambarVariant">Gambar</label>
                        <input type="file" class="form-control" name="gambarVariant[]">
                    </div>
                </div>
            `;
            formContainer.appendChild(newForm);
        });

        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('removeVariant')) {
                e.target.closest('.variant').remove();
            }
        });
</script>
@endsection