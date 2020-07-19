@extends('layouts.mst')
@section('title', $produk->nama.' | '.env('APP_TITLE'))
@push('styles')
@endpush
@section('content')
    <section class="page-content page-sidebar none-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="content-container">
                        <div class="content-inner">
                            <div class="padding">
                                <div class="pro-details">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div id="img-preview" class="img-product">
                                                <img src="images/shop/7.png" alt="">
                                                <img src="images/shop/8.png" alt="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h3>Black Camera</h3>
                                            <div class="single-rating">
                                                        <span>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-o"></i>
                                                        </span>
                                                <span>2 Reviews</span>
                                                <p>Availability: <span>In stock</span></p>
                                                <p>Pellentesque habitant morbi tristique senectus et netus et malesuada
                                                    fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae,
                                                    ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam
                                                    egestas semper. Aenean ultricies mi vitae est. Mauris placerat
                                                    eleifend leo.</p>
                                                <p class="single-price">$16.06</p>
                                                <div class="product-cart">
                                                    <input type="number" step="1" min="1" name="quantity" value="1"
                                                           title="Qty" class="input-text qty text" size="4">
                                                    <button type="submit" class="btn btn-color2">Add to cart</button>
                                                    <button type="submit" class="btn btn-color2"><i
                                                            class="fa fa-heart"></i></button>
                                                </div>
                                                <div class="cat">
                                                    Categories:
                                                    <a href="#">Woman</a>, <a href="#">Jacket</a>
                                                </div>
                                                <div class="follow-us">
                                                    <ul>
                                                        <li>
                                                            <p>Follow us:</p>
                                                        </li>
                                                        <li><i class="fa fa-facebook"></i></li>
                                                        <li><i class="fa fa-twitter"></i></li>
                                                        <li><i class="fa fa-google"></i></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-meta">
                                        <div id="tabs-default" class="tabs-default">
                                            <ul class="title-tabs none-style">
                                                <li><a href="#tab13"> Description </a></li>
                                                <li><a href="#tab23"> Reviews (2) </a></li>
                                            </ul>
                                            <div class="content-tabs">
                                                <div id="tab13">
                                                    <p>Fusce ornare mi vel risus porttitor dignissim. Nunc eget risus at
                                                        ipsum blandit ornare vel sed velit. Proin gravida arcu nisl, a
                                                        dignissim mauris placerat id.</p>
                                                    <p>Tristique senectus et netus et malesuada fames ac turpis egestas.
                                                        Duis a hendrerit risus. In non tristique libero. Pellentesque
                                                        elementum justo at diam feugiat lobortis. </p>
                                                    <p>Pellentesque habitant morbi tristique senectus et netus et
                                                        malesuada fames ac turpis egestas. Vestibulum tortor quam,
                                                        feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu
                                                        libero sit amet quam egestas semper. Aenean ultricies mi vitae
                                                        est. Mauris placerat eleifend leo.</p>
                                                </div>
                                                <div id="tab23">
                                                    <div class="comment-list">
                                                        <h4>2 COMMENTS</h4>
                                                        <div class="comment-item">
                                                            <img src="images/faces/thum100/5.jpg" alt="">
                                                            <div class="box-info">
                                                                <div class="meta">
                                                                    <strong>Timothy Guzman</strong> - Feb 25, 2016
                                                                    <div class="rating">
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="text">
                                                                    <p>Great product!</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="comment-item">
                                                            <img src="images/faces/thum100/3.jpg" alt="">
                                                            <div class="box-info">
                                                                <div class="meta">
                                                                    <strong>Alice e. Somerville</strong> - Jul 12, 2016
                                                                    <div class="rating">
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star-o"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="text">
                                                                    <p>Great product!</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="review">
                                                        <h4>YOUR REVIEW</h4>
                                                        <div class="rating">
                                                            <i class="fa fa-star-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                        </div>
                                                        <form action="#" class="comment-form">
                                                            <div class="row-comment">
                                                                <p class="col-6 comment-form-author">
                                                                    <input id="author" name="author" type="text"
                                                                           value="" placeholder="your name">
                                                                </p>
                                                                <p class="col-6 comment-form-email">
                                                                    <input id="email" name="email" type="email" value=""
                                                                           placeholder="your email">
                                                                </p>
                                                            </div>
                                                            <p class="comment-form-comment">
                                                                <textarea id="comment" name="comment"
                                                                          placeholder="your review..."></textarea>
                                                            </p>
                                                            <p class="form-submit">
                                                                <input name="submit" type="submit" id="submit"
                                                                       class="submit btn btn-color" value="submit">
                                                            </p>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Related product  start -->
                                <div class="pro-related">
                                    <h4>RELATED PRODUCTS</h4>
                                    <div id="product-owl" class="pro-slider">
                                        <div class="item-product">
                                            <div class="product-thumb">
                                                <div class="midd">
                                                    <a href="product.html"><img src="images/shop/3.jpg" alt=""></a>
                                                </div>
                                            </div>
                                            <div class="info-product">
                                                <h4>
                                                    <a href="product.html">Washing Machine</a>
                                                </h4>
                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-half-o"></i>
                                                </div>
                                                <p class="price">$230</p>
                                                <div class="add-cart">
                                                    <a href="#" class="related-btn">Add to Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-product">
                                            <div class="product-thumb">
                                                <div class="midd">
                                                    <a href="product.html"><img src="images/shop/4.jpg" alt=""></a>
                                                </div>
                                            </div>
                                            <div class="info-product">
                                                <h4>
                                                    <a href="product.html">Bag</a>
                                                </h4>
                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                </div>
                                                <p class="price">$140</p>
                                                <div class="add-cart">
                                                    <a href="#" class="related-btn">Add to Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-product">
                                            <div class="product-thumb">
                                                <div class="midd">
                                                    <a href="product.html"><img src="images/shop/5.jpg" alt=""></a>
                                                </div>
                                            </div>
                                            <div class="info-product">
                                                <h4>
                                                    <a href="product.html">Sony phone</a>
                                                </h4>
                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-o"></i>
                                                </div>
                                                <p class="price">$130</p>
                                                <div class="add-cart">
                                                    <a href="#" class="related-btn">Add to Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-product">
                                            <div class="product-thumb">
                                                <div class="midd">
                                                    <a href="product.html"><img src="images/shop/6.jpg" alt=""></a>
                                                </div>
                                            </div>
                                            <div class="info-product">
                                                <h4>
                                                    <a href="product.html">iphone 7</a>
                                                </h4>
                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <p class="price">$170</p>
                                                <div class="add-cart">
                                                    <a href="#" class="related-btn">Add to Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-product">
                                            <div class="product-thumb">
                                                <div class="midd">
                                                    <a href="product.html"><img src="images/shop/1.jpg" alt=""></a>
                                                </div>
                                            </div>
                                            <div class="info-product">
                                                <h4>
                                                    <a href="product.html">Black camera</a>
                                                </h4>
                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <p class="price">$170</p>
                                                <div class="add-cart">
                                                    <a href="#" class="related-btn">Add to Cart</a>
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
        </div>
    </section>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{asset('js/jquery.responsiveTabs.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/custom-product.js')}}"></script>
@endpush
