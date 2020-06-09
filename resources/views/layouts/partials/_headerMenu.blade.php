<nav class="nav">
    <ul class="main-menu">
        <li><a href="{{route('beranda')}}" class="{{Request::is('/*') ? 'active' : ''}}">
                <i class="fa fa-home"></i>&ensp;Beranda</a></li>
        <li><a href="#"><i class="fa fa-box-open"></i>&ensp;Produk</a></li>
        <li>
            <div class="top-new"><p>( 0 )</p></div>
            <a href="javascript:void(0)" onclick="showWishlist()"><i class="fa fa-heart"></i>&ensp;Wishlist</a>
        </li>
        @auth
            <li class="menu-item-has-children avatar">
                <a href="javascript:void(0)">
                    <img class="img-thumbnail show_ava" src="{{Auth::user()->get_bio->foto != "" ?
                asset('storage/users/foto/'.Auth::user()->get_bio->foto) :
                asset('images/faces/thumbs50x50/'.rand(1,6).'.jpg')}}">
                    <span class="show_username" style="text-transform: none">{{Auth::user()->username}}</span> <i
                        class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu dropdown-arrow">
                    @if(Auth::user()->isRoot() || Auth::user()->isAdmin())
                        <li><a href="{{route('admin.dashboard')}}"><i
                                    class="fa fa-tachometer-alt mr-2"></i>Dashboard</a>
                        </li>
                    @else
                        <li class="menu-item-has-children">
                            <a href="#"><i class="fa fa-user-tie mr-2"></i>Dashboard Klien <i
                                    class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-arrow">
                                <li><a href="{{route('dashboard.klien.proyek')}}">
                                        <i class="fa fa-business-time mr-2"></i>Tugas/Proyek</a></li>
                                <li><a href="{{route('dashboard.klien.layanan')}}">
                                        <i class="fa fa-tools mr-2"></i>Layanan</a></li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#"><i class="fa fa-hard-hat mr-2"></i>Dashboard Pekerja <i
                                    class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-arrow">
                                <li><a href="{{route('dashboard.pekerja.proyek')}}">
                                        <i class="fa fa-business-time mr-2"></i>Tugas/Proyek</a></li>
                                <li><a href="{{route('dashboard.pekerja.layanan')}}">
                                        <i class="fa fa-tools mr-2"></i>Layanan</a></li>
                            </ul>
                        </li>
                    @endif
                    <li><a href="{{Auth::user()->isRoot() || Auth::user()->isAdmin() ? route('admin.edit.profile') :
                route('user.profil')}}"><i class="fa fa-user-edit mr-2"></i>Sunting Profil</a></li>
                    <li><a href="{{Auth::user()->isRoot() || Auth::user()->isAdmin() ? route('admin.settings') :
                route('user.pengaturan')}}"><i class="fa fa-cogs mr-2"></i>Pengaturan Akun</a></li>
                    <li>
                        <a href="#" class="btn_signOut"><i class="fa fa-sign-out-alt"></i>&ensp;Keluar</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        @else
            <li><a href="javascript:void(0)" data-toggle="modal" onclick="openRegisterModal();">
                    <i class="fa fa-user-alt"></i>&ensp;Sign Up/In</a></li>
        @endauth
    </ul>
</nav>

<div class="header-cart">
    <div class="cart-icon">
        <img src="{{asset('images/shop/cart2.png')}}" alt="">
    </div>
    <div class="header-cart-item cart-dropdown">
        <span>Cart: <b>( 0 )</b></span>
        <p><a href="">Total: <b style="text-transform: none">Rp0,00</b></a></p>
        <div class="dropdown-content">
            @if(Auth::check() && 'data')
                <div class="item-box green">
                    <div class="image-info">
                        <img class="img-thumbnail" src="{{asset('images/shop/1.jpg')}}" alt="">
                    </div>
                    <div class="item-content">
                        <h2><a href="">Photo camera</a></h2>
                        <span>$ 400</span>
                    </div>
                    <div class="cart-delete green">
                        <a href=""><i class="fa fa-trash-o"></i></a>
                    </div>
                </div>
                <div class="item-box green">
                    <div class="image-info">
                        <img class="img-thumbnail" src="{{asset('images/shop/2.jpg')}}" alt="">
                    </div>
                    <div class="item-content">
                        <h2><a href="">HeadPhone</a></h2>
                        <span>$ 200</span>
                    </div>
                    <div class="cart-delete green">
                        <a href=""><i class="fa fa-trash-o"></i></a>
                    </div>
                </div>
                <div class="item-box green">
                    <div class="image-info">
                        <img class="img-thumbnail" src="{{asset('images/shop/3.jpg')}}" alt="">
                    </div>
                    <div class="item-content">
                        <h2><a href="">Washing Machine</a></h2>
                        <span>$ 355</span>
                    </div>
                    <div class="cart-delete green">
                        <a href=""><i class="fa fa-trash-o"></i></a>
                    </div>
                </div>
                <div class="text-center">
                    <p>SubTotal: $955</p>
                </div>
                <div class="text-center">
                    <a href="" class="btn cart-btn">View Cart</a>
                    <a href="" class="btn cart-btn color">Check Out</a>
                </div>
            @else
                <img class="img-responsive" src="{{asset('images/empty-cart.gif')}}" alt="Empty Cart">
                <div class="text-center">
                    <a href="#" class="btn cart-btn mb-2">Belanja Sekarang</a>
                </div>
            @endif
        </div>
    </div>
</div>
