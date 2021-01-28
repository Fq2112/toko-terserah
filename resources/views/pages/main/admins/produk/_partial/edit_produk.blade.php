@extends('layouts.mst_admin')
@section('title','Admin '.env('APP_NAME').': Sunting Data Produk | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('admins/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Buttons-1.5.6/css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/summernote/summernote-bs4.css')}}">
    <style>
        .modal-header {
            padding: 1rem !important;
            border-bottom: 1px solid #e9ecef !important;
        }

        .modal-footer {
            padding: 1rem !important;
            border-top: 1px solid #e9ecef !important;
        }
    </style>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Sunting Produk</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Produk</div>
                <div class="breadcrumb-item">Sunting</div>
                <div class="breadcrumb-item">{{$data->kode_barang}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="content2">
                                <form id="form-blogPost" method="post" action="{{route('admin.show.produk.update')}}"
                                      enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <input type="hidden" name="_method">
                                    <input type="hidden" name="id" value="{{$data->id}}">
                                    <input type="hidden" name="admin_id">

                                    <div class="row form-group">
                                        <div class="col has-feedback">
                                            <label for="title">Nama Produk</label>
                                            <input id="promo_code" type="text" maxlength="191" name="nama"
                                                   value="{{$data->nama}}"
                                                   class="form-control"
                                                   placeholder="Write its promo code here&hellip;" required>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col has-feedback">
                                            <label for="title">Jenis Produk</label>
                                            <select id="sub_kategori_id" class="form-control selectpicker"
                                                    name="sub_kategori_id" data-live-search="true" required>
                                                <option value="{{$data->sub_kategori_id}}"
                                                        selected>{{$data->getSubkategori->nama}}</option>
                                                @foreach(\App\Models\SubKategori::all() as $item)
                                                    <option value="{{$item->id}}">{{$item->nama}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col has-feedback">
                                            <label for="title">Kode Produk</label>
                                            <input id="promo_code" type="text" maxlength="191" name="kode_barang"
                                                   value="{{$data->kode_barang}}"
                                                   class="form-control"
                                                   placeholder="Write its promo code here&hellip;" required>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col has-feedback">
                                            <label for="title">Deskripsi Singkat</label>
                                            <input id="promo_code" type="text" maxlength="191" name="deskripsi"
                                                   class="form-control" value="{{$data->deskripsi}}"
                                                   placeholder="Write its promo code here&hellip;" required>
                                        </div>
                                    </div>


                                    <div class="row form-group has-feedback">
                                        <div class="col">
                                            <label for="_content">Detail Produk</label>
                                            <textarea id="description" type="text" name="detail"
                                                      class="summernote form-control"
                                                      placeholder="Write something about your post here&hellip;"
                                                      required>{!! $data->detail !!} </textarea>
                                            <span class="glyphicon glyphicon-text-height form-control-feedback"></span>
                                        </div>
                                    </div>

                                    <div class="row form-group has-feedback">
                                        <div class="col">
                                            <img src="{{asset('storage/produk/thumb/'.$data->gambar)}}"
                                                 alt="Gambar Sekarang" style="width: 400px">
                                        </div>
                                    </div>
                                    <div class="row form-group has-feedback">
                                        <div class="col">
                                            <label for="_content">Thumbnail Produk</label>
                                            <div class="">
                                                <div class="custom-file">
                                                    <input type="file" name="gambar"
                                                           class="custom-file-input input-logo"
                                                           id="site-logo" accept="image/*">
                                                    <label class="custom-file-label">Pilih Gambar</label>
                                                </div>
                                                <div class="form-text text-muted">Foto Tidak Boleh Lebih dari 1 Mb
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group has-feedback">
                                        @if(is_array($data->galeri) || is_object($data->galeri))
                                            @foreach($data->galeri as $key=>$value)
                                                <div class="col">
                                                    <img src="{{asset('storage/produk/galeri/'.$value)}}"
                                                         class="img-thumbnail" style="width: 200px"/> <br>
                                                    <input id="c{{$key}}" type="checkbox" class="checkbox"
                                                           name="temp_photos[]"
                                                           value="{{$value}}"
                                                           multiple/>
                                                    <label for="c{{$key}}">Hapus Gambar</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div class="row form-group has-feedback">
                                        <div class="col">
                                            <label for="_content">Gambar Pendukung <small>(opsional)</small></label>
                                            <div class="">
                                                <div class="custom-file">
                                                    <input type="file" name="galeri[]"
                                                           class="custom-file-input input-logo" multiple
                                                           id="site-logo" accept="image/*">
                                                    <label class="custom-file-label">Pilih Gambar</label>
                                                </div>
                                                <div class="form-text text-muted">Foto Tidak Boleh Lebih
                                                    dari 1 Mb
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-6 has-feedback">
                                            <label for="title">Harga</label>
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Rp</div>
                                                </div>
                                                <input id="discount" type="number" name="harga"
                                                       max="9999999999999"
                                                       min="0" value="{{$data->harga}}"
                                                       class="form-control"
                                                       placeholder="1xxxxxx" >

                                            </div>
                                        </div>
                                        <div class="col-6 has-feedback">
                                            <label for="title">Harga Grosir</label>
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Rp</div>
                                                </div>
                                                <input id="discount" type="number" name="harga_grosir"
                                                       max="9999999999999"
                                                       min="0" value="{{$data->harga_grosir}}"
                                                       class="form-control"
                                                       placeholder="1xxxxxx" >

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-6 has-feedback">
                                            <label for="title">Diskon <small>(opsional)</small></label>
                                            <div class="input-group mb-2">
                                                <input id="discount" type="number" name="diskon" max="99"
                                                       min="0"
                                                       class="form-control" value="{{$data->diskon}}"
                                                       placeholder="1xxxxxx">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">%</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 has-feedback">
                                            <label for="title">Diskon Grosir<small>(opsional)</small></label>
                                            <div class="input-group mb-2">
                                                <input id="diskonGrosir" type="number" name="diskonGrosir" max="99" min="0"
                                                       class="form-control" value="{{$data->diskonGrosir}}"
                                                       placeholder="1xxxxxx">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-4 has-feedback">
                                            <label for="title">Stock</label>
                                            <div class="input-group mb-2">
                                                <input id="discount" type="number" name="stock" max="9999"

                                                       class="form-control" value="{{$data->stock}}"
                                                       placeholder="1xxxxxx" required>
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Pcs/dus</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 has-feedback">
                                            <label for="title">Berat </label>
                                            <div class="input-group mb-2">
                                                <input id="discount" type="number" name="berat" max="99999"

                                                       class="form-control" value="{{$data->actual_weight ?? $data->berat}}"
                                                       placeholder="1xxxxxx" required>
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">gram</div>
                                                </div>
                                            </div>
                                            <small class="text-danger">Berat akan ditambahkan {{\App\Models\Setting::where('id', '!=', 0)->first()->percent_weight}} % dari berat awal</small>
                                        </div>
                                        <div class="col-4 has-feedback">
                                            <label for="min_qty">Minimal Pembelian Kuantiti Grosir</label>
                                            <div class="input-group mb-2">
                                                <input id="min_qty" type="number" name="min_qty" max="99999"
                                                       class="form-control"  value="{{$data->min_qty}}"
                                                       placeholder="1xxxxxx" >
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">pcs</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if(!empty($data->banner))
                                        <div class="row form-group " style="display: none">
                                            <div class="col">
                                                <img src="{{asset('storage/produk/banner/'.$data->banner)}}"
                                                     alt="Banner">
                                                <br>
                                                <input id="banner" type="checkbox" class="checkbox"
                                                       name="hapus_banner"/>

                                                <label for="banner">Hapus Banner</label>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="row form-group has-feedback" style="display: none">
                                        <div class="col">
                                            <label for="_content">Banner <small>(Opsional)</small> <i
                                                    class="fa fa-info-circle text-info"
                                                    data-toggle="tooltip"
                                                    title="Banner Akan ditampilkan pada slide show beranda"></i>
                                            </label>
                                            <div class="">
                                                <div class="custom-file">
                                                    <input type="file" name="banner"
                                                           class="custom-file-input input-logo"
                                                           id="site-logo" accept="image/*">
                                                    <label class="custom-file-label">Pilih Gambar</label>
                                                </div>
                                                <div class="form-text text-muted">Foto Tidak Boleh Lebih
                                                    dari 2 Mb
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col">
                                            <button type="submit"
                                                    class="btn btn-primary btn-block text-uppercase"
                                                    style="font-weight: 900">Simpan
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{asset('admins/modules/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Buttons-1.5.6/js/buttons.dataTables.min.js')}}"></script>
    <script src="{{asset('admins/modules/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{asset('admins/modules/summernote/summernote-bs4.js')}}"></script>
@endpush
