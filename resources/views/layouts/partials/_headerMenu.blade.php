<nav class="nav">
    <ul class="main-menu">
        <li><a href="{{route('beranda')}}" class="{{Request::is('/*') ? 'active' : ''}}">
                <i class="fa fa-home"></i>&ensp;Beranda</a></li>
        <li><a href="{{route('cari')}}"><i class="fa fa-box-open"></i>&ensp;Produk</a></li>
        <li>
            <div class="top-new">
                <p class="show_wishlist">( {{Auth::check() ? count(Auth::user()->getWishlist) : 0}} )</p>
            </div>
            <a href="javascript:showWishlist()"><i class="fa fa-heart"></i>&ensp;Wishlist</a>
        </li>
        @if(Auth::check() || Auth::guard('admin')->check())
            <li class="menu-item-has-children avatar">
                <a href="javascript:void(0)">
                    @if(Auth::check())
                        <img class="img-thumbnail show_ava" src="{{Auth::user()->getBio->ava != "" ?
                        asset('storage/users/ava/'.Auth::user()->getBio->ava) :
                        asset('images/faces/'.rand(1,6).'.jpg')}}">
                        <span class="show_username" style="text-transform: none">
                        {{Auth::user()->username}}</span> <i class="fa fa-angle-down"></i>
                    @elseif(Auth::guard('admin')->check())
                        <img class="img-thumbnail show_ava" src="{{Auth::guard('admin')->user()->ava != "" ?
                        asset('storage/admins/ava/'.Auth::guard('admin')->user()->ava) :
                        asset('images/faces/'.rand(1,6).'.jpg')}}">
                        <span class="show_username" style="text-transform: none">
                            {{Auth::guard('admin')->user()->username}}</span> <i class="fa fa-angle-down"></i>
                    @endif
                </a>

                <ul class="dropdown-menu dropdown-arrow">
                    <li>
                        <a href="{{Auth::guard('admin')->check() ? route('admin.dashboard') : route('user.dashboard')}}">
                            <i class="fa fa-tachometer-alt"></i>Dashboard</a></li>
                    <li><a href="{{Auth::guard('admin')->check() ? route('admin.profil') : route('user.profil')}}">
                            <i class="fa fa-user-edit"></i>Sunting Profil</a></li>
                    <li>
                        <a href="{{Auth::guard('admin')->check() ? route('admin.pengaturan') : route('user.pengaturan')}}">
                            <i class="fa fa-cogs"></i>Pengaturan Akun</a></li>
                    <li>
                        <a href="javascript:void(0)" class="btn_signOut">
                            <i class="fa fa-sign-out-alt"></i>Sign Out
                        </a>
                        <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        @else
            <li><a href="javascript:openRegisterModal();"><i class="fa fa-user-alt"></i>&ensp;Sign Up/In</a></li>
        @endif
    </ul>
</nav>

<div class="header-cart">
    <div class="cart-icon">
        <img src="{{asset('images/shop/cart2.png')}}" alt="">
    </div>
    <div class="header-cart-item cart-dropdown">
        @auth
            @php $carts = \App\Models\Keranjang::where('user_id', Auth::id())->where('isCheckOut',false)->orderByDesc('id')->get(); @endphp
            @if(count($carts) > 0)
                <span>Cart: <b>( {{count($carts)}} )</b></span>
                <p><a href="javascript:void(0)">Total: <b style="text-transform: none">
                            Rp{{App\Support\Facades\NumberShorten::redenominate($carts->sum('total'))}}</b></a></p>
                <div class="dropdown-content px-0">
                    <div class="use-nicescroll mb-3" style="max-height: 200px;overflow: auto;">
                        <div class="px-4">
                            @foreach($carts as $row)
                                <div class="item-box green carts"
                                     onclick="actionOrder('{{$row->getProduk->nama}}','{{$row->getProduk->stock}}','{{$row->qty}}',
                                         '{{route('produk.cek.cart', ['produk' => $row->getProduk->permalink, 'id' => encrypt($row->id)])}}',
                                         '{{route('produk.update.cart', ['produk' => $row->getProduk->permalink, 'id' => encrypt($row->id)])}}',
                                         '{{route('produk.delete.cart', ['produk' => $row->getProduk->permalink, 'id' => encrypt($row->id)])}}')">
                                    <div class="image-info">
                                        <img class="img-thumbnail"
                                             src="{{asset('storage/produk/thumb/'.$row->getProduk->gambar)}}" alt="">
                                    </div>
                                    <div class="item-content">
                                        <h2><a href="javascript:void(0)">{{$row->getProduk->nama}}</a></h2>
                                        <span style="font-size:12px;font-weight: 500;text-transform: none">
                                        Rp{{number_format($row->getProduk->is_diskon == true ? $row->getProduk->harga_diskon : $row->getProduk->harga,2,',','.')}}
                                    </span>
                                    </div>
                                    <div class="cart-delete green">
                                        <span style="font-weight: 500;text-transform: none">x{{$row->qty}}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="btn-group text-center" style="margin-left: 2.5rem;">
                        <a href="{{route('user.cart')}}" class="btn btn-color2"
                           style="border-radius: 4px 0 0 4px !important;">
                            <i class="fa fa-shopping-cart pl-0 mr-2" style="color: #fff"></i> CART</a>
                        <a href="javascript:void(0)" class="btn btn-color6"
                           style="border-radius: 0 4px 4px 0 !important;"
                           onclick="checkout('{{implode(',',$carts->pluck('id')->toArray())}}')">
                            <i class="fa fa-wallet pl-0 mr-2" style="color: #fff"></i> CHECKOUT</a>
                        <form id="form-cart_ids" action="{{route('user.cart.checkout')}}" method="post">
                            @csrf
                            <input type="hidden" name="cart_ids">
                        </form>
                    </div>
                </div>
            @else
                <span>Cart: <b>( 0 )</b></span>
                <p><a href="javascript:void(0)">Total: <b style="text-transform: none">Rp0,00</b></a></p>
                <div class="dropdown-content">
                    <img class="img-responsive" src="{{asset('images/empty-cart.gif')}}" alt="Empty Cart">
                    <div class="text-center">
                        <a href="{{route('cari')}}" class="btn btn-block cart-btn mb-2" style="font-weight: 600">
                            <i class="fa fa-search pl-0 mr-2" style="color: #fff"></i> BELANJA SEKARANG</a>
                    </div>
                </div>
            @endif
        @else
            <span>Cart: <b>( 0 )</b></span>
            <p><a href="javascript:void(0)">Total: <b style="text-transform: none">Rp0,00</b></a></p>
            <div class="dropdown-content">
                <img class="img-responsive" src="{{asset('images/empty-cart.gif')}}" alt="Empty Cart">
                <div class="text-center">
                    <a href="{{route('cari')}}" class="btn btn-block cart-btn mb-2" style="font-weight: 600">
                        <i class="fa fa-search pl-0 mr-2" style="color: #fff"></i> BELANJA SEKARANG</a>
                </div>
            </div>
        @endauth
    </div>
</div>
