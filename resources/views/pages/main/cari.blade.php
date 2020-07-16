@extends('layouts.mst')
@section('title', 'Cari Produk'.$title.'dengan Harga Terbaik | '.env('APP_TITLE'))
@push('styles')
    <style>
    </style>
@endpush
@section('content')
    <section class="page-content page-sidebar none-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-lg-3">
                    <div class="sidebar">
                        <div class="widget">
                            <h4>Kategori Produk</h4>
                            <select id="sub" name="sub" class="form-control" multiple>
                                <option></option>
                                @foreach($kategori as $kat)
                                    <optgroup label="{{$kat->nama}}">
                                        @foreach(\App\Models\SubKategori::where('kategori_id', $kat->id)->orderBy('nama')->get() as $sub)
                                            <option value="{{$sub->id}}">{{$sub->nama}}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-lg-9">
                    <h2>Hasil Pencarian</h2>
                    <div class="top-filter">
                        <p class="woocommerce-result-count">Menampilan <b>1 - 6</b> dari <b>10</b> produk</p>
                        <form class="woocommerce-ordering">
                            <select id="sort" name="sort">
                                <option></option>
                                <option value="popularitas">Popularitas</option>
                                <option value="harga-asc">Harga: rendah ke tinggi</option>
                                <option value="harga-desc">Harga: tinggi ke rendah</option>
                            </select>
                        </form>
                    </div>
                    <div class="row search-result">
                        {{--<div class="col-md-3">
                            <div class="item-product first">
                                <div class="product-thumb">
                                    <div class="midd">
                                        <a href="product.html"><img src="images/shop/1.jpg" alt=""></a>
                                        <div class="n-content">
                                            <p>New</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="info-product">
                                    <h4><a href="product.html">Dictum spsuming</a></h4>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-o"></i>
                                    </div>
                                    <p class="price">$430</p>
                                    <div class="add-cart">
                                        <a href="#" class="shop-btn">Add to Cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>--}}
                    </div>
                    <ul class="pagination text-right">
                        <li><a href="#"><i class="fa fa-chevron-left"></i></a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#"><i class="fa fa-chevron-right"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $(function () {
            $("#sort").select2({
                placeholder: "-- Urutkan Berdasarkan --",
                allowClear: true,
                width: '100%',
            });

            $("#sub").select2({
                placeholder: "-- Pilih Kategori --",
                allowClear: true,
                width: '100%',
            });
        });
    </script>
@endpush
