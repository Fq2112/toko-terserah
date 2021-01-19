@extends('layouts.mst')
@section('title', 'Beranda | '.env('APP_TITLE'))
@push('styles')
    <style>
        .item-image img.fixed-height {
            object-fit: cover;
            width: 100%;
            height: 500px;
        }

        section.no-banner {
            background: url('{{asset('images/no-promotion.jpg')}}') no-repeat center;
            -webkit-background-size: contain;
            -moz-background-size: contain;
            -o-background-size: contain;
            background-size: contain;
        }

        section.no-banner .no-banner-overlay:before {
            content: '';
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.1) url('{{asset('images/overlay-pattern-1.png')}}');
            position: absolute;
            opacity: .1;
        }

        ul.list-unstyled li i {
            color: #5bb300 !important;
        }

        .top-five-popular .top-item:hover .content-info i {
            color: #fff !important;
        }
    </style>
@endpush
@section('content')
    <section class="{{count($banner) > 0 ? '' : 'no-banner'}}">
        @if(count($banner) <= 0)
            <div class="no-banner-overlay"></div>
        @endif
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="shop-sidebar">
                        <button class="btn-toggle"><i class="fa fa-reorder"></i></button>
                        <ul class="shop-category">
                            @foreach($kategori as $kat)
                                <li class="category-dropdown">
                                    <a href="javascript:void(0)" data-toggle="tooltip" title="{{$kat->nama}}">
                                        {{\Illuminate\Support\Str::words($kat->nama,4,'...')}} <i class="fa fa-caret-right"></i></a>
                                    <div class="shop-dropdown-content">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    @foreach(\App\Models\SubKategori::where('kategori_id', $kat->id)->orderBy('nama')->get() as $i => $sub)
                                                        <div class="col-md-6{{$i >= 2 ? ' pt-3' : ''}}">
                                                            <ul class="{{count($sub->getProduk) > 0 ? 'mb-4' : ''}}">
                                                                <li><h2><a href="{{route('cari', ['kat' =>$sub->id])}}"
                                                                           data-toggle="tooltip" title="{{$sub->nama}}">
                                                                            {{\Illuminate\Support\Str::words($sub->nama,3,'...')}}</a></h2></li>
                                                                @foreach(\App\Models\Produk::where('sub_kategori_id', $sub->id)->orderBy('nama')->get() as $produk)
                                                                    <li>
                                                                        <a href="{{route('produk', ['produk' => $produk->permalink])}}"
                                                                           data-toggle="tooltip" title="{{$produk->nama}}">
                                                                            {{\Illuminate\Support\Str::words($produk->nama,3,'...')}}</a></li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <img src="{{asset('storage/produk/kategori/'.$kat->thumb)}}"
                                                     alt="{{$kat->nama}}">
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="top-slider-section">
                        <div id="single-slider" class="single-slider">
                            @foreach($banner as $row)
                                @php
                                    $produk = !is_null($row->produk) ? \App\Models\Produk::find($row->produk) : null;
                                    $route = !is_null($produk) ? route('produk', ['produk' => $produk->permalink]) : '#';
                                @endphp
                                @if(is_null($row->produk) || (!is_null($row->produk) && !is_null($produk)))
                                    <div class="item-image">
                                        <a href="{{$route}}">
                                            <img class="fixed-height" src="{{asset('storage/banner/'.$row->banner)}}"
                                                 alt="Slider">
                                        </a>
                                    </div>
                                @else
                                    <div class="item-image">
                                        <a href="#">
                                            <img class="fixed-height" src="{{asset('images/empty-page.gif')}}" alt="Empty Data">
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="paddtop-50 wow fadeInUp" data-wow-delay=".1s">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-lg-3">
                    <div class="row">
                        <h2 class="title">
                            <strong class="strong-green"><i class="fa fa-star"></i> Top 5</strong> Produk
                        </h2>
                        <div id="shop" class="shop-product">
                            @php $data_top5 = count($top5) > 0 ? $top5 : \App\Models\Produk::where('stock', '>', 0)->orderByDesc('id')->take(5)->get(); @endphp
                            @if(count($data_top5) > 0)
                                @foreach($data_top5 as $top)
                                    @php
                                        $ulasan = $top->getUlasan;
                                        $stars = \App\Support\Facades\Rating::stars_ul($ulasan->avg('bintang'));
                                    @endphp
                                    <div class="top-five-popular" style="cursor: pointer"
                                         onclick="window.location.href='{{route('produk',['produk' => $top->permalink])}}'">
                                        <div class="top-item">
                                            <a href="{{route('produk', ['produk' => $top->permalink])}}">
                                                <img src="{{asset('storage/produk/thumb/'.$top->gambar)}}"
                                                     alt="Thumbnail">
                                            </a>
                                            @if($top->isGrosir == true)
                                                @if($top->isDiskonGrosir == true)
                                                    <div class="new">
                                                        <p>-{{$top->diskonGrosir}}%</p>
                                                    </div>
                                                @endif
                                                <div class="sale" style="top: 10px;left: unset !important;right: 30px">
                                                    <p style="font-size: 11px">GROSIR</p>
                                                </div>
                                                <div class="content-info">
                                                    <ul class="list-unstyled mb-2">{!! $stars !!}</ul>
                                                    <h4 style="color: unset;font-size: 14px">{{$top->nama}}</h4>
                                                    @if($top->isDiskonGrosir == true)
                                                        <span>Rp{{number_format($top->harga_diskon_grosir,2,',','.')}}</span>
                                                        <s>Rp{{number_format($top->harga_grosir,2,',','.')}}</s>
                                                    @else
                                                        <span>Rp{{number_format($top->harga_grosir,2,',','.')}}</span>
                                                    @endif
                                                </div>
                                            @else
                                                @if($top->is_diskon == true)
                                                    <div class="new">
                                                        <p>-{{$top->diskon}}%</p>
                                                    </div>
                                                @endif
                                                <div class="content-info">
                                                    <ul class="list-unstyled mb-2">{!! $stars !!}</ul>
                                                    <h4 style="color: unset;font-size: 14px">{{$top->nama}}</h4>
                                                    @if($top->is_diskon == true)
                                                        <span>Rp{{number_format($top->harga_diskon,2,',','.')}}</span>
                                                        <s>Rp{{number_format($top->harga,2,',','.')}}</s>
                                                    @else
                                                        <span>Rp{{number_format($top->harga,2,',','.')}}</span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="top-five-popular">
                                    <div class="top-item">
                                        <a href="#">
                                            <img src="{{asset('images/empty-page.gif')}}" alt="Empty Data">
                                        </a>
                                        <div class="new">
                                            <p>EMPTY</p>
                                        </div>
                                        <div class="content-info">
                                            <ul class="list-unstyled mb-2">
                                                <li><i class="far fa-star"></i></li>
                                                <li><i class="far fa-star"></i></li>
                                                <li><i class="far fa-star"></i></li>
                                                <li><i class="far fa-star"></i></li>
                                                <li><i class="far fa-star"></i></li>
                                            </ul>
                                            <h4 style="color: unset;font-size: 14px">Empty Data</h4>
                                            <span>Rp0,00</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-lg-9">
                    <div class="row">
                        <h2 class="title">
                            <strong class="strong-green"><i class="fa fa-bolt"></i> Flash</strong> Sale
                        </h2>
                        <div class="deals">
                            @if(!is_null($flash))
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="left-block">
                                            @if($flash->isGrosir == true)
                                                <div class="sale" style="top: 30px;left: unset !important;right: 35px">
                                                    <p style="font-size: 11px">GROSIR</p>
                                                </div>
                                            @endif
                                            <div class="gallery">
                                                <div class="previews">
                                                    <a class="selected"
                                                       data-full="{{asset('storage/produk/thumb/'.$flash->gambar)}}">
                                                        <img width="100" alt="Thumbnail"
                                                             src="{{asset('storage/produk/thumb/'.$flash->gambar)}}"></a>
                                                    @if(!is_null($flash->galeri))
                                                        @foreach($flash->galeri as $img)
                                                            <a data-full="{{asset('storage/produk/galeri/'.$img)}}">
                                                                <img width="100" alt="Galeri"
                                                                     src="{{asset('storage/produk/galeri/'.$img)}}"></a>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="full">
                                                    <img src="{{asset('storage/produk/thumb/'.$flash->gambar)}}"
                                                         alt="Thumbnail">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="right-block">
                                            <div class="content-info">
                                                <h2><a href="{{route('produk', ['produk' => $flash->permalink])}}">
                                                        {{$flash->nama}}</a></h2>
                                                <p>{{$flash->deskripsi}}</p>
                                                <div class="price">
                                                    @if($flash->isGrosir == true)
                                                        @if($flash->isDiskonGrosir == true)
                                                            <span>Rp{{number_format($flash->harga_diskon_grosir, 2, ',', '.')}}</span>
                                                            <span class="old-price">Rp{{number_format($flash->harga_grosir, 2, ',', '.')}}
                                                            <span class="ml-2"
                                                                  style="text-decoration: none;color: #555 !important;font-size: 20px">-{{$flash->diskonGrosir}}%</span>
                                                        </span>
                                                        @else
                                                            <span>Rp{{number_format($flash->harga_grosir, 2, ',', '.')}}</span>
                                                        @endif
                                                    @else
                                                        @if($flash->is_diskon == true)
                                                            <span>Rp{{number_format($flash->harga_diskon, 2, ',', '.')}}</span>
                                                            <span class="old-price">Rp{{number_format($flash->harga, 2, ',', '.')}}
                                                            <span class="ml-2"
                                                                  style="text-decoration: none;color: #555 !important;font-size: 20px">-{{$flash->diskon}}%</span>
                                                        </span>
                                                        @else
                                                            <span>Rp{{number_format($flash->harga, 2, ',', '.')}}</span>
                                                        @endif
                                                    @endif
                                                </div>
                                                <div class="button-info">
                                                    <a href="javascript:void(0)" class="info btn_cart"
                                                       data-cek="{{route('produk.cek.cart', ['produk' => $flash->permalink])}}"
                                                       data-name="{{$flash->nama}}"
                                                       data-min_qty="{{$flash->isGrosir == true ? $flash->min_qty : 1}}"
                                                       data-add="{{route('produk.add.cart', ['produk' => $flash->permalink])}}">
                                                        <i class="fa fa-shopping-cart mr-2"></i>Tambah ke Cart</a>
                                                    <a href="javascript:void(0)" class="info-2 btn_wishlist"
                                                       data-cek="{{route('produk.cek.wishlist', ['produk' => $flash->permalink])}}"
                                                       data-add="{{route('produk.add.wishlist', ['produk' => $flash->permalink])}}">
                                                        <i class="fa fa-heart"></i></a>
                                                    <a class="info-2"
                                                       href="{{route('produk', ['produk' => $flash->permalink])}}">
                                                        <i class="fa fa-search"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="left-block">
                                            <div class="sale" style="top: 30px;left: unset !important;right: 35px">
                                                <p style="font-size: 11px">EMPTY</p>
                                            </div>
                                            <div class="gallery">
                                                <div class="previews">
                                                    <a class="selected"
                                                       data-full="{{asset('images/empty-page.gif')}}">
                                                        <img width="100" alt="Empty Data"
                                                             src="{{asset('images/empty-page.gif')}}"></a>
                                                </div>
                                                <div class="full">
                                                    <img src="{{asset('images/empty-page.gif')}}" alt="Empty Data">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="paddtop-50 wow fadeInUp" data-wow-delay=".1s" style="padding-bottom: 50px">
        <div class="container">
            <div class="row">
                <ul class="nav nav-tabs color-5">
                    <li class="active">
                        <a data-toggle="tab" href="#produk-terbaru"><i class="fa fa-history mr-2"></i>Produk Terbaru</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#produk-terlaris"><i class="fa fa-tags mr-2"></i>Produk Terlaris</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#produk-unggulan"><i class="fa fa-star mr-2"></i>Produk Unggulan</a>
                    </li>
                </ul>
                <div class="tab-content pane-style no-margin">
                    <div id="produk-terbaru" class="tab-pane fade in active">
                        <div class="shop-owl">
                            @if(count($terbaru) > 0)
                                @foreach($terbaru as $row)
                                    @php
                                        $ulasan = $row->getUlasan;
                                        $stars = \App\Support\Facades\Rating::stars_ul($ulasan->avg('bintang'));
                                    @endphp
                                    <div class="shop-item hover effect-10">
                                        <a href="{{route('produk', ['produk' => $row->permalink])}}">
                                            <img src="{{asset('storage/produk/thumb/'.$row->gambar)}}" alt="Thumbnail"></a>
                                        <div class="stars">
                                            <ul class="list-unstyled">
                                                {!! $stars !!}
                                            </ul>
                                        </div>

                                        @if($row->isGrosir == true)
                                            @if($row->isDiskonGrosir == true)
                                                <div class="new">
                                                    <p>-{{$row->diskonGrosir}}%</p>
                                                </div>
                                            @endif
                                            <div class="sale" style="top: 10px;left: unset !important;right: 10px">
                                                <p style="font-size: 11px">GROSIR</p>
                                            </div>
                                            <div class="info">
                                                <h4>
                                                    <a href="{{route('produk', ['produk' => $row->permalink])}}">{{$row->nama}}</a>
                                                </h4>
                                                <div class="price">
                                                    @if($row->isDiskonGrosir == true)
                                                        <span>Rp{{number_format($row->harga_diskon_grosir,2,',','.')}}</span>
                                                        <br>
                                                        <span
                                                            class="old-price">Rp{{number_format($row->harga_grosir,2,',','.')}}</span>
                                                    @else
                                                        <span>Rp{{number_format($row->harga_grosir,2,',','.')}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            @if($row->is_diskon == true)
                                                <div class="new">
                                                    <p>-{{$row->diskon}}%</p>
                                                </div>
                                            @endif
                                            <div class="info">
                                                <h4>
                                                    <a href="{{route('produk', ['produk' => $row->permalink])}}">{{$row->nama}}</a>
                                                </h4>
                                                <div class="price">
                                                    @if($row->is_diskon == true)
                                                        <span>Rp{{number_format($row->harga_diskon,2,',','.')}}</span>
                                                        <br>
                                                        <span
                                                            class="old-price">Rp{{number_format($row->harga,2,',','.')}}</span>
                                                    @else
                                                        <span>Rp{{number_format($row->harga,2,',','.')}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        <div class="cart-overlay">
                                            <a href="javascript:void(0)" class="info btn_cart"
                                               data-name="{{$row->nama}}"
                                               data-min_qty="{{$row->isGrosir == true ? $row->min_qty : 1}}"
                                               data-cek="{{route('produk.cek.cart', ['produk' => $row->permalink])}}"
                                               data-add="{{route('produk.add.cart', ['produk' => $row->permalink])}}">
                                                <i class="fa fa-shopping-cart mr-2"></i>Tambah ke Cart</a>
                                            <p class="icon-links">
                                                <a href="{{route('produk', ['produk' => $row->permalink])}}">
                                                    <span class="fa fa-search"></span></a>
                                                <a href="javascript:void(0)" class="info-2 btn_wishlist"
                                                   data-cek="{{route('produk.cek.wishlist', ['produk' => $row->permalink])}}"
                                                   data-add="{{route('produk.add.wishlist', ['produk' => $row->permalink])}}">
                                                    <span class="fa fa-heart"></span></a>
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="shop-item hover effect-10">
                                    <a href="#">
                                        <img src="{{asset('images/empty-page.gif')}}" alt="Empty Data"></a>
                                    <div class="stars">
                                        <ul class="list-unstyled">
                                            <li><i class="far fa-star"></i></li>
                                            <li><i class="far fa-star"></i></li>
                                            <li><i class="far fa-star"></i></li>
                                            <li><i class="far fa-star"></i></li>
                                            <li><i class="far fa-star"></i></li>
                                        </ul>
                                    </div>
                                    <div class="new">
                                        <p>EMPTY</p>
                                    </div>
                                    <div class="info">
                                        <h4>
                                            <a href="#">Empty Data</a>
                                        </h4>
                                        <div class="price">
                                            <span>Rp0,00</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div id="produk-terlaris" class="tab-pane fade">
                        <div class="shop-owl">
                            @php $data_terlaris = count($terlaris) > 0 ? $terlaris : $terbaru; @endphp
                            @if(count($data_terlaris) > 0)
                                @foreach($data_terlaris as $row)
                                    @php
                                        $ulasan = $row->getUlasan;
                                        $stars = \App\Support\Facades\Rating::stars_ul($ulasan->avg('bintang'));
                                    @endphp
                                    <div class="shop-item hover effect-10">
                                        <a href="{{route('produk', ['produk' => $row->permalink])}}">
                                            <img src="{{asset('storage/produk/thumb/'.$row->gambar)}}" alt="Thumbnail"></a>
                                        <div class="stars">
                                            <ul class="list-unstyled">
                                                {!! $stars !!}
                                            </ul>
                                        </div>

                                        @if($row->isGrosir == true)
                                            @if($row->isDiskonGrosir == true)
                                                <div class="new">
                                                    <p>-{{$row->diskonGrosir}}%</p>
                                                </div>
                                            @endif
                                            <div class="sale" style="top: 10px;left: unset !important;right: 10px">
                                                <p style="font-size: 11px">GROSIR</p>
                                            </div>
                                            <div class="info">
                                                <h4>
                                                    <a href="{{route('produk', ['produk' => $row->permalink])}}">{{$row->nama}}</a>
                                                </h4>
                                                <div class="price">
                                                    @if($row->isDiskonGrosir == true)
                                                        <span>Rp{{number_format($row->harga_diskon_grosir,2,',','.')}}</span>
                                                        <br>
                                                        <span
                                                            class="old-price">Rp{{number_format($row->harga_grosir,2,',','.')}}</span>
                                                    @else
                                                        <span>Rp{{number_format($row->harga_grosir,2,',','.')}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            @if($row->is_diskon == true)
                                                <div class="new">
                                                    <p>-{{$row->diskon}}%</p>
                                                </div>
                                            @endif
                                            <div class="info">
                                                <h4>
                                                    <a href="{{route('produk', ['produk' => $row->permalink])}}">{{$row->nama}}</a>
                                                </h4>
                                                <div class="price">
                                                    @if($row->is_diskon == true)
                                                        <span>Rp{{number_format($row->harga_diskon,2,',','.')}}</span>
                                                        <br>
                                                        <span
                                                            class="old-price">Rp{{number_format($row->harga,2,',','.')}}</span>
                                                    @else
                                                        <span>Rp{{number_format($row->harga,2,',','.')}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        <div class="cart-overlay">
                                            <a href="javascript:void(0)" class="info btn_cart"
                                               data-name="{{$row->nama}}"
                                               data-min_qty="{{$row->isGrosir == true ? $row->min_qty : 1}}"
                                               data-cek="{{route('produk.cek.cart', ['produk' => $row->permalink])}}"
                                               data-add="{{route('produk.add.cart', ['produk' => $row->permalink])}}">
                                                <i class="fa fa-shopping-cart mr-2"></i>Tambah ke Cart</a>
                                            <p class="icon-links">
                                                <a href="{{route('produk', ['produk' => $row->permalink])}}">
                                                    <span class="fa fa-search"></span></a>
                                                <a href="javascript:void(0)" class="info-2 btn_wishlist"
                                                   data-cek="{{route('produk.cek.wishlist', ['produk' => $row->permalink])}}"
                                                   data-add="{{route('produk.add.wishlist', ['produk' => $row->permalink])}}">
                                                    <span class="fa fa-heart"></span></a>
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="shop-item hover effect-10">
                                    <a href="#">
                                        <img src="{{asset('images/empty-page.gif')}}" alt="Empty Data"></a>
                                    <div class="stars">
                                        <ul class="list-unstyled">
                                            <li><i class="far fa-star"></i></li>
                                            <li><i class="far fa-star"></i></li>
                                            <li><i class="far fa-star"></i></li>
                                            <li><i class="far fa-star"></i></li>
                                            <li><i class="far fa-star"></i></li>
                                        </ul>
                                    </div>
                                    <div class="new">
                                        <p>EMPTY</p>
                                    </div>
                                    <div class="info">
                                        <h4>
                                            <a href="#">Empty Data</a>
                                        </h4>
                                        <div class="price">
                                            <span>Rp0,00</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div id="produk-unggulan" class="tab-pane fade">
                        <div class="shop-owl">
                            @php $data_unggulan = count($unggulan) > 0 ? $unggulan : $terbaru; @endphp
                            @if(count($data_unggulan) > 0)
                                @foreach($data_unggulan as $row)
                                    @php
                                        $ulasan = $row->getUlasan;
                                        $stars = \App\Support\Facades\Rating::stars_ul($ulasan->avg('bintang'));
                                    @endphp
                                    <div class="shop-item hover effect-10">
                                        <a href="{{route('produk', ['produk' => $row->permalink])}}">
                                            <img src="{{asset('storage/produk/thumb/'.$row->gambar)}}" alt="Thumbnail"></a>
                                        <div class="stars">
                                            <ul class="list-unstyled">
                                                {!! $stars !!}
                                            </ul>
                                        </div>

                                        @if($row->isGrosir == true)
                                            @if($row->isDiskonGrosir == true)
                                                <div class="new">
                                                    <p>-{{$row->diskonGrosir}}%</p>
                                                </div>
                                            @endif
                                            <div class="sale" style="top: 10px;left: unset !important;right: 10px">
                                                <p style="font-size: 11px">GROSIR</p>
                                            </div>
                                            <div class="info">
                                                <h4>
                                                    <a href="{{route('produk', ['produk' => $row->permalink])}}">{{$row->nama}}</a>
                                                </h4>
                                                <div class="price">
                                                    @if($row->isDiskonGrosir == true)
                                                        <span>Rp{{number_format($row->harga_diskon_grosir,2,',','.')}}</span>
                                                        <br>
                                                        <span
                                                            class="old-price">Rp{{number_format($row->harga_grosir,2,',','.')}}</span>
                                                    @else
                                                        <span>Rp{{number_format($row->harga_grosir,2,',','.')}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            @if($row->is_diskon == true)
                                                <div class="new">
                                                    <p>-{{$row->diskon}}%</p>
                                                </div>
                                            @endif
                                            <div class="info">
                                                <h4>
                                                    <a href="{{route('produk', ['produk' => $row->permalink])}}">{{$row->nama}}</a>
                                                </h4>
                                                <div class="price">
                                                    @if($row->is_diskon == true)
                                                        <span>Rp{{number_format($row->harga_diskon,2,',','.')}}</span>
                                                        <br>
                                                        <span
                                                            class="old-price">Rp{{number_format($row->harga,2,',','.')}}</span>
                                                    @else
                                                        <span>Rp{{number_format($row->harga,2,',','.')}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        <div class="cart-overlay">
                                            <a href="javascript:void(0)" class="info btn_cart"
                                               data-name="{{$row->nama}}"
                                               data-min_qty="{{$row->isGrosir == true ? $row->min_qty : 1}}"
                                               data-cek="{{route('produk.cek.cart', ['produk' => $row->permalink])}}"
                                               data-add="{{route('produk.add.cart', ['produk' => $row->permalink])}}">
                                                <i class="fa fa-shopping-cart mr-2"></i>Tambah ke Cart</a>
                                            <p class="icon-links">
                                                <a href="{{route('produk', ['produk' => $row->permalink])}}">
                                                    <span class="fa fa-search"></span></a>
                                                <a href="javascript:void(0)" class="info-2 btn_wishlist"
                                                   data-cek="{{route('produk.cek.wishlist', ['produk' => $row->permalink])}}"
                                                   data-add="{{route('produk.add.wishlist', ['produk' => $row->permalink])}}">
                                                    <span class="fa fa-heart"></span></a>
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="shop-item hover effect-10">
                                    <a href="#">
                                        <img src="{{asset('images/empty-page.gif')}}" alt="Empty Data"></a>
                                    <div class="stars">
                                        <ul class="list-unstyled">
                                            <li><i class="far fa-star"></i></li>
                                            <li><i class="far fa-star"></i></li>
                                            <li><i class="far fa-star"></i></li>
                                            <li><i class="far fa-star"></i></li>
                                            <li><i class="far fa-star"></i></li>
                                        </ul>
                                    </div>
                                    <div class="new">
                                        <p>EMPTY</p>
                                    </div>
                                    <div class="info">
                                        <h4>
                                            <a href="#">Empty Data</a>
                                        </h4>
                                        <div class="price">
                                            <span>Rp0,00</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $(function () {
            $("#produk-terbaru .shop-owl").owlCarousel({
                navigation: true,
                navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
                slideSpeed: 600,
                autoPlay: 8000,
                items: 4,
                itemsDesktop: [1199, 3],
                itemsDesktopSmall: [979, 2],
                itemsTablet: [768, 2],
                itemsMobile: [479, 2],
                pagination: false
            });

            $("#produk-terlaris .shop-owl").owlCarousel({
                navigation: true,
                navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
                slideSpeed: 600,
                autoPlay: 8000,
                items: 4,
                itemsDesktop: [1199, 3],
                itemsDesktopSmall: [979, 2],
                itemsTablet: [768, 2],
                itemsMobile: [479, 2],
                pagination: false
            });

            $("#produk-unggulan .shop-owl").owlCarousel({
                navigation: true,
                navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
                slideSpeed: 600,
                autoPlay: 8000,
                items: 4,
                itemsDesktop: [1199, 3],
                itemsDesktopSmall: [979, 2],
                itemsTablet: [768, 2],
                itemsMobile: [479, 2],
                pagination: false
            });
        });

        $(".btn_wishlist").on("click", function () {
            @auth
            var route = $(this).data('add');

            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.get($(this).data('cek'), function (data) {
                    if (data.status == true) {
                        $.ajax({
                            url: route,
                            type: 'post',
                            data: {_token: '{{csrf_token()}}'},
                            success: function (data) {
                                if (data.status == true) {
                                    $(".show_wishlist").text('( ' + data.total + ' )');
                                    swal('SUKSES!', data.message, 'success');
                                }
                            },
                            error: function () {
                                swal('Oops..', 'Terjadi kesalahan! Silahkan, segarkan browser Anda.', 'error');
                            }
                        });
                    } else {
                        swal('PERHATIAN!', data.message, 'warning');
                    }
                });
            }.bind(this), 800);

            @elseauth('admin')
            swal('PERHATIAN!', 'Fitur ini hanya berfungsi ketika Anda masuk sebagai Pelanggan.', 'warning');

            @else
            openLoginModal();
            @endauth
        });

        $(".btn_cart").on("click", function () {
            var name = $(this).data('name'), min_qty = $(this).data('min_qty'),
                cek_uri = $(this).data('cek'), add_uri = $(this).data('add');

            @auth
            swal({
                title: "Tambah ke Cart",
                text: "Apakah Anda yakin untuk menambahkan produk \"" + name + "\" ke dalam cart Anda?",
                icon: 'warning',
                dangerMode: true,
                buttons: ["Tidak", "Ya"],
                closeOnEsc: false,
                closeOnClickOutside: false,
            }).then((confirm) => {
                if (confirm) {
                    let input = document.createElement("input");
                    input.id = 'qty-cart';
                    input.value = min_qty;
                    input.type = 'number';
                    input.min = min_qty;
                    input.className = 'swal-content__input';

                    swal({
                        text: 'Kuantitas: ' + name,
                        content: input,
                        dangerMode: true,
                        buttons: ["Batal", "Tambah ke Cart"],
                        closeOnEsc: false,
                        closeOnClickOutside: false,
                    }).then(val => {
                        if (!val) throw null;
                        $("#form-cart input[name=_method], #form-cart input[name=qty_lama]").val(null);
                        $("#form-cart input[name=qty]").val($("#qty-cart").val());
                        $("#form-cart").attr('action', add_uri).submit();
                    });

                    $("#qty-cart").on('keyup', function () {
                        var el = $(this);
                        if (!el.val() || el.val() == "" || parseInt(el.val()) <= 0) {
                            el.val(min_qty);
                        }

                        $.get(cek_uri, function (data) {
                            if (data.status == true) {
                                el.attr('max', data.stock).attr('min', data.min_qty);
                                el.parent().find('p').remove();

                                if (parseInt(el.val()) > data.stock) {
                                    if (data.stock > 0) {
                                        el.parent().append("<p class='text-success'>Tersedia: <b>" + data.stock + "</b> pcs</p>");
                                    } else {
                                        el.parent().append("<p class='text-danger'>Tersedia: <b>" + data.stock + "</b> pcs</p>");
                                    }
                                    el.val(data.stock);
                                }

                                if (parseInt(el.val()) < data.min_qty) {
                                    el.parent().append("<p class='text-danger'>Pembelian minimal: <b>" + data.min_qty + "</b> pcs</p>");
                                    el.val(data.min_qty);
                                }

                            } else {
                                swal('PERHATIAN!', data.message, 'warning');
                            }
                        });
                    });
                }
            });
            @elseauth('admin')
            swal('PERHATIAN!', 'Fitur ini hanya berfungsi ketika Anda masuk sebagai Pelanggan.', 'warning');

            @else
            openLoginModal();
            @endauth
        });
    </script>
@endpush
