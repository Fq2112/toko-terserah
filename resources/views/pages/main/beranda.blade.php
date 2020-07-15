@extends('layouts.mst')
@section('title', 'Beranda | '.env('APP_TITLE'))
@push('styles')
@endpush
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
                                    <a href="{{route('cari', ['kat' => $kat->permalink])}}">
                                        {{$kat->nama}} <i class="fa fa-caret-right"></i></a>
                                    <div class="shop-dropdown-content">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    @foreach(\App\Models\SubKategori::where('kategori_id', $kat->id)->orderBy('nama')->get() as $i => $sub)
                                                        <div class="col-md-6{{$i >= 2 ? ' pt-3' : ''}}">
                                                            <ul class="{{count($sub->getProduk) > 0 ? 'mb-4' : ''}}">
                                                                <li><h2>
                                                                        <a href="{{route('cari', ['sub' => $sub->permalink])}}">{{$sub->nama}}</a>
                                                                    </h2></li>
                                                                @foreach(\App\Models\Produk::where('sub_kategori_id', $sub->id)->orderBy('nama')->get() as $produk)
                                                                    <li><a href="{{$produk->permalink}}">
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
                        <h2 class="title"><strong class="strong-green"><i class="fa fa-star"></i> Top 5</strong> Popular
                        </h2>
                        <div id="shop" class="shop-product">
                            <div class="top-five-popular">
                                <div class="top-item">
                                    <img src="{{asset('images/shop/9.jpg')}}" alt="">
                                    <div class="content-info">
                                        <h4>Headphone</h4>
                                        <ul class="list-unstyled">
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star-o"></i></li>
                                            <li><i class="fa fa-star-o"></i></li>
                                        </ul>
                                        <span>$355.55</span>
                                    </div>
                                </div>
                            </div>
                            <div class="top-five-popular">
                                <div class="top-item">
                                    <img src="{{asset('images/shop/10.jpg')}}" alt="">
                                    <div class="content-info">
                                        <h4>White watch</h4>
                                        <ul class="list-unstyled">
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star-o"></i></li>
                                            <li><i class="fa fa-star-o"></i></li>
                                        </ul>
                                        <span>$355.55</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-lg-9">
                    <div class="row">
                        <h2 class="title"><strong class="strong-green"><i class="fa fa-history"></i> Deals</strong> of
                            the week</h2>
                        <div class="deals">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="left-block">
                                        <div class="gallery">
                                            <div class="previews">
                                                <a class="selected" data-full="{{asset('images/shop/1.jpg')}}"><img src="{{asset('images/shop/small/1.jpg')}}" alt=""></a>
                                                <a data-full="{{asset('images/shop/2.jpg')}}"><img src="{{asset('images/shop/small/2.jpg')}}" alt=""></a>
                                                <a data-full="{{asset('images/shop/3.jpg')}}"><img src="{{asset('images/shop/small/3.jpg')}}" alt=""></a>
                                            </div>
                                            <div class="full">
                                                <img src="{{asset('images/shop/1.jpg')}}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="right-block">
                                        <div class="time">
                                            <div id="clockdiv">
                                                <div><span class="days"></span>
                                                    <div class="smalltext">days</div>
                                                </div>
                                                <div><span class="hours"></span>
                                                    <div class="smalltext">hours</div>
                                                </div>
                                                <div><span class="minutes"></span>
                                                    <div class="smalltext">mins</div>
                                                </div>
                                                <div><span class="seconds"></span>
                                                    <div class="smalltext">secs</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="content-info">
                                            <h2><a href="">Peberkas tongue</a></h2>
                                            <p>Jerky excepteur cow lorem, dolore fatback turkey shankle ut fugiat
                                                meatloaf esse magna bresaola doner. Fatback magna ribeye lorem,
                                                excepteur adipisicing elit </p>
                                            <div class="price">
                                                <span>$37.00</span>
                                                <span class="old-price">$37.00</span>
                                            </div>
                                            <div class="button-info">
                                                <a class="info" href=""><i class="fa fa-shopping-cart"></i> Add to Cart</a>
                                                <a class="info-2" href=""><i class="fa fa-heart-o"></i></a>
                                                <a class="info-2" href=""><i class="fa fa-clone"></i></a>
                                                <a class="info-2" href=""><i class="fa fa-search"></i></a>
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

    <!-- Banner start -->
    <section class="banner-section wow fadeInUp" data-wow-delay=".1s">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="row">
                        <div class="single-banner">
                            <div class="overlay"></div>
                            <p>
                                <a href="#"><img src="{{asset('images/shop/banner.jpg')}}" alt="">
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 banner-space">
                    <div class="row">
                        <div class="single-banner">
                            <div class="overlay"></div>
                            <p>
                                <a href="#"><img src="{{asset('images/shop/banner-2.jpg')}}" alt="">
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section start -->
    <section class="paddtop-50 wow fadeInUp" data-wow-delay=".1s" style="padding-bottom: 50px">
        <div class="container">
            <div class="row">
                <ul class="nav nav-tabs color-5">
                    <li class="active"><a data-toggle="tab" href="#tab-22"><i class="fa fa-home"></i> New Products</a>
                    </li>
                    <li><a data-toggle="tab" href="#tab-23"><i class="fa fa-film"></i> Best Seller</a>
                    </li>
                    <li><a data-toggle="tab" href="#tab-24"><i class="fa fa-film"></i> Featured Products</a>
                    </li>
                </ul>
                <div class="tab-content pane-style no-margin">
                    <div id="tab-22" class="tab-pane fade in active">
                        <div id="Newproducts" class="shop-owl">
                            <div class="shop-item hover effect-10">
                                <img src="{{asset('images/shop/1.jpg')}}" alt="">
                                <div class="new">
                                    <p>New</p>
                                </div>
                                <div class="stars">
                                    <ul class="list-unstyled">
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                    </ul>
                                </div>
                                <div class="info">
                                    <h4><a href="">Dictum spsuming</a></h4>
                                    <div class="price">
                                        <span>$125.50</span>
                                    </div>
                                </div>
                                <div class="cart-overlay">
                                    <a class="info" href=""><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                    <p class="icon-links">
                                        <a href="#"><span class="fa fa-shopping-cart"></span></a>
                                        <a href="#"><span class="fa fa-heart"></span></a>
                                        <a href="#"><span class="fa fa-search"></span></a>
                                    </p>
                                </div>
                            </div>
                            <div class="shop-item hover effect-10">
                                <img src="{{asset('images/shop/2.jpg')}}" alt="">
                                <div class="new">
                                    <p>New</p>
                                </div>
                                <div class="sale">
                                    <p>Sale</p>
                                </div>
                                <div class="stars">
                                    <ul class="list-unstyled">
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                    </ul>
                                </div>
                                <div class="info">
                                    <h4><a href="">Aliquam lobortis</a></h4>
                                    <div class="price">
                                        <span>$37.00</span>
                                    </div>
                                </div>
                                <div class="cart-overlay">
                                    <a class="info" href=""><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                    <p class="icon-links">
                                        <a href="#"><span class="fa fa-shopping-cart"></span></a>
                                        <a href="#"><span class="fa fa-heart"></span></a>
                                        <a href="#"><span class="fa fa-search"></span></a>
                                    </p>
                                </div>
                            </div>
                            <div class="shop-item hover effect-10">
                                <img src="{{asset('images/shop/4.jpg')}}" alt="">
                                <div class="new">
                                    <p>New</p>
                                </div>
                                <div class="sale">
                                    <p>Sale</p>
                                </div>
                                <div class="stars">
                                    <ul class="list-unstyled">
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                    </ul>
                                </div>
                                <div class="info">
                                    <h4><a href="">Lectus egestas</a></h4>
                                    <div class="price">
                                        <span>$110.00</span>
                                    </div>
                                </div>
                                <div class="cart-overlay">
                                    <a class="info" href=""><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                    <p class="icon-links">
                                        <a href="#"><span class="fa fa-shopping-cart"></span></a>
                                        <a href="#"><span class="fa fa-heart"></span></a>
                                        <a href="#"><span class="fa fa-search"></span></a>
                                    </p>
                                </div>
                            </div>
                            <div class="shop-item hover effect-10">
                                <img src="{{asset('images/shop/3.jpg')}}" alt="">
                                <div class="new">
                                    <p>New</p>
                                </div>
                                <div class="stars">
                                    <ul class="list-unstyled">
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                    </ul>
                                </div>
                                <div class="info">
                                    <h4><a href="">Peberkas tongue</a></h4>
                                    <div class="price">
                                        <span>$250.55</span>
                                        <span class="old-price">$310.00</span>
                                    </div>
                                </div>
                                <div class="cart-overlay">
                                    <a class="info" href=""><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                    <p class="icon-links">
                                        <a href="#"><span class="fa fa-shopping-cart"></span></a>
                                        <a href="#"><span class="fa fa-heart"></span></a>
                                        <a href="#"><span class="fa fa-search"></span></a>
                                    </p>
                                </div>
                            </div>

                            <div class="shop-item hover effect-10">
                                <img src="{{asset('images/shop/5.jpg')}}" alt="">
                                <div class="new">
                                    <p>New</p>
                                </div>
                                <div class="stars">
                                    <ul class="list-unstyled">
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                    </ul>
                                </div>
                                <div class="info">
                                    <h4><a href="">Peberkas tongue</a></h4>
                                    <div class="price">
                                        <span>$250.55</span>
                                        <span class="old-price">$310.00</span>
                                    </div>
                                </div>
                                <div class="cart-overlay">
                                    <a class="info" href=""><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                    <p class="icon-links">
                                        <a href="#"><span class="fa fa-shopping-cart"></span></a>
                                        <a href="#"><span class="fa fa-heart"></span></a>
                                        <a href="#"><span class="fa fa-search"></span></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-23" class="tab-pane fade">
                        <div id="bestseller" class="shop-owl">
                            <div class="shop-item hover effect-10">
                                <img src="{{asset('images/shop/2.jpg')}}" alt="">
                                <div class="new">
                                    <p>New</p>
                                </div>
                                <div class="stars">
                                    <ul class="list-unstyled">
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                    </ul>
                                </div>
                                <div class="info">
                                    <h4><a href="">Dictum spsuming</a></h4>
                                    <div class="price">
                                        <span>$125.50</span>
                                    </div>
                                </div>
                                <div class="cart-overlay">
                                    <a class="info" href=""><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                    <p class="icon-links">
                                        <a href="#"><span class="fa fa-shopping-cart"></span></a>
                                        <a href="#"><span class="fa fa-heart"></span></a>
                                        <a href="#"><span class="fa fa-search"></span></a>
                                    </p>
                                </div>
                            </div>
                            <div class="shop-item hover effect-10">
                                <img src="{{asset('images/shop/9.jpg')}}" alt="">
                                <div class="new">
                                    <p>New</p>
                                </div>
                                <div class="sale">
                                    <p>Sale</p>
                                </div>
                                <div class="stars">
                                    <ul class="list-unstyled">
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                    </ul>
                                </div>
                                <div class="info">
                                    <h4><a href="">Aliquam lobortis</a></h4>
                                    <div class="price">
                                        <span>$37.00</span>
                                    </div>
                                </div>
                                <div class="cart-overlay">
                                    <a class="info" href=""><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                    <p class="icon-links">
                                        <a href="#"><span class="fa fa-shopping-cart"></span></a>
                                        <a href="#"><span class="fa fa-heart"></span></a>
                                        <a href="#"><span class="fa fa-search"></span></a>
                                    </p>
                                </div>
                            </div>
                            <div class="shop-item hover effect-10">
                                <img src="{{asset('images/shop/11.jpg')}}" alt="">
                                <div class="new">
                                    <p>New</p>
                                </div>
                                <div class="sale">
                                    <p>Sale</p>
                                </div>
                                <div class="stars">
                                    <ul class="list-unstyled">
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                    </ul>
                                </div>
                                <div class="info">
                                    <h4><a href="">Lectus egestas</a></h4>
                                    <div class="price">
                                        <span>$110.00</span>
                                    </div>
                                </div>
                                <div class="cart-overlay">
                                    <a class="info" href=""><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                    <p class="icon-links">
                                        <a href="#"><span class="fa fa-shopping-cart"></span></a>
                                        <a href="#"><span class="fa fa-heart"></span></a>
                                        <a href="#"><span class="fa fa-search"></span></a>
                                    </p>
                                </div>
                            </div>
                            <div class="shop-item hover effect-10">
                                <img src="{{asset('images/shop/6.jpg')}}" alt="">
                                <div class="new">
                                    <p>New</p>
                                </div>
                                <div class="stars">
                                    <ul class="list-unstyled">
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                    </ul>
                                </div>
                                <div class="info">
                                    <h4><a href="">Peberkas tongue</a></h4>
                                    <div class="price">
                                        <span>$250.55</span>
                                        <span class="old-price">$310.00</span>
                                    </div>
                                </div>
                                <div class="cart-overlay">
                                    <a class="info" href=""><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                    <p class="icon-links">
                                        <a href="#"><span class="fa fa-shopping-cart"></span></a>
                                        <a href="#"><span class="fa fa-heart"></span></a>
                                        <a href="#"><span class="fa fa-search"></span></a>
                                    </p>
                                </div>
                            </div>

                            <div class="shop-item hover effect-10">
                                <img src="{{asset('images/shop/3.jpg')}}" alt="">
                                <div class="new">
                                    <p>New</p>
                                </div>
                                <div class="stars">
                                    <ul class="list-unstyled">
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                    </ul>
                                </div>
                                <div class="info">
                                    <h4><a href="">Peberkas tongue</a></h4>
                                    <div class="price">
                                        <span>$250.55</span>
                                        <span class="old-price">$310.00</span>
                                    </div>
                                </div>
                                <div class="cart-overlay">
                                    <a class="info" href=""><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                    <p class="icon-links">
                                        <a href="#"><span class="fa fa-shopping-cart"></span></a>
                                        <a href="#"><span class="fa fa-heart"></span></a>
                                        <a href="#"><span class="fa fa-search"></span></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-24" class="tab-pane fade">
                        <div id="featuredproducts" class="shop-owl">
                            <div class="shop-item hover effect-10">
                                <img src="{{asset('images/shop/10.jpg')}}" alt="">
                                <div class="new">
                                    <p>New</p>
                                </div>
                                <div class="stars">
                                    <ul class="list-unstyled">
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                    </ul>
                                </div>
                                <div class="info">
                                    <h4><a href="">Dictum spsuming</a></h4>
                                    <div class="price">
                                        <span>$125.50</span>
                                    </div>
                                </div>
                                <div class="cart-overlay">
                                    <a class="info" href=""><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                    <p class="icon-links">
                                        <a href="#"><span class="fa fa-shopping-cart"></span></a>
                                        <a href="#"><span class="fa fa-heart"></span></a>
                                        <a href="#"><span class="fa fa-search"></span></a>
                                    </p>
                                </div>
                            </div>
                            <div class="shop-item hover effect-10">
                                <img src="{{asset('images/shop/12.jpg')}}" alt="">
                                <div class="new">
                                    <p>New</p>
                                </div>
                                <div class="sale">
                                    <p>Sale</p>
                                </div>
                                <div class="stars">
                                    <ul class="list-unstyled">
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                    </ul>
                                </div>
                                <div class="info">
                                    <h4><a href="">Aliquam lobortis</a></h4>
                                    <div class="price">
                                        <span>$37.00</span>
                                    </div>
                                </div>
                                <div class="cart-overlay">
                                    <a class="info" href=""><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                    <p class="icon-links">
                                        <a href="#"><span class="fa fa-shopping-cart"></span></a>
                                        <a href="#"><span class="fa fa-heart"></span></a>
                                        <a href="#"><span class="fa fa-search"></span></a>
                                    </p>
                                </div>
                            </div>
                            <div class="shop-item hover effect-10">
                                <img src="{{asset('images/shop/4.jpg')}}" alt="">
                                <div class="new">
                                    <p>New</p>
                                </div>
                                <div class="sale">
                                    <p>Sale</p>
                                </div>
                                <div class="stars">
                                    <ul class="list-unstyled">
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                    </ul>
                                </div>
                                <div class="info">
                                    <h4><a href="">Lectus egestas</a></h4>
                                    <div class="price">
                                        <span>$110.00</span>
                                    </div>
                                </div>
                                <div class="cart-overlay">
                                    <a class="info" href=""><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                    <p class="icon-links">
                                        <a href="#"><span class="fa fa-shopping-cart"></span></a>
                                        <a href="#"><span class="fa fa-heart"></span></a>
                                        <a href="#"><span class="fa fa-search"></span></a>
                                    </p>
                                </div>
                            </div>
                            <div class="shop-item hover effect-10">
                                <img src="{{asset('images/shop/10.jpg')}}" alt="">
                                <div class="new">
                                    <p>New</p>
                                </div>
                                <div class="stars">
                                    <ul class="list-unstyled">
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                    </ul>
                                </div>
                                <div class="info">
                                    <h4><a href="">Peberkas tongue</a></h4>
                                    <div class="price">
                                        <span>$250.55</span>
                                        <span class="old-price">$310.00</span>
                                    </div>
                                </div>
                                <div class="cart-overlay">
                                    <a class="info" href=""><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                    <p class="icon-links">
                                        <a href="#"><span class="fa fa-shopping-cart"></span></a>
                                        <a href="#"><span class="fa fa-heart"></span></a>
                                        <a href="#"><span class="fa fa-search"></span></a>
                                    </p>
                                </div>
                            </div>

                            <div class="shop-item hover effect-10">
                                <img src="{{asset('images/shop/3.jpg')}}" alt="">
                                <div class="new">
                                    <p>New</p>
                                </div>
                                <div class="stars">
                                    <ul class="list-unstyled">
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                        <li><a href=""><i class="fa fa-star"></i></a></li>
                                    </ul>
                                </div>
                                <div class="info">
                                    <h4><a href="">Peberkas tongue</a></h4>
                                    <div class="price">
                                        <span>$250.55</span>
                                        <span class="old-price">$310.00</span>
                                    </div>
                                </div>
                                <div class="cart-overlay">
                                    <a class="info" href=""><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                    <p class="icon-links">
                                        <a href="#"><span class="fa fa-shopping-cart"></span></a>
                                        <a href="#"><span class="fa fa-heart"></span></a>
                                        <a href="#"><span class="fa fa-search"></span></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
    </script>
@endpush
