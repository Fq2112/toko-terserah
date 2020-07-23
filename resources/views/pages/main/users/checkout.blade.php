@extends('layouts.mst')
@section('title', 'Cart ('.count($carts).' produk): '.$user->name.' | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('css/card.css')}}">
    <link rel="stylesheet" href="{{asset('css/gmaps.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('admins/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Select-1.2.4/css/select.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Buttons-1.5.6/css/buttons.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/lightgallery/dist/css/lightgallery.min.css')}}">
    <style>
        blockquote {
            background: unset;
            border-color: unset;
            color: unset;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .table-striped a {
            color: #777;
            font-weight: 500;
            transition: all .3s ease;
            text-decoration: none !important;
        }

        .table-striped a:hover, .table-striped a:focus, .table-striped a:active {
            color: #5bb300;
        }

        .single-price {
            font-family: 'Raleway', sans-serif;
            font-weight: 700;
            color: #5bb300;
        }

        .single-price s {
            color: #aaa !important;
            padding-left: 5px;
            font-size: 12px;
        }

        .single-price span {
            color: #555 !important;
            font-size: 12px;
        }

        .lg-backdrop {
            z-index: 9999999;
        }

        .lg-outer {
            z-index: 10000000;
        }

        .lg-sub-html h4 {
            color: #eee;
        }

        .lg-sub-html p {
            color: #bbb;
        }

        .component-accordion .panel-group .panel {
            border: 0 none;
            box-shadow: 0 4px 5px -1px #E5E5E5;
            margin-bottom: 15px;
        }

        .component-accordion .panel-group .panel-heading {
            background-color: #fff;
            border-radius: 5px 5px 0 0;
            color: #444;
            padding: 0;
        }

        .component-accordion .panel-group .panel-heading h4 {
            margin: 0;
        }

        .component-accordion .panel-group .panel-heading a:hover.active,
        .component-accordion .panel-group .panel-heading a.active {
            color: #5bb300;
        }

        .component-accordion .panel-group .panel-title a {
            border-radius: 5px 5px 0 0;
            color: #888;
            display: block;
            font-size: 16px;
            font-weight: 500;
            text-transform: none;
            position: relative;
            padding: 15px;
            transition: color .2s ease-in-out;
        }

        .component-accordion .panel-group .panel-title a:hover {
            color: #444;
            text-decoration: none;
        }

        .component-accordion .panel-group .panel-title a b {
            margin-right: 4em;
            float: right;
        }

        .component-accordion .panel-group .panel-title a.collapsed::after,
        .component-accordion .panel-group .panel-title a::after {
            border-left: 1px solid #eee;
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            content: "\f044";
            line-height: 48px;
            padding-left: 20px;
            position: absolute;
            right: 19px;
            top: 0;
        }

        .component-accordion .panel-group .panel-title a:after {
            content: "\f044";
        }

        .component-accordion .panel-body {
            background: #fff;
            color: #888;
            padding: 20px;
        }

        .component-accordion .panel-group .panel-heading + .panel-collapse > .panel-body,
        .component-accordion .panel-group .panel-heading + .panel-collapse > .list-group {
            border-top: 1px solid #eee;
        }

        .toggle-border {
            border-color: #E5E5E5 !important;
        }

        .togglet {
            font-size: 14px !important;
            padding: 0 1em !important;
        }

        .togglet i {
            left: unset !important;
            right: 1em;
            font-size: 14px !important;
        }

        .togglec {
            padding: 0 1em .5em !important;
        }

        .togglec .list-group-flush {
            margin: 0 !important;
        }

        .togglec .list-group-item {
            padding: 0.75rem 0 !important;
        }

        .card-label {
            width: 100%;
        }

        .card-label .card-title {
            text-transform: none;
        }

        .card-rb {
            display: none;
        }

        .card-input {
            cursor: pointer;
            border: 1px solid #eee;
            -webkit-transition: all .2s ease-in-out;
            -moz-transition: all .2s ease-in-out;
            transition: all .2s ease-in-out;
            opacity: .6;
        }

        .card-input:hover {
            border-color: #5bb300;
            opacity: .8;
        }

        .card-rb:checked + .card-input {
            border-color: #5bb300;
            opacity: 1;
        }

        .card-input .card-img-overlay {
            background: rgba(0, 0, 0, 0.4);
            font-size: 2rem;
            opacity: 0;
            -webkit-transition: all .3s ease-in-out;
            -moz-transition: all .3s ease-in-out;
            transition: all .3s ease-in-out;
        }

        .card-input a:hover .card-img-overlay {
            opacity: 1;
            color: #fff;
        }

        .card-input img {
            /*width: 128px;*/
            height: 100%;
        }

        .card-input .card-title {
            font-weight: 600 !important;
            font-size: 15px;
            text-transform: none !important;
        }

        .card-input .card-text {
            font-weight: 500;
            line-height: unset !important;
        }
    </style>
@endpush
@section('content')
    <div class="breadcrumbs" style="background-image: url('{{$bio->background != null ?
    asset('storage/users/background/'.$bio->background) : asset('images/page-header/users.jpg')}}')">
        <div class="breadcrumbs-overlay"></div>
        <div class="page-title">
            <h2>Cart</h2>
            <p>Di sini Anda dapat mengelola pesanan Anda dan menyelesaikan pembayarannya.</p>
        </div>
        <ul class="crumb">
            <li><a href="{{route('beranda')}}"><i class="fa fa-home"></i></a></li>
            <li style="text-transform: none"><i class="fa fa-angle-double-right"></i>
                <a href="{{URL::current()}}">Akun</a></li>
            <li><a href="#" onclick="goToAnchor()"><i class="fa fa-angle-double-right"></i> Cart</a></li>
        </ul>
    </div>

    <section class="none-margin" style="padding: 40px 0">
        <div class="container px-0">
            <form id="form-pembayaran" class="row" method="POST" onkeydown="return event.key != 'Enter';">
                @csrf
                <input type="hidden" name="user_id" value="{{$user->id}}">
                <input type="hidden" name="lang" value="{{app()->getLocale()}}">

                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="card {{count($carts) > 0 ? 'mb-4' : ''}}">
                        <div class="card-content">
                            <div class="card-title">
                                <h4 class="text-center" style="color: #5bb300">Daftar Pesanan</h4>
                                <h5 class="text-center mb-2" style="text-transform: none">
                                    Kelola pesanan Anda terlebih dahulu sebelum menyelesaikan pembayarannya</h5>
                                <hr class="mt-0">
                                @if(count($carts) > 0)
                                    <div class="component-accordion">
                                        <div class="panel-group" id="accordion" role="tablist">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="heading-dt">
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse"
                                                           href="#collapse-dt" aria-expanded="false"
                                                           aria-controls="collapse-dt" class="collapsed">
                                                            {{count($carts)}} Produk
                                                            <b>Rp{{number_format($carts->sum('total'), 2,',','.')}}</b>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse-dt" class="panel-collapse collapse"
                                                     role="tabpanel" aria-labelledby="heading-dt"
                                                     aria-expanded="false" style="height: 0;"
                                                     data-parent="#accordion">
                                                    <div class="panel-body">
                                                        <div class="table-responsive" id="dt-produk">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                <tr>
                                                                    <th class="text-center">#</th>
                                                                    <th>Produk</th>
                                                                    <th class="text-center">Qty.</th>
                                                                    <th class="text-right">Total</th>
                                                                    <th class="text-center">Aksi</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @php $no = 1; $subtotal = 0; $total_weight = 0; @endphp
                                                                @foreach($carts as $row)
                                                                    @php
                                                                        $wishlist = \App\Models\Favorit::where('user_id', $user->id)->where('produk_id', $row->produk_id)->first();
                                                                        $subtotal += $row->total;
                                                                        $total_weight += $row->berat / 1000;
                                                                    @endphp
                                                                    <tr>
                                                                        <td style="vertical-align: middle"
                                                                            align="center">{{$no++}}</td>
                                                                        <td style="vertical-align: middle">
                                                                            <div class="row float-left mr-0">
                                                                                <div class="col-lg-12">
                                                                                    <a href="javascript:void(0)"
                                                                                       id="preview{{$row->id}}"
                                                                                       onclick="preview('{{$row->id}}','{{$row->getProduk->nama}}',
                                                                                           '{{route('get.galeri.produk', ['produk' => $row->getProduk->permalink])}}')">
                                                                                        <img width="80" alt="Thumbnail"
                                                                                             class="img-thumbnail"
                                                                                             src="{{asset('storage/produk/thumb/'.$row->getProduk->gambar)}}">
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                            <span
                                                                                class="label label-{{$row->getProduk->stock > 0 ? 'success' : 'danger'}}">
                                            Tersedia: <b>{{$row->getProduk->stock}}</b> pcs</span> |
                                                                            <span class="label label-warning">
                                            Berat: <b>{{number_format($row->getProduk->berat / 1000,2,',','.')}}</b> kg
                                        </span>
                                                                            <br><a
                                                                                href="{{route('produk', ['produk' => $row->getProduk->permalink])}}">
                                                                                <b>{{$row->getProduk->nama}}</b></a>
                                                                            <p class="single-price mb-0">
                                                                                @if($row->getProduk->is_diskon == true)
                                                                                    Rp{{number_format($row->getProduk->harga_diskon,2,',','.')}}
                                                                                    <s>Rp{{number_format($row->getProduk->harga,2,',','.')}}</s>
                                                                                    <span>-{{$row->getProduk->diskon}}%</span>
                                                                                @else
                                                                                    Rp{{number_format($row->getProduk->harga,2,',','.')}}
                                                                                @endif
                                                                            </p>
                                                                        </td>
                                                                        <td style="vertical-align: middle"
                                                                            align="center"><b>{{$row->qty}}</b> pcs
                                                                        </td>
                                                                        <td style="vertical-align: middle"
                                                                            align="right">
                                                                            <b>Rp{{number_format($row->total,2,',','.')}}</b>
                                                                        </td>
                                                                        <td style="vertical-align: middle"
                                                                            align="center">
                                                                            <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-color2 btn-sm" style="border-radius:4px 0 0 4px;"
                                                        data-toggle="tooltip" title="Pindah ke Wishlist"
                                                        onclick="addWishlist('{{$row->getProduk->nama}}',
                                                            '{{route('user.add.wishlist', ['cart_id' => encrypt($row->id)])}}')">
                                                    <i class="fa fa-heart" style="margin-right: 0"></i>
                                                </button>
                                                <button class="btn btn-color4 btn-sm"
                                                        data-toggle="tooltip" title="Sunting Cart"
                                                        onclick="editCart('{{$row->getProduk->nama}}','{{$row->getProduk->stock}}','{{$row->qty}}',
                                                            '{{route('produk.cek.cart', ['produk' => $row->getProduk->permalink, 'id' => encrypt($row->id)])}}',
                                                            '{{route('produk.update.cart', ['produk' => $row->getProduk->permalink, 'id' => encrypt($row->id)])}}')">
                                                    <i class="fa fa-edit" style="margin-right: 0"></i>
                                                </button>
                                                <button class="btn btn-color5 btn-sm" style="border-radius:0 4px 4px 0;"
                                                        data-toggle="tooltip" title="Hapus Cart"
                                                        onclick="deleteCart('{{$row->getProduk->nama}}',
                                                            '{{route('produk.delete.cart', ['produk' => $row->getProduk->permalink, 'id' => encrypt($row->id)])}}')">
                                                    <i class="fa fa-trash-alt" style="margin-right: 0"></i>
                                                </button>
                                            </span>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="row text-center">
                                        <div class="col-lg-12">
                                            <img width="300" class="img-responsive" alt="Empty Cart"
                                                 src="{{asset('images/empty-cart.gif')}}">
                                            <h3 class="mt-0 mb-1" style="text-transform: none">
                                                Anda belum membuat pesanan apapun</h3>
                                            <h4 class="mt-0 mb-3" style="text-transform: none">
                                                Lengkapi kebutuhan cetak Anda sekarang</h4>
                                            <a href="{{route('cari')}}" class="btn btn-color2 mb-3">
                                                <i class="fa fa-shopping-cart mr-2"></i> <b>BELANJA SEKARANG</b>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if(count($carts) > 0)
                        <div class="card">
                            <div class="card-content">
                                <div class="card-title" style="text-transform: none">
                                    <h4 class="text-center" style="color: #5bb300">Penerima Pesanan</h4>
                                    <h5 class="text-center mb-2" style="text-transform: none">
                                        Tentukan kemana pesanan Anda akan dikirim beserta tagihannya</h5>
                                    <hr class="mt-0">
                                    <div class="component-accordion">
                                        <div id="preload-shipping" class="ajax-loader" style="display: none">
                                            <div class="preloader4"></div>
                                        </div>
                                        <div class="panel-group" id="accordion2" role="tablist">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="heading-shipping">
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse"
                                                           href="#collapse-shipping" aria-expanded="false"
                                                           aria-controls="collapse-shipping" class="collapsed">
                                                            Alamat Pengiriman
                                                            <b class="show-shipping">&ndash;</b>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse-shipping" class="panel-collapse collapse"
                                                     role="tabpanel" aria-labelledby="heading-shipping"
                                                     aria-expanded="false" style="height:0;"
                                                     data-parent="#accordion2">
                                                    <div class="panel-body">
                                                        <div
                                                            class="row {{count($addresses) > 0 ? '' : 'justify-content-center text-center'}} addressee">
                                                            @if(count($addresses) > 0)
                                                                @foreach($addresses as $row)
                                                                    @php $occupancy = $row->isUtama == false ? $row->getOccupancy->name : $row->getOccupancy->name.' [Alamat Utama]'; @endphp
                                                                    <div class="col-lg-12 mb-3">
                                                                        <label class="card-label"
                                                                               for="shipping_{{$row->id}}">
                                                                            <input id="shipping_{{$row->id}}"
                                                                                   class="card-rb" type="radio"
                                                                                   name="shipping_id"
                                                                                   value="{{$row->id}}"
                                                                                   data-name="{{$occupancy}}">
                                                                            @php $check = 'shipping'; @endphp
                                                                            @include('layouts.partials.users._shippingForm')
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div class="col-lg-12">
                                                                    <img width="256" class="img-responsive" alt="Empty"
                                                                         src="{{asset('images/empty-cart.gif')}}">
                                                                    <h3 class="mt-0 mb-1">
                                                                        Anda belum membuat alamat manapun</h3>
                                                                    <h4 class="m-0" style="text-transform: none">
                                                                        Buka halaman "Sunting Profil" dan kelola daftar
                                                                        alamat Anda sekarang</h4>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="panel panel-default" style="display: none">
                                                <div class="panel-heading" role="tab" id="heading-billing">
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse"
                                                           href="#collapse-billing" aria-expanded="false"
                                                           aria-controls="collapse-billing" class="collapsed">
                                                            Alamat Penagihan
                                                            <b class="show-billing">&ndash;</b>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse-billing" class="panel-collapse collapse"
                                                     role="tabpanel" aria-labelledby="heading-billing"
                                                     aria-expanded="false" style="height:0;" data-parent="#accordion2">
                                                    <div class="panel-body">
                                                        <div
                                                            class="row {{count($addresses) > 0 ? '' : 'justify-content-center text-center'}} addressee">
                                                            @if(count($addresses) > 0)
                                                                @foreach($addresses as $row)
                                                                    @php $occupancy = $row->isUtama == false ? $row->getOccupancy->name : $row->getOccupancy->name.' [Alamat Utama]'; @endphp
                                                                    <div class="col-lg-12 mb-3">
                                                                        <label class="card-label"
                                                                               for="billing_{{$row->id}}">
                                                                            <input id="billing_{{$row->id}}"
                                                                                   class="card-rb" type="radio"
                                                                                   name="billing_id"
                                                                                   value="{{$row->id}}"
                                                                                   data-name="{{$occupancy}}">
                                                                            @php $check = 'billing'; @endphp
                                                                            @include('layouts.partials.users._shippingForm')
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div class="col-lg-12">
                                                                    <img width="256" class="img-responsive" alt="Empty"
                                                                         src="{{asset('images/empty-cart.gif')}}">
                                                                    <h3 class="mt-0 mb-1">
                                                                        Anda belum membuat alamat manapun</h3>
                                                                    <h4 class="m-0" style="text-transform: none">
                                                                        Buka halaman "Sunting Profil" dan kelola daftar
                                                                        alamat Anda sekarang</h4>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="panel panel-default mb-0">
                                                <div class="panel-heading" role="button">
                                                    <button type="button" onclick="addAddress()"
                                                            class="btn btn-block btn-color2">
                                                        <i class="fa fa-map-marked-alt mr-2"></i> Tambah Alamat
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card">
                        <div class="card-content pb-0">
                            <div class="card-title m-0">
                                <h4 class="text-center" style="color: #5bb300">Ringkasan Pesanan</h4>
                                <h5 class="text-center mb-2" style="text-transform: none">Pastikan pesanan Anda
                                    benar</h5>
                                <hr class="mt-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="promo_code">Kode Promo</label>
                                        <div class="input-group">
                                            <input id="promo_code" type="text" class="form-control" name="promo_code"
                                                   placeholder="Masukkan kode promo Anda..." disabled>
                                            <span class="input-group-btn">
                                                <button id="btn_set" class="btn btn-color2" type="button"
                                                        disabled style="font-size: 14px">
                                                    SET
                                                </button>
                                            </span>
                                        </div>
                                        <span id="error_promo" class="help-block">
                                            <b style="text-transform: none"></b>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ajax-loader" style="display: none">
                            <div class="preloader4"></div>
                        </div>
                        <ul class="list-group list-group-flush mb-0">
                            <li class="list-group-item border-none">
                                Subtotal ({{count($carts)}} produk)
                                <b class="float-right">
                                    {!! count($carts) > 0 ? 'Rp'.number_format($subtotal,2,',','.') : '&ndash;' !!}
                                </b>
                            </li>
                            <li class="list-group-item border-none">
                                Berat
                                <b class="float-right">
                                    {!! count($carts) > 0 ? number_format($total_weight,2,',','.').' kg' : '&ndash;' !!}
                                </b>
                            </li>
                            <li class="list-group-item border-none">
                                Ongkir
                                <b class="float-right show-ongkir">&ndash;</b>
                            </li>
                            <li class="list-group-item border-none">
                                Durasi Pengiriman
                                <b class="float-right show-delivery">&ndash;</b>
                            </li>
                            <li class="list-group-item border-none">
                                Paket Diterima
                                <i class="fa fa-info-circle ml-1" data-toggle="popover"
                                   data-placement="top" title="PERHATIAN!" style="cursor: help;float: none;margin: 0"
                                   data-content="Anda akan menerima produk cetak tersebut setelah proses produksi selesai ditambah dengan durasi pengirimannya."></i>
                                <b class="float-right show-received">&ndash;</b>
                            </li>
                            <li id="discount" class="list-group-item border-none" style="display: none">
                                Diskon <strong></strong>
                                <i class="fa fa-trash-alt ml-1" data-toggle="tooltip" data-placement="right"
                                   title="HAPUS" style="cursor:pointer;float:none"></i>
                                <b class="float-right"></b>
                            </li>
                        </ul>
                        <div class="card-content py-2">
                            <div class="card-title m-0">
                                <hr class="my-0">
                            </div>
                        </div>
                        <ul class="list-group list-group-flush mb-0">
                            <li class="list-group-item border-none">
                                TOTAL<b class="float-right show-total" style="font-size: large">
                                    {!!count($carts) > 0 ? 'Rp'.number_format($subtotal,2,',','.') : '&ndash;'!!}</b>
                            </li>
                        </ul>
                        <div class="card-content py-3">
                            <div class="alert alert-warning text-justify">
                                <i class="fa fa-exclamation-sign"></i><b>PERHATIAN!</b>
                                <span
                                    id="shipping-alert">Silahkan pilih alamat pengiriman pesanan Anda terlebih dahulu.</span>
                                <span id="billing-alert" style="display: none">Silahkan pilih alamat penagihan pesanan Anda terlebih dahulu.</span>
                            </div>
                        </div>
                        <div class="card-footer p-0">
                            <button id="btn_pay" type="button" style="text-align: left" disabled
                                    class="btn btn-color2 btn-block text-uppercase border-none">
                                CHECKOUT <i class="fa fa-chevron-right float-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="cart_ids"
                       value="{{implode(',', $carts->pluck('id')->toArray())}}">
                <input type="hidden" name="subtotal"
                       value="{{count($carts) > 0 ? $subtotal : null}}">
                <input id="total_weight" type="hidden" name="total_weight"
                       value="{{count($carts) > 0 ? number_format($total_weight,2,'.',',') : null}}">
                <input type="hidden" name="discount">
                <input type="hidden" name="discount_price">
                <input id="ongkir" type="hidden" name="ongkir">
                <input id="delivery_duration" type="hidden" name="delivery_duration">
                <input id="received_date" type="hidden" name="received_date">
                <input type="hidden" name="total"
                       value="{{count($carts) > 0 ? $subtotal : null}}">
                <input type="hidden" name="code"
                       value="{{count($carts) > 0 ? strtoupper(uniqid('PYM') . now()->timestamp) : null}}">
                <input type="hidden" name="lang" value="{{app()->getLocale()}}">
                <input type="hidden" name="transaction_id">
                <input type="hidden" name="pdf_url">
            </form>

            <form id="form-note" action="#" method="post">
                @csrf
                {{method_field('PUT')}}
                <div id="modal_note" class="modal fade" tabindex="-1" role="dialog"
                     aria-labelledby="modal_note" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-body">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title text-capitalize"></h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        &times;
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <label for="note" class="mb-1">Catatan
                                        <span class="required">*</span></label>
                                    <textarea class="sm-form-control" id="note" name="note" rows="6" cols="30"
                                              placeholder="Tulis catatan Anda di sini..." required></textarea>
                                </div>
                                <div class="modal-footer p-0">
                                    <button type="submit" class="btn btn-color2 btn-block border-none">
                                        <i class="fa fa-sticky-note mr-2"></i> SIMPAN PERUBAHAN
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <form id="form-address" action="{{route('user.profil-alamat.create')}}" method="post">
                @csrf
                <div id="modal_address" class="modal fade" tabindex="-1" role="dialog"
                     aria-labelledby="modal_address" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-body">
                            <input id="method" type="hidden" name="_method">
                            <input id="lat" type="hidden" name="lat">
                            <input id="long" type="hidden" name="long">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title text-capitalize">Tambah Alamat</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        &times;
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row form-group">
                                        <div class="col-lg-7 col-md-12 col-sm-12">
                                            <label class="form-control-label" for="address_name">
                                                Nama Lengkap <span class="required">*</span>
                                            </label>
                                            <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-id-card"></i></span>
                                                <input placeholder="Nama lengkap" type="text"
                                                       id="address_name" maxlength="191"
                                                       value="{{$user->name}}" class="form-control"
                                                       name="address_name" spellcheck="false"
                                                       autocomplete="off" autofocus required>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-12 col-sm-12">
                                            <label class="form-control-label" for="address_phone">
                                                Telepon <span class="required">*</span>
                                            </label>
                                            <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-phone fa-flip-horizontal"></i></span>
                                                <input placeholder="Nomor telepon"
                                                       id="address_phone" class="form-control"
                                                       name="address_phone" type="text"
                                                       onkeypress="return numberOnly(event, false)"
                                                       value="{{$bio->phone != "" ? $bio->phone : ''}}"
                                                       spellcheck="false" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-7 col-md-12 col-sm-12">
                                            <div id="map" class="gmap img-thumbnail"
                                                 style="height: 400px;"></div>
                                        </div>
                                        <div class="col-lg-5 col-md-12 col-sm-12">
                                            <div class="row form-group">
                                                <div class="col-lg-12">
                                                    <label class="form-control-label" for="kota_id">
                                                        Kabupaten / Kota <span class="required">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-city"></i></span>
                                                        <select id="kota_id" name="kota_id"
                                                                class="form-control use-select2" required>
                                                            <option></option>
                                                            @foreach($provinces as $province)
                                                                <optgroup label="{{$province->nama}}">
                                                                    @foreach($province->getKota as $city)
                                                                        <option value="{{$city->id}}">
                                                                            {{$city->nama}}</option>
                                                                    @endforeach
                                                                </optgroup>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-lg-12">
                                                    <label class="form-control-label" for="address_map">
                                                        Alamat <span class="required">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-map-marked-alt"></i></span>
                                                        <textarea id="address_map" class="form-control"
                                                                  placeholder="Alamat" name="alamat"
                                                                  rows="5" spellcheck="false"
                                                                  autocomplete="off" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-lg-12">
                                                    <label class="form-control-label" for="postal_code">
                                                        Kode Pos <span class="required">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-hashtag"></i></span>
                                                        <input spellcheck="false" autocomplete="off"
                                                               placeholder="Kode pos" id="postal_code"
                                                               type="text" class="form-control"
                                                               name="kode_pos" maxlength="5" required
                                                               onkeypress="return numberOnly(event, false)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-lg-12">
                                                    <label class="form-control-label" for="occupancy_id">
                                                        Simpan Alamat Sebagai <span class="required">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-building"></i></span>
                                                        <select id="occupancy_id" name="occupancy_id"
                                                                class="form-control use-select2" required>
                                                            <option></option>
                                                            @foreach($occupancies as $row)
                                                                <option value="{{$row->id}}">{{$row->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-lg-12 checkbox" style="margin: -10px 0">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="isUtama" name="isUtama" value="1">
                                                        <label class="custom-control-label pl-3"
                                                               for="isUtama">Jadikan alamat utama</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer p-0">
                                    <button type="submit" class="btn btn-color2 btn-block border-none">
                                        <i class="fa fa-map-marked-alt mr-2"></i> SIMPAN PERUBAHAN
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{asset('admins/modules/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Buttons-1.5.6/js/buttons.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/masonry/masonry.pkgd.min.js')}}"></script>
    <script src="{{asset('vendor/lightgallery/lib/picturefill.min.js')}}"></script>
    <script src="{{asset('vendor/lightgallery/dist/js/lightgallery-all.min.js')}}"></script>
    <script src="{{asset('vendor/lightgallery/modules/lg-video.min.js')}}"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIljHbKjgtTrpZhEiHum734tF1tolxI68&libraries=geometry,places"></script>
    <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{env('MIDTRANS_SERVER_KEY')}}"></script>
    <script>
        var collapse = $('.panel-collapse'), upload_input = $("#file"), link_input = $("#link"), check_file = null,
            btn_pay = $("#btn_pay"), production_day = 3, ongkir = 0, etd = '', str_etd = '', str_date = '',
            total = parseInt('{{count($carts) > 0 ? $subtotal : 0}}');

        $(function () {
            $("#dt-produk table").DataTable({
                dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                columnDefs: [{"sortable": false, "targets": 4}],
                language: {
                    "emptyTable": "Anda belum menambahkan cart apapun",
                    "info": "Menampilkan _START_ - _END_ dari _TOTAL_ produk",
                    "infoEmpty": "Menampilkan 0 produk",
                    "infoFiltered": "(difilter dari _MAX_ total produk)",
                    "loadingRecords": "Memuat...",
                    "processing": "Mengolah...",
                    "search": "Cari:",
                    "zeroRecords": "Produk yang Anda cari tidak ditemukan.",
                    "lengthMenu": "Tampilkan _MENU_ produk",
                    "paginate": {
                        "first": '<i class="fa fa-angle-double-left"></i>',
                        "last": '<i class="fa fa-angle-double-right"></i>',
                        "next": '<i class="fa fa-angle-right"></i>',
                        "previous": '<i class="fa fa-angle-left"></i>',
                    },
                    "aria": {
                        "sortAscending": ": aktifkan untuk mengurutkan kolom dari kecil ke besar (asc)",
                        "sortDescending": ": aktifkan untuk mengurutkan kolom dari besar ke kecil (desc)"
                    }
                },
                buttons: [
                    {
                        text: '<i class="fa fa-heart mr-2"></i> <b>Wishlist</b>',
                        className: 'btn btn-color2 btn-sm btn-wishlist'
                    },
                    {
                        text: '<i class="fa fa-trash-alt mr-2"></i> <b>Hapus</b>',
                        className: 'btn btn-color5 btn-sm btn-hapus'
                    }
                ],
                fnDrawCallback: function (oSettings) {
                    $('.use-nicescroll').getNiceScroll().resize();
                    $('[data-toggle="tooltip"]').tooltip();

                    $(".btn-wishlist").on('click', function () {
                        swal({
                            title: "Pindah Semua ke Wishlist",
                            text: 'Apakah Anda yakin akan memindahkan semua produk ke wishlist Anda? Anda tidak dapat mengembalikannya!',
                            icon: 'warning',
                            dangerMode: true,
                            buttons: ["Tidak", "Ya"],
                            closeOnEsc: false,
                            closeOnClickOutside: false,
                        }).then((confirm) => {
                            if (confirm) {
                                swal({icon: "success", buttons: false});
                                window.location.href = '{{route('user.mass-add.wishlist')}}';
                            }
                        });
                    });

                    $(".btn-hapus").on('click', function () {
                        @if(count($carts) > 0)
                        swal({
                            title: 'Hapus Semua Cart',
                            text: 'Apakah Anda yakin akan menghapus semua produk dari cart Anda? Anda tidak dapat mengembalikannya!',
                            icon: 'warning',
                            dangerMode: true,
                            buttons: ["Tidak", "Ya"],
                            closeOnEsc: false,
                            closeOnClickOutside: false,
                        }).then((confirm) => {
                            if (confirm) {
                                swal({icon: "success", buttons: false});
                                window.location.href = '{{route('user.mass-delete.cart')}}';
                            }
                        });
                        @else
                        swal('PERHATIAN!', 'Tidak ada produk di dalam cart Anda!', 'warning');
                        @endif
                    });
                },
            });

            collapse.on('show.bs.collapse', function () {
                $(this).siblings('.panel-heading').addClass('active');
                $(this).siblings('.panel-heading').find('a').addClass('active font-weight-bold');
                $(this).siblings('.panel-heading').find('b').toggle(300);

                $('html,body').animate({scrollTop: $(this).parent().offset().top}, 0);
            });

            collapse.on('hide.bs.collapse', function () {
                $(this).siblings('.panel-heading').removeClass('active');
                $(this).siblings('.panel-heading').find('a').removeClass('active font-weight-bold');
                $(this).siblings('.panel-heading').find('b').toggle(300);

                $('html,body').animate({scrollTop: $(this).parent().parent().offset().top}, 0);
            });

            $(".panel-body hr:last-child").remove();

            $(".addressee .col-lg-12:last-child").removeClass('mb-3');
        });

        function preview(id, nama, cek_uri) {
            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.get(cek_uri, function (data) {
                    var source = [];
                    if (data.galeri != null) {
                        $.each(data.galeri, function (i, val) {
                            source.push({
                                'src': '{{asset('storage/produk/galeri')}}/' + val,
                                'thumb': '{{asset('storage/produk/galeri')}}/' + val,
                                'subHtml': '<h4>' + nama + '</h4>'
                            });
                        });

                    } else {
                        source.push({
                            'src': data.thumb,
                            'thumb': data.thumb,
                            'subHtml': '<h4>' + nama + '</h4>'
                        });
                    }

                    $("#preview" + id).lightGallery({
                        dynamic: true,
                        dynamicEl: source
                    });
                });
            }.bind(this), 800);
        }

        function addWishlist(nama, url) {
            swal({
                title: "Pindah ke Wishlist",
                text: 'Apakah Anda yakin akan memindahkan produk "' + nama + '" ke wishlist Anda? Anda tidak dapat mengembalikannya!',
                icon: 'warning',
                dangerMode: true,
                buttons: ["Tidak", "Ya"],
                closeOnEsc: false,
                closeOnClickOutside: false,
            }).then((confirm) => {
                if (confirm) {
                    swal({icon: "success", buttons: false});
                    window.location.href = url;
                }
            });
        }

        function editCart(name, stock, qty, cek_uri, edit_uri) {
            let input = document.createElement("input");
            input.id = 'qty-cart';
            input.value = qty;
            input.type = 'number';
            input.min = '1';
            input.max = parseInt(stock) + parseInt(qty);
            input.className = 'swal-content__input';

            swal({
                text: 'Sunting Kuantitas: ' + name,
                content: input,
                dangerMode: true,
                buttons: ["Batal", "Simpan Perubahan"],
                closeOnEsc: false,
                closeOnClickOutside: false,
            }).then(val => {
                if (!val) throw null;
                $("#form-cart input[name=_method]").val('PUT');
                $("#form-cart input[name=qty_lama]").val(qty);
                $("#form-cart input[name=qty]").val($("#qty-cart").val());
                $("#form-cart").attr('action', edit_uri).submit();
            });

            if (stock > 0) {
                $("#qty-cart").parent().append("<p class='text-success'>Tersedia: <b>" + stock + "</b> pcs</p>");
            } else {
                $("#qty-cart").parent().append("<p class='text-danger'>Tersedia: <b>" + stock + "</b> pcs</p>");
            }

            $("#qty-cart").on('keyup', function () {
                var el = $(this);
                if (!el.val() || el.val() == "" || parseInt(el.val()) <= 0) {
                    el.val(1);
                }

                $.get(cek_uri, function (data) {
                    el.attr('max', parseInt(data.stock) + parseInt(qty));
                    if (parseInt(el.val()) > parseInt(data.stock) + parseInt(qty)) {
                        el.val(parseInt(data.stock) + parseInt(qty));
                    }
                });
            });
        }

        function deleteCart(name, url) {
            swal({
                title: 'Hapus Cart',
                text: 'Apakah Anda yakin akan menghapus produk "' + name + '" dari cart Anda? Anda tidak dapat mengembalikannya!',
                icon: 'warning',
                dangerMode: true,
                buttons: ["Tidak", "Ya"],
                closeOnEsc: false,
                closeOnClickOutside: false,
            }).then((confirm) => {
                if (confirm) {
                    swal({icon: "success", buttons: false});
                    window.location.href = url;
                }
            });
        }

        function manageNote(url) {
            $.get(url, function (data) {
                var note = data.note, name = data.name, url_update = data.url_update, url_delete = data.url_delete;
                if (note != null) {
                    swal({
                        title: 'CATATAN',
                        text: 'Apakah Anda ingin menyunting catatan untuk pesanan produk cetak [' + name + '] ini atau menghapusnya?',
                        icon: 'warning',
                        dangerMode: true,
                        buttons: {
                            cancel: 'Batal',
                            edit: {
                                text: 'Sunting',
                                value: 'edit',
                            },
                            delete: {
                                text: 'Hapus',
                                value: 'delete',
                            }
                        },
                        closeOnEsc: false,
                        closeOnClickOutside: false,
                    }).then((value) => {
                        if (value == 'edit') {
                            $("#form-note .modal-title").html("Sunting Catatan: " +
                                "<b style='text-transform: none'>" + name + "</b>");
                            $("#form-note").attr('action', url_update);
                            $("#note").val(note);
                            $("#modal_note").modal('show');

                        } else if (value == 'delete') {
                            swal({
                                title: "Apakah Anda yakin?",
                                text: "Anda tidak dapat mengembalikannya!",
                                icon: 'warning',
                                dangerMode: true,
                                buttons: ["Tidak", "Ya"],
                                closeOnEsc: false,
                                closeOnClickOutside: false,
                            }).then((confirm) => {
                                if (confirm) {
                                    swal({icon: "success", buttons: false});
                                    window.location.href = url_delete;
                                }
                            });
                        } else {
                            swal.close();
                        }
                    });

                } else {
                    $("#form-note .modal-title").html("Tambah Catatan: " +
                        "<b style='text-transform: none'>" + name + "</b>");
                    $("#form-note").attr('action', url_update);
                    $("#note").val(null);
                    $("#modal_note").modal('show');
                }
            });
        }

        function getShipping(area, latLng, check, name) {
            $(".show-" + check).text(name);
            $('#collapse-' + check).collapse('hide');

            $('html,body').animate({scrollTop: $("#accordion2").parent().parent().offset().top}, 0);
        }

        $("#promo_code").on('keyup', function (e) {
            if (!$(this).val()) {
                $("#btn_set").attr('disabled', 'disabled');
            } else {
                $("#btn_set").removeAttr('disabled');
                if (e.keyCode === 13) {
                    $("#btn_set").click();
                }
            }

            $("#promo_code").css('border-color', '#ced4da');
            $("#error_promo").hide().find('b').text(null);
        });

        $("#btn_set").on('click', function () {
            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: "{!! route('get.cari-promo.cart',['subtotal' => $subtotal])!!}&ongkir=" + ongkir + "&kode=" + $("#promo_code").val(),
                    type: "GET",
                    beforeSend: function () {
                        $('#preload-summary').show();
                        $(".list-group-flush").css('opacity', '.3');
                    },
                    complete: function () {
                        $('#preload-summary').hide();
                        $(".list-group-flush").css('opacity', '1');
                    },
                    success: function (data) {
                        if (data == 0) {
                            swal('Kode Promo', 'Kode promo yang Anda masukkan tidak ditemukan.', 'error');
                            $("#promo_code").css('border-color', '#dc3545');
                            $("#error_promo").show().find('b').text("Kode promo yang Anda masukkan tidak ditemukan.").css('color', '#dc3545');
                            $("#btn_set").attr('disabled', 'disabled');
                            resetter();

                        } else if (data == 1) {
                            swal('Kode Promo', 'Anda telah menggunakan kode promo itu!', 'error');
                            $("#promo_code").css('border-color', '#dc3545');
                            $("#error_promo").show().find('b').text("Anda telah menggunakan kode promo itu!").css('color', '#dc3545');
                            $("#btn_set").attr('disabled', 'disabled');
                            resetter();

                        } else if (data == 2) {
                            swal('Kode Promo', 'Kode promo yang Anda masukkan telah kedaluwarsa.', 'error');
                            $("#promo_code").css('border-color', '#dc3545');
                            $("#error_promo").show().find('b').text("Kode promo yang Anda masukkan telah kedaluwarsa.").css('color', '#dc3545');
                            $("#btn_set").attr('disabled', 'disabled');
                            resetter();

                        } else {
                            $("#promo_code").css('border-color', '#ced4da');
                            $("#error_promo").show().find('b').text(data.caption).css('color', '#f89406');
                            $("#btn_set").removeAttr('disabled');

                            $("#discount").show().find('strong').text(data.discount + '%');
                            $("#discount b").text(data.str_discount);
                            $(".show-total").text(data.str_total);
                            $("#form-pembayaran input[name=discount]").val(data.discount);
                            $("#form-pembayaran input[name=discount_price]").val(data.discount_price);
                            $("#form-pembayaran input[name=total]").val(data.total);
                        }
                    },
                    error: function () {
                        swal('Oops..', 'Terjadi kesalahan! Silahkan, segarkan browser Anda.', 'error');
                    }
                });
            }.bind(this), 800);
        });

        $("#discount i").on("click", function () {
            swal({
                title: "Apakah Anda yakin?",
                text: "Anda tidak dapat mengembalikannya!",
                icon: 'warning',
                dangerMode: true,
                buttons: ["Tidak", "Ya"],
                closeOnEsc: false,
                closeOnClickOutside: false,
            }).then((confirm) => {
                if (confirm) {
                    swal({icon: "success", buttons: false});
                    resetter();
                }
            });
        });

        function resetter() {
            $("#discount").hide().find('b').text(null);
            $(".show-total").text('Rp' + number_format(total, 2, ',', '.'));
            $("#form-pembayaran input[name=discount], #form-pembayaran input[name=discount_price]").val(null);
            $("#form-pembayaran input[name=total]").val(total);
        }

        btn_pay.on("click", function () {
            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: '{{route('get.midtrans.snap')}}',
                    type: "GET",
                    data: $("#form-pembayaran").serialize(),
                    beforeSend: function () {
                        btn_pay.prop("disabled", true).html(
                            'LOADING&hellip; <span class="spinner-border spinner-border-sm fright" role="status" aria-hidden="true"></span>'
                        );
                    },
                    complete: function () {
                        btn_pay.prop("disabled", false).html('CHECKOUT <i class="icon-chevron-right fright"></i>');
                    },
                    success: function (data) {
                        snap.pay(data, {
                            language: '{{app()->getLocale()}}',
                            onSuccess: function (result) {
                                responseMidtrans('{{route('get.midtrans-callback.finish')}}', result);
                            },
                            onPending: function (result) {
                                responseMidtrans('{{route('get.midtrans-callback.unfinish')}}', result);
                            },
                            onError: function (result) {
                                swal('Oops..', result.status_message, 'error');
                            }
                        });
                    },
                    error: function () {
                        swal('Oops..', 'Terjadi kesalahan! Silahkan, segarkan browser Anda.', 'error');
                    }
                });
            }.bind(this), 800);
        });

        function responseMidtrans(url, result) {
            if (result.payment_type == 'credit_card' || result.payment_type == 'bank_transfer' ||
                result.payment_type == 'echannel' || result.payment_type == 'gopay' || result.payment_type == 'cstore') {

                $("#form-pembayaran input[name=transaction_id]").val(result.transaction_id);
                $("#form-pembayaran input[name=pdf_url]").val(result.pdf_url);

                clearTimeout(this.delay);
                this.delay = setTimeout(function () {
                    $.ajax({
                        url: url,
                        type: "GET",
                        data: $("#form-pembayaran").serialize(),
                        beforeSend: function () {
                            const preloader = document.createElement('div');
                            preloader.innerHTML =
                                '<div class="ajax-loader" style="display: none"><div class="preloader4"></div></div>';

                            swal({
                                title: 'Loading...',
                                text: 'Mohon tunggu, transaksi Anda sedang diproses',
                                content: preloader,
                                icon: 'warning',
                                buttons: false,
                                closeOnEsc: false,
                                closeOnClickOutside: false,
                            });
                        },
                        complete: function () {
                            swal.close();
                        },
                        success: function (data) {
                            swal({
                                title: "SUKSES!",
                                text: data,
                                icon: 'success',
                                buttons: false,
                                closeOnEsc: false,
                                closeOnClickOutside: false,
                            });
                            setTimeout(function () {
                                location.href = '{{route('user.dashboard')}}'
                            }, 7000);
                        },
                        error: function () {
                            swal('Oops..', 'Terjadi kesalahan! Silahkan, segarkan browser Anda.', 'error');
                        }
                    });
                }.bind(this), 800);

            } else {
                swal('Oops..', 'Maaf kanal pembayaran yang Anda pilih masih maintenance, silahkan pilih kanal lainnya.', 'error');
            }
        }

        function goToAnchor() {
            $('html,body').animate({scrollTop: $(".crumb").offset().top}, 500);
        }
    </script>
    @include('layouts.partials.users._scriptsAddress')
@endpush
