@extends('layouts.mst')
@section('title', 'Beranda | '.env('APP_TITLE'))
@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="shop-sidebar">
                        <button class="btn-toggle"><i class="fa fa-reorder"></i></button>
                        <ul class="shop-category">
                            @foreach($kategori as $kat)
                                <li class="category-dropdown">
                                    <a href="javascript:void(0)">{{$kat->nama}} <i class="fa fa-caret-right"></i></a>
                                    <div class="shop-dropdown-content">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    @foreach(\App\Models\SubKategori::where('kategori_id', $kat->id)->orderBy('nama')->get() as $i => $sub)
                                                        <div class="col-md-6{{$i >= 2 ? ' pt-3' : ''}}">
                                                            <ul class="{{count($sub->getProduk) > 0 ? 'mb-4' : ''}}">
                                                                <li><h2><a href="{{route('cari', ['kat' =>$sub->id])}}">
                                                                            {{$sub->nama}}</a></h2></li>
                                                                @foreach(\App\Models\Produk::where('sub_kategori_id', $sub->id)->orderBy('nama')->get() as $produk)
                                                                    <li>
                                                                        <a href="{{route('produk', ['produk' => $produk->permalink])}}">
                                                                            {{$produk->nama}}</a></li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <img src="{{is_null($kat->thumb) ? asset('images/shop/banner-6.jpg') :
                                                asset('storage/produk/kategori/'.$kat->thumb)}}" alt="{{$kat->nama}}">
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
                            <div class="item-image">
                                <img src="{{asset('images/shop/sample-1.jpg')}}" alt="">
                            </div>
                            <div class="item-image">
                                <img src="{{asset('images/shop/sample-2.jpg')}}" alt="">
                            </div>
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
                            <strong class="strong-green"><i class="fa fa-star"></i> Top 5</strong> Popular
                        </h2>
                        <div id="shop" class="shop-product">
                            @foreach($top5 as $top)
                                @php
                                    $ulasan = $top->getUlasan;
                                    $stars = \App\Support\Facades\Rating::stars_ul($ulasan->avg('bintang'));
                                    $diskon = $top->is_diskon == true ? ceil($top->harga - ($top->harga * $top->diskon / 100)) : 0;
                                @endphp
                                <div class="top-five-popular"
                                     onclick="window.location.href='{{route('produk',['produk' => $top->permalink])}}'">
                                    <div class="top-item">
                                        <a href="{{route('produk', ['produk' => $top->permalink])}}">
                                            <img src="{{asset('storage/produk/thumb/'.$top->gambar)}}" alt="Thumbnail">
                                        </a>
                                        <div class="content-info">
                                            <a href="{{route('produk', ['produk' => $top->permalink])}}">
                                                <h4>{{$top->nama}}</h4>
                                            </a>
                                            <ul class="list-unstyled">{!! $stars !!}</ul>
                                            @if($top->is_diskon == true)
                                                <span>Rp{{number_format($diskon,2,',','.')}}</span>
                                                <s>Rp{{number_format($top->harga,2,',','.')}}</s>
                                            @else
                                                <span>Rp{{number_format($top->harga,2,',','.')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-lg-9">
                    <div class="row">
                        <h2 class="title">
                            <strong class="strong-green"><i class="fa fa-bolt"></i> Flash</strong> Sale
                        </h2>
                        <div class="deals">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="left-block">
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
                                        {{--<div class="time">
                                            <div id="clockdiv">
                                                <div><span class="days"></span>
                                                    <div class="smalltext">1</div>
                                                </div>
                                                <div><span class="hours"></span>
                                                    <div class="smalltext">0</div>
                                                </div>
                                                <div><span class="minutes"></span>
                                                    <div class="smalltext">00</div>
                                                </div>
                                                <div><span class="seconds"></span>
                                                    <div class="smalltext">00</div>
                                                </div>
                                            </div>
                                        </div>--}}
                                        <div class="content-info">
                                            <h2><a href="{{route('produk', ['produk' => $flash->permalink])}}">
                                                    {{$flash->nama}}</a></h2>
                                            <p>{{$flash->deskripsi}}</p>
                                            <div class="price">
                                                <span>Rp{{number_format(ceil($flash->harga - ($flash->harga * $flash->diskon / 100)), 2, ',', '.')}}</span>
                                                <span
                                                    class="old-price">Rp{{number_format($flash->harga, 2, ',', '.')}}</span>
                                            </div>
                                            <div class="button-info">
                                                <a class="info" href="#"><i
                                                        class="fa fa-shopping-cart mr-2"></i>BELI SEKARANG</a>
                                                <a class="info-2" href="#"><i class="fa fa-heart"></i></a>
                                                <a class="info-2" href="{{route('cari', ['q' => $flash->nama])}}">
                                                    <i class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                        <div id="Newproducts" class="shop-owl">
                            @foreach($terbaru as $row)
                                @php
                                    $ulasan = $row->getUlasan;
                                    $stars = \App\Support\Facades\Rating::stars_ul($ulasan->avg('bintang'));
                                    $harga = $row->is_diskon == true ? ceil($row->harga - ($row->harga * $row->diskon / 100)) : $row->harga;
                                @endphp
                                <div class="shop-item hover effect-10">
                                    <a href="{{route('produk', ['produk' => $row->permalink])}}">
                                        <img src="{{asset('storage/produk/thumb/'.$row->gambar)}}" alt="Thumbnail"></a>
                                    @if($row->is_diskon == true)
                                        <div class="new">
                                            <p>-{{$row->diskon}}%</p>
                                        </div>
                                    @endif
                                    <div class="stars">
                                        <ul class="list-unstyled">
                                            {!! $stars !!}
                                        </ul>
                                    </div>
                                    <div class="info">
                                        <h4><a href="{{route('produk', ['produk' => $row->permalink])}}">
                                                {{$row->nama}}</a></h4>
                                        <div class="price">
                                            <span>Rp{{number_format($harga,2,',','.')}}</span>
                                        </div>
                                    </div>
                                    <div class="cart-overlay">
                                        <a class="info" href=""><i class="fa fa-shopping-cart mr-2"></i>BELI
                                            SEKARANG</a>
                                        <p class="icon-links">
                                            <a href="#"><span class="fa fa-heart"></span></a>
                                            <a href="{{route('cari', ['q' => $row->nama])}}"><span
                                                    class="fa fa-search"></span></a>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div id="produk-terlaris" class="tab-pane fade">
                        <div id="bestseller" class="shop-owl">
                            @foreach($terlaris as $row)
                                @php
                                    $ulasan = $row->getUlasan;
                                    $stars = \App\Support\Facades\Rating::stars_ul($ulasan->avg('bintang'));
                                    $harga = $row->is_diskon == true ? ceil($row->harga - ($row->harga * $row->diskon / 100)) : $row->harga;
                                @endphp
                                <div class="shop-item hover effect-10">
                                    <a href="{{route('produk', ['produk' => $row->permalink])}}">
                                        <img src="{{asset('storage/produk/thumb/'.$row->gambar)}}" alt="Thumbnail"></a>
                                    @if($row->is_diskon == true)
                                        <div class="new">
                                            <p>-{{$row->diskon}}%</p>
                                        </div>
                                    @endif
                                    <div class="stars">
                                        <ul class="list-unstyled">
                                            {!! $stars !!}
                                        </ul>
                                    </div>
                                    <div class="info">
                                        <h4><a href="{{route('produk', ['produk' => $row->permalink])}}">
                                                {{$row->nama}}</a></h4>
                                        <div class="price">
                                            <span>Rp{{number_format($harga,2,',','.')}}</span>
                                        </div>
                                    </div>
                                    <div class="cart-overlay">
                                        <a class="info" href=""><i class="fa fa-shopping-cart mr-2"></i>BELI
                                            SEKARANG</a>
                                        <p class="icon-links">
                                            <a href="#"><span class="fa fa-heart"></span></a>
                                            <a href="{{route('cari', ['q' => $row->nama])}}"><span
                                                    class="fa fa-search"></span></a>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div id="produk-unggulan" class="tab-pane fade">
                        <div id="featuredproducts" class="shop-owl">
                            @foreach($unggulan as $row)
                                @php
                                    $ulasan = $row->getUlasan;
                                    $stars = \App\Support\Facades\Rating::stars_ul($ulasan->avg('bintang'));
                                    $harga = $row->is_diskon == true ? ceil($row->harga - ($row->harga * $row->diskon / 100)) : $row->harga;
                                @endphp
                                <div class="shop-item hover effect-10">
                                    <a href="{{route('produk', ['produk' => $row->permalink])}}">
                                        <img src="{{asset('storage/produk/thumb/'.$row->gambar)}}" alt="Thumbnail"></a>
                                    @if($row->is_diskon == true)
                                        <div class="new">
                                            <p>-{{$row->diskon}}%</p>
                                        </div>
                                    @endif
                                    <div class="stars">
                                        <ul class="list-unstyled">
                                            {!! $stars !!}
                                        </ul>
                                    </div>
                                    <div class="info">
                                        <h4><a href="{{route('produk', ['produk' => $row->permalink])}}">
                                                {{$row->nama}}</a></h4>
                                        <div class="price">
                                            <span>Rp{{number_format($harga,2,',','.')}}</span>
                                        </div>
                                    </div>
                                    <div class="cart-overlay">
                                        <a class="info" href=""><i class="fa fa-shopping-cart mr-2"></i>BELI
                                            SEKARANG</a>
                                        <p class="icon-links">
                                            <a href="#"><span class="fa fa-heart"></span></a>
                                            <a href="{{route('cari', ['q' => $row->nama])}}"><span
                                                    class="fa fa-search"></span></a>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
