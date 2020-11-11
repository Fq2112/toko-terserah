<!DOCTYPE html>
<!--[if IE 8]>
<html class="no-js lt-ie9" lang="en">
<![endif]-->
<!--[if gt IE 8]>
<!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="keywords" content="HTML5 Template , Responsive , html5 , css3">
    <meta name="description" content="{{env('APP_TITLE')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('favicon.ico')}}">

    <!-- jQuery-ui css -->
    <link rel="stylesheet" href="{{asset('vendor/jquery-ui/jquery-ui.min.css')}}">
    <!-- Bootstrap-3.3.7 fremwork css -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/glyphicons.css')}}"/>
    <!-- Core Style css -->
    <link rel="stylesheet" href="{{asset('css/colorbox.css')}}"/>
    <!-- Slider carousel css  -->
    <link rel="stylesheet" href="{{asset('css/owl.carousel.css')}}">
    <!-- Fontawesome 5.10.1 -->
    <link rel="stylesheet" type="text/css" href="{{asset('fonts/fontawesome/css/all.css')}}">
    <!-- Main style css -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}"/>
    <!-- shop css -->
    <link rel="stylesheet" href="{{asset('css/shop.css')}}">
    <!-- effects css -->
    <link rel="stylesheet" href="{{asset('css/components/effects.css')}}">
    <!-- fancybox css -->
    <link rel="stylesheet" href="{{asset('css/sliders/stylesheet.css')}}">
    <link rel="stylesheet" href="{{asset('css/components/jquery.fancybox.css')}}">
    <!-- animate css -->
    <link rel="stylesheet" href="{{asset('css/animate.css')}}">
    <!-- modal -->
    <link rel="stylesheet" href="{{asset('css/modal.css')}}">
    <!-- ajax-loader -->
    <link rel="stylesheet" href="{{asset('css/ajax-loader.css')}}">
    <!-- select2 -->
    <link href="{{asset('vendor/select2/dist/css/select2.css')}}" rel="stylesheet"/>
    <!-- Loading.io -->
    <link href="{{asset('css/loading.css')}}" rel="stylesheet">
    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="{{asset('vendor/sweetalert/sweetalert2.css')}}">
    <link rel="stylesheet" href="{{asset('css/additional.css')}}">

    <style>
        .avatar img {
            height: 40px;
        }

        .header-cart {
            display: unset !important;
        }

        .cart-dropdown {
            display: inline-block !important;
        }

        .swal-overlay {
            z-index: 9999999 !important;
        }

        @media (min-width: 1440px) {
            .download-phone-ico {
                width: 50%;
                float: left;
            }

            .download-apps-ico {
                width: 50%;
                float: right;
            }
        }

        @media (min-width: 1281px) and (max-width: 1439px) {
            .download-phone-ico {
                width: 50%;
                float: left;
            }

            .download-apps-ico {
                width: 50%;
                float: right;
            }
        }

        @media (min-width: 1025px) and (max-width: 1280px) {
            .download-phone-ico {
                width: 50%;
                float: left;
            }

            .download-apps-ico {
                width: 50%;
                float: right;
            }
        }

        @media (min-width: 768px) and (max-width: 1024px) {
            .download-phone-ico {
                width: 30%;
                float: left;
            }

            .download-apps-ico {
                width: 30%;
                float: left;
            }
        }

        @media (min-width: 768px) and (max-width: 1024px) and (orientation: landscape) {
            .download-phone-ico {
                width: 30%;
                float: left;
            }

            .download-apps-ico {
                width: 30%;
                float: left;
            }
        }

        @media (min-width: 481px) and (max-width: 767px) {
            .download-phone-ico {
                width: 50%;
                float: right;
            }

            .download-apps-ico {
                width: 50%;
                float: right;
            }
        }

        @media (min-width: 320px) and (max-width: 480px) {
            .header-cart {
                margin-right: 1em;
            }

            .main-bar .nav .main-menu {
                height: unset;
            }

            .dropdown-btn {
                top: 30px;
            }

            .categorys {
                display: none;
            }

            section.paddtop-50 {
                padding: 1em;
            }

            .download-phone-ico {
                width: 50%;
                float: left;
            }

            .download-apps-ico {
                width: 50%;
                float: right;
            }
        }
    </style>
    @stack('styles')

    <script src='https://www.google.com/recaptcha/api.js?onload=recaptchaCallback&render=explicit' async defer></script>
</head>

<body class="use-nicescroll" @if(Request::is(['*info/syarat-ketentuan*', '*info/kebijakan-privasi*'])) data-spy="scroll"
      data-target="#toc" @endif>
<div class="images-preloader">
    <div class="load">
        <hr>
        <hr>
        <hr>
        <hr>
    </div>
</div>

<div class="wrapper">
    <header class="site-header shop-header">
        <div class="sub-bar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="contacts">
                            <p><a href="tel:+628113051081"><i class="fa fa-phone fa-flip-horizontal pl-0"></i><b>Telepon:</b>
                                    +62 811-3051-081</a></p>
                            <p><a href="mailto:{{env('MAIL_USERNAME')}}"><i
                                        class="fa fa-envelope"></i><b>Email:</b> {{env('MAIL_USERNAME')}}</a></p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="social-media">
                            <a class="facebook" href="https://fb.com/pages/PT-Penta-Surya-Pratama/102397424580976"
                               target="_blank">
                                <i class="fab fa-facebook-f"
                                   style="color:#455CA8;font-weight:900"></i>&ensp;FACEBOOK</a>
                            <a class="instagram" href="https://instagram.com/terlengkapserbamurah" target="_blank">
                                <i class="fab fa-instagram"
                                   style="color:#E1306C;font-weight:900"></i>&ensp;INSTAGRAM</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-bar" id="main-bar">
            <div class="container">
                <div class="logo">
                    <a href="{{route('beranda')}}">
                        <img src="{{asset('images/logo-TT.png')}}" width="73" alt="Logo">
                    </a>
                </div>

                <button class="btn-toggle"><i class="fa fa-bars"></i></button>

                @include('layouts.partials._headerMenu')
            </div>
        </div>
    </header>

    <div class="main-content home-page">
        <section class="search-bar">
            <div class="container">
                <div class="row">
                    @if(Request::is('/*'))
                        <div class="col-md-3">
                            <div class="categorys"
                                 onclick="window.location.href='{{route('cari', ['kat' => 'semua'])}}'">
                                <a href="{{route('cari', ['kat' => 'semua'])}}">
                                    <i class="fa fa-align-justify"></i> Kategori Produk</a>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-{{Request::is('/*') ? '9' : '12'}}">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="search-category">
                                    <div class="input-group">
                                        <input id="keyword" type="text" class="form-control-2" name="q"
                                               placeholder="Cari&hellip;" style="border-radius: 7px 0 0 7px"
                                               value="{{Request::is('cari*') ? $q : null}}">
                                        <span class="input-group-btn">
                                            <button id="btn_reset" class="btn btn-default" type="reset"
                                                    style="display: {{Request::is('cari*') && !is_null($q) ? '' : 'none'}}">
                                                <span class="fa fa-times"></span>
                                            </button>
                                            <button class="btn btn-default color-2" type="submit">
                                                <span class="fa fa-search"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @yield('content')

        <form id="form-cart" method="post">
            @csrf
            <input type="hidden" name="_method">
            <input type="hidden" name="cek">
            <input type="hidden" name="qty">
            <input type="hidden" name="qty_lama">
        </form>
    </div>

    <footer class="footer3">
        <div class="content-widgets">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="footer-widget widget">
                            <h4 data-toc-skip>Telah Tersedia</h4>
                            <img class="download-phone-ico" src="{{asset('images/phone.png')}}">
                            <div class="download-apps-ico">
                                <a href="https://play.google.com/store/apps/details?id=com.tokoterserah.mobile">
                                    <img class="zoom img-responsive" src="{{asset('images/GooglePlay.png')}}">
                                </a>
                                <hr>
                                <a href="https://itunes.apple.com/id/app/tokoterserah.com/id1143444473?mt=8">
                                    <img class="zoom img-responsive" src="{{asset('images/AppStore.png')}}">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="footer-widget widget">
                            <h4 data-toc-skip>Tautan Lain</h4>
                            <ul class="contact">
                                <li><a href="{{route('tentang')}}"><i class="fa fa-caret-right"></i> Tentang Kami</a>
                                </li>
                                <li><a href="{{route('syarat-ketentuan')}}"><i class="fa fa-caret-right"></i> Syarat &
                                        Ketentuan</a></li>
                                <li><a href="{{route('kebijakan-privasi')}}"><i class="fa fa-caret-right"></i> Kebijakan
                                        Privasi</a></li>
                                <li><a href="{{route('kontak')}}"><i class="fa fa-caret-right"></i> Kontak</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="footer-widget widget">
                            <h4 data-toc-skip>Tetap Terhubung</h4>
                            <ul class="contact">
                                <li>
                                    <i class="fa fa-map-marked-alt" style="color: #fff"></i>
                                    Jl. Raya Lontar No. 46 Surabaya – 60216
                                </li>
                                <li><a href="tel:+628113051081"><i class="fa fa-phone fa-flip-horizontal"
                                                                   style="padding-right: 0;padding-left: 10px;"></i> +62
                                        811-3051-081</a></li>
                                <li><a href="mailto:{{env('MAIL_USERNAME')}}"><i class="fa fa-envelope"></i>
                                        {{env('MAIL_USERNAME')}}</a></li>
                            </ul>
                            <div class="social-media">
                                <a class="facebook" href="https://fb.com/pages/PT-Penta-Surya-Pratama/102397424580976"
                                   target="_blank">
                                    <i class="fab fa-facebook-f"></i>&ensp;FACEBOOK</a>
                                <a class="instagram" href="https://instagram.com/terlengkapserbamurah" target="_blank">
                                    <i class="fab fa-instagram"></i>&ensp;INSTAGRAM</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="copyright-3 mt-0">
                    <div class="row">
                        <div class="container">
                            <div class="col-md-7">
                                <p>© {{now()->format('Y').' '.env('APP_COMPANY')}}. All rights reserved | Designed &
                                    Developed by <a href="http://rabbit-media.net" target="_blank">HEALER DevOps</a></p>
                            </div>
                            <div class="col-md-5">
                                <ul class="footer-menu none-style">
                                    <li data-toggle="tooltip" title="MITRA PEMBAYARAN">
                                        <a href="https://midtrans.com/" target="_blank">
                                            <img src="{{asset('images/midtrans.svg')}}" alt="Midtrans">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

@include('layouts.partials._signUpIn')

<div id="gotoTop" class="fa fa-arrow-up"></div>
<div class="myProgress">
    <div class="bar"></div>
</div>

<!-- Jquery -->
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/jquery.fancybox.js')}}"></script>
<!-- jQuery-ui js -->
<script src="{{asset('vendor/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Bootstrap js -->
<script type="text/javascript" src="{{asset('js/bootstrap.js')}}"></script>
<!-- Carousel Slider js -->
<script type="text/javascript" src="{{asset('js/owl.carousel.min.js')}}"></script>
<!-- Jquery accordion  js -->
<script type="text/javascript" src="{{asset('js/smk-accordion.js')}}"></script>
<script type="text/javascript" src="{{asset('js/visible.min.js')}}"></script>
<!-- counter up Requires js -->
<script type="text/javascript" src="{{asset('js/waypoints.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.easing.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.counterup.min.js')}}"></script>
<!-- Jquery progressbar js -->
<script type="text/javascript" src="{{asset('js/pro-bars.js')}}"></script>
<script type="text/javascript" src="{{asset('js/classie.js')}}"></script>
<!-- wow animate js -->
<script type="text/javascript" src="{{asset('js/wow.js')}}"></script>
<!-- Jquery about js -->
<script type="text/javascript" src="{{asset('js/index-shop.js')}}"></script>
<!-- Jquery progressbar  js -->
<script type="text/javascript" src="{{asset('js/progressbar.js')}}"></script>
<!-- Top Header fixed js -->
<script type="text/javascript" src="{{asset('js/header-fixed.js')}}"></script>

<!-- modal -->
<script src="{{asset('js/modal.js')}}"></script>
<!-- toggle password -->
<script src="{{asset('js/hideShowPassword.min.js')}}"></script>
<!-- jquery-maskMoney -->
<script src="{{asset('js/jquery.maskMoney.js')}}"></script>
<!-- moment Plugin -->
<script src="{{asset('vendor/moment-with-locales.min.js')}}"></script>
<!-- select2 -->
<script src="{{asset('vendor/select2/dist/js/select2.full.min.js')}}"></script>
<!-- check-mobile -->
<script src="{{asset('vendor/checkMobileDevice.js')}}"></script>
<!-- Nicescroll -->
<script src="{{asset('vendor/nicescroll/jquery.nicescroll.js')}}"></script>
<!-- smooth-scrollbar -->
<script src="{{asset('vendor/smooth-scrollbar/smooth-scrollbar.js')}}"></script>
<!-- Sweetalert2 -->
<script src="{{asset('vendor/sweetalert/sweetalert.min.js')}}"></script>
@stack('scripts')
@include('layouts.partials._scripts')
@include('layouts.partials._alert')
@include('layouts.partials._confirm')
</body>
</html>
