@extends('layouts.mst')
@section('title', 'Beranda | '.env('APP_TITLE'))
@push('styles')
@endpush
@section('content')
    <!-- Top Section start -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="shop-sidebar">
                        <button class="btn-toggle"><i class="fa fa-reorder"></i>
                        </button>
                        <ul class="shop-category">
                            <li><a href="">T-shirts & Apparel</a>
                            </li>
                            <li class="category-dropdown"><a href="">Electronics & Gadgets <i
                                        class="fa fa-caret-right"></i></a>
                                <div class="shop-dropdown-content">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <ul>
                                                        <li><h2>Latest Arrivals</h2></li>
                                                        <li><a href="">T-Shirts & Apparels</a></li>
                                                        <li><a href="">Electronics & Gadgets</a></li>
                                                        <li><a href="">Tools & Outdoors</a></li>
                                                        <li><a href="">iPods & Music Players</a></li>
                                                        <li><a href="">Lights & Lasers</a></li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-6">
                                                    <ul>
                                                        <li><h2>Watches</h2></li>
                                                        <li><a href="">Apple Watches</a></li>
                                                        <li><a href="">Fashion Watches</a></li>
                                                        <li><a href="">Casual Watches</a></li>
                                                        <li><a href="">Smart Watches</a></li>
                                                        <li><a href="">Kids Watches</a></li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-6 paddtop-20">
                                                    <ul>
                                                        <li><h2>Accessories</h2></li>
                                                        <li><a href="">Bags & Purses</a></li>
                                                        <li><a href="">Men Belts</a></li>
                                                        <li><a href="">Women Jewelry</a></li>
                                                        <li><a href="">Sunglasses</a></li>
                                                        <li><a href="">Casual Wear Items</a></li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-6 paddtop-20">
                                                    <ul>
                                                        <li><h2>Computers</h2></li>
                                                        <li><a href="">Apple Mouse</a></li>
                                                        <li><a href="">Apple Keyword</a></li>
                                                        <li><a href="">Headphones</a></li>
                                                        <li><a href="">Charger</a></li>
                                                        <li><a href="">Phone</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <img src="{{asset('images/shop/banner-6.jpg')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li><a href="">Hoodies & Jackets</a>
                            </li>
                            <li class="category-dropdown"><a href="">Health & Beauty <i
                                        class="fa fa-caret-right"></i></a>
                                <div class="shop-dropdown-content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="row">
                                                        <div class="top-five-popular">
                                                            <div class="top-item">
                                                                <img src="{{asset('images/shop/1.jpg')}}" alt="">
                                                                <div class="content-info">
                                                                    <h4>Peberkas tongue</h4>
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
                                                <div class="col-md-3">
                                                    <div class="row">
                                                        <div class="top-five-popular">
                                                            <div class="top-item">
                                                                <img src="{{asset('images/shop/2.jpg')}}" alt="">
                                                                <div class="content-info">
                                                                    <h4>Peberkas tongue</h4>
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
                                                <div class="col-md-3">
                                                    <div class="row">
                                                        <div class="top-five-popular">
                                                            <div class="top-item">
                                                                <img src="{{asset('images/shop/3.jpg')}}" alt="">
                                                                <div class="content-info">
                                                                    <h4>Peberkas tongue</h4>
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
                                                <div class="col-md-3">
                                                    <div class="row">
                                                        <div class="top-five-popular">
                                                            <div class="top-item">
                                                                <img src="{{asset('images/shop/4.jpg')}}" alt="">
                                                                <div class="content-info">
                                                                    <h4>Peberkas tongue</h4>
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
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="category-dropdown"><a href="">Tools & Outdoors <i class="fa fa-caret-right"></i></a>
                                <div class="shop-dropdown-content-small">
                                    <ul>
                                        <li><a href="">Category 1</a></li>
                                        <li><a href="">Category 2</a></li>
                                        <li><a href="">Category 3</a></li>
                                        <li><a href="">Category 4</a></li>
                                        <li><a href="">Category 5</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="category-dropdown"><a href="">Electronics & Gadgets <i
                                        class="fa fa-caret-right"></i></a>
                                <div class="shop-dropdown-content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <ul>
                                                        <li><h2>Latest Arrivals</h2></li>
                                                        <li><a href="">T-Shirts & Apparels</a></li>
                                                        <li><a href="">Electronics & Gadgets</a></li>
                                                        <li><a href="">Tools & Outdoors</a></li>
                                                        <li><a href="">iPods & Music Players</a></li>
                                                        <li><a href="">Lights & Lasers</a></li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-3">
                                                    <ul>
                                                        <li><h2>Watches</h2></li>
                                                        <li><a href="">Apple Watches</a></li>
                                                        <li><a href="">Fashion Watches</a></li>
                                                        <li><a href="">Casual Watches</a></li>
                                                        <li><a href="">Smart Watches</a></li>
                                                        <li><a href="">Kids Watches</a></li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-3">
                                                    <ul>
                                                        <li><h2>Accessories</h2></li>
                                                        <li><a href="">Bags & Purses</a></li>
                                                        <li><a href="">Men Belts</a></li>
                                                        <li><a href="">Women Jewelry</a></li>
                                                        <li><a href="">Sunglasses</a></li>
                                                        <li><a href="">Casual Wear Items</a></li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-3">
                                                    <ul>
                                                        <li><h2>Computers</h2></li>
                                                        <li><a href="">Apple Mouse</a></li>
                                                        <li><a href="">Apple Keyword</a></li>
                                                        <li><a href="">Headphones</a></li>
                                                        <li><a href="">Charger</a></li>
                                                        <li><a href="">Phone</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li><a href="">Lights & Lasers</a></li>
                            <li><a href="">Smartphone & Tablets</a></li>
                            <li><a href="">Audio & Sound Systems</a></li>
                            <li><a href="">Kids Toys</a></li>
                            <li><a href="">Health & Beauty</a></li>
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
    <!-- Top Section end -->
    <!-- Support start -->
    <section class="support-section paddtop-50 wow fadeInUp" data-wow-delay=".1s">
        <div class="container">
            <div class="row-clear">
                <div class="col-md-2">
                    <div class="row">
                        <div class="shop-support border">
                            <div class="icon-support">
                                <i class="fa fa-truck"></i>
                            </div>
                            <div class="shop-support-info">
                                <a href="">Free Delivery</a>
                                <p>From 275 Aed</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="row">
                        <div class="shop-support">
                            <div class="icon-support">
                                <i class="fa fa-money"></i>
                            </div>
                            <div class="shop-support-info">
                                <a href="">Cash On</a>
                                <p>From 275 Aed</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="row">
                        <div class="shop-support">
                            <div class="icon-support">
                                <i class="fa fa-gift"></i>
                            </div>
                            <div class="shop-support-info">
                                <a href="">Free Gift Box</a>
                                <p>& Gift Note</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="row">
                        <div class="shop-support">
                            <div class="icon-support">
                                <i class="fa fa-phone-square"></i>
                            </div>
                            <div class="shop-support-info">
                                <a href="">Contact Us</a>
                                <p>+(123) 456 789</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="row">
                        <div class="shop-support">
                            <div class="icon-support">
                                <i class="fa fa-users"></i>
                            </div>
                            <div class="shop-support-info">
                                <a href="">Loyalty</a>
                                <p>Rewarded</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="row">
                        <div class="shop-support">
                            <div class="icon-support">
                                <i class="fa fa-cogs"></i>
                            </div>
                            <div class="shop-support-info">
                                <a href="">Online support</a>
                                <p>online 24/24</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Support end -->
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
    <!-- Featured Products start -->
    <section class="shop-section paddtop-50 wow fadeInUp" data-wow-delay=".1s">
        <div class="container">
            <div class="row">
                <h2 class="title"><strong class="strong-green"><i class="fa  fa-bookmark"></i> Featured</strong>
                    Products</h2>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div id="top-slider" class="shop-owl">
                    <div class="shop-item hover effect-10">
                        <img src="{{asset('images/shop/11.jpg')}}" alt="">
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
    </section>
    <!-- Featured Products End -->
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
    <!-- Banner end -->
    <!-- Section start -->
    <section class="paddtop-50 wow fadeInUp" data-wow-delay=".1s">
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
    <!-- Section end -->
    <!-- Banner start -->
    <section class="paddtop-50 wow fadeInUp" data-wow-delay=".1s">
        <div class="container">
            <div class="row">
                <div class="single-banner">
                    <div class="overlay"></div>
                    <p>
                        <a href="#"><img src="{{asset('images/shop/airpods-banner-1.png')}}" alt="">
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner end -->
    <!-- Blog section start-->
    <section class="blog-section paddtop-50 wow fadeInUp" data-wow-delay=".1s">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <h2 class="title"><strong class="strong-green"><i class="fa fa-pencil-square-o"></i>
                                Latest</strong> Blog</h2>
                        <div id="shop-blog" class="shop-owl">
                            <div class="blog-item">
                                <img class="img-thumbnail" src="{{asset('images/shop/blog.jpg')}}" alt="">
                                <div class="content-info">
                                    <span><b>16</b> January 2017</span>
                                    <h2>Atback minim tempor</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Duis aute irure reprehenderit
                                        cillum dolore eu fugiat nulla pariatur.</p>
                                    <div class="blog-comments">
                                        <a href="">10 comments <i class="fa fa-comments"></i></a>
                                    </div>
                                    <div class="blog-more">
                                        <a href="">Read more <i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-item">
                                <img class="img-thumbnail" src="{{asset('images/shop/blog-2.jpg')}}" alt="">
                                <div class="content-info">
                                    <span><b>16</b> January 2017</span>
                                    <h2>Atback minim tempor</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Duis aute irure reprehenderit
                                        cillum dolore eu fugiat nulla pariatur.</p>
                                    <div class="blog-comments">
                                        <a href="">18 comments <i class="fa fa-comments"></i></a>
                                    </div>
                                    <div class="blog-more">
                                        <a href="">Read more <i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-item">
                                <img class="img-thumbnail" src="{{asset('images/shop/blog-3.jpg')}}" alt="">
                                <div class="content-info">
                                    <span><b>16</b> January 2017</span>
                                    <h2>Atback minim tempor</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Duis aute irure reprehenderit
                                        cillum dolore eu fugiat nulla pariatur.</p>
                                    <div class="blog-comments">
                                        <a href="">30 comments <i class="fa fa-comments"></i></a>
                                    </div>
                                    <div class="blog-more">
                                        <a href="">Read more <i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="shop-testimonials">
                            <h2 class="title text-center"><strong class="strong-green"><i
                                        class="fa fa-tags"></i></strong> Testimonials</h2>
                            <div id="shop-testimonials" class="shop-product">
                                <div class="testimonials style-8 quote">
                                    <div class="active item">
                                        <blockquote>
                                            <p><i class="fa fa-quote-left"></i> Duis aute irure dolor in reprehenderit
                                                in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
                                                officia deserunt mollit anim id est laborum.<i
                                                    class="fa fa-quote-right"></i>
                                            </p>
                                        </blockquote>

                                        <div class="carousel-info">
                                            <img alt="" src="{{asset('images/faces/4.jpg')}}" class="pull-left img-thumbnail">
                                            <div class="pull-left">
                                                <span class="testimonials-name">John Doe</span>
                                                <span class="testimonials-post">Design & Ceo</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="testimonials style-8 quote">
                                    <div class="active item">
                                        <blockquote>
                                            <p><i class="fa fa-quote-left"></i> Duis aute irure dolor in reprehenderit
                                                in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
                                                officia deserunt mollit anim id est laborum.<i
                                                    class="fa fa-quote-right"></i>
                                            </p>
                                        </blockquote>

                                        <div class="carousel-info">
                                            <img alt="" src="{{asset('images/faces/4.jpg')}}" class="pull-left img-thumbnail">
                                            <div class="pull-left">
                                                <span class="testimonials-name">John Doe</span>
                                                <span class="testimonials-post">Design & Ceo</span>
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
    <!-- blog section End -->
    <!-- Our Client -->
    <section class="paddtop-50 wow fadeInUp" data-wow-delay=".1s">
        <div class="container">
            <div class="row">
                <div id="clients" class="client-slider shop-owl client-border">
                    <div class="logo-item">
                        <a href="#"><img src="{{asset('images/logos/logo-1.png')}}" alt="">
                        </a>
                    </div>
                    <div class="logo-item">
                        <a href="#"><img src="{{asset('images/logos/logo-2.png')}}" alt="">
                        </a>
                    </div>
                    <div class="logo-item">
                        <a href="#"><img src="{{asset('images/logos/logo-3.png')}}" alt="">
                        </a>
                    </div>
                    <div class="logo-item">
                        <a href="#"><img src="{{asset('images/logos/logo-4.png')}}" alt="">
                        </a>
                    </div>
                    <div class="logo-item">
                        <a href="#"><img src="{{asset('images/logos/logo-5.png')}}" alt="">
                        </a>
                    </div>
                    <div class="logo-item">
                        <a href="#"><img src="{{asset('images/logos/logo-6.png')}}" alt="">
                        </a>
                    </div>
                    <div class="logo-item">
                        <a href="#"><img src="{{asset('images/logos/logo-7.png')}}" alt="">
                        </a>
                    </div>
                    <div class="logo-item">
                        <a href="#"><img src="{{asset('images/logos/logo-8.png')}}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
@endpush
