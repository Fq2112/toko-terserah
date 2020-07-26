@extends('layouts.mst')
@section('title', 'Checkout Cart ('.$total_item.' produk): '.$user->name.' | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('css/card.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/lightgallery/dist/css/lightgallery.min.css')}}">
    <style>
        blockquote {
            background: unset;
            border-color: unset;
            color: #555;
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

        .content-area {
            position: relative;
            cursor: pointer;
            overflow: hidden;
        }

        .custom-overlay {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            background: rgba(0, 0, 0, .3);
            opacity: 0;
            transition: all 400ms ease-in-out;
            height: 100%;
        }

        .custom-overlay:hover {
            opacity: 1;
        }

        .custom-text {
            position: absolute;
            top: 50%;
            left: 10px;
            right: 10px;
            transform: translateY(-50%);
            color: #fff !important;
        }

        .content-area img {
            transition: transform .5s ease;
        }

        .content-area:hover img {
            transform: scale(1.2);
        }

        .media-body h5 a:hover, .media-body h5 a:focus, .media-body h5 a:active
        .togglec a:hover, .togglec a:focus, .togglec a:active {
            color: #5bb300 !important;
        }

        .toggle {
            display: block;
            position: relative;
            margin: 0 0 20px 0;
        }

        .toggle .togglet,
        .toggle .toggleta {
            display: block;
            position: relative;
            line-height: 24px;
            padding: 0 1em;
            margin: 0;
            font-size: 14px;
            font-weight: 700;
            color: #444;
            cursor: pointer;
        }

        .toggle .togglet i {
            position: absolute;
            top: 0;
            right: 1em;
            width: 16px;
            text-align: center;
            font-size: 14px;
            line-height: 24px;
        }

        .toggle .toggleta {
            font-weight: bold;
        }

        .toggle .togglet i.toggle-open,
        .toggle .toggleta i.toggle-closed {
            display: none;
        }

        .toggle .toggleta i.toggle-open {
            display: block;
        }

        .toggle .togglet:not(.toggleta) span.toggle-open,
        .toggle .togglet.toggleta span.toggle-closed {
            display: none;
        }

        .toggle .togglet.toggleta span.toggle-open,
        .toggle .togglet:not(.toggleta) span.toggle-closed {
            display: block;
        }

        .toggle .togglec {
            display: block;
            position: relative;
            padding: 0 1em .5em
        }

        .toggle .togglec .list-group-flush {
            margin: 0 !important;
        }

        .toggle .togglec .list-group-item {
            padding: 0.75rem 0 !important;
        }

        .toggle.toggle-border {
            border: 1px solid #E5E5E5;
            border-radius: 4px;
        }

        .toggle.toggle-border .togglet,
        .toggle.toggle-border .toggleta {
            line-height: 44px;
        }

        .toggle.toggle-border .togglet i {
            line-height: 44px;
        }

        .toggle .togglec ul:not(.list-group-flush) {
            margin-left: 2rem;
        }

        .togglec h1, .togglec h2, .togglec h3, .togglec h4, .togglec h5, .togglec h6 {
            font-size: 20px;
            margin: .5em 0 .25em;
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

        .card-input .card-title {
            font-weight: 600 !important;
            font-size: 15px;
            text-transform: none !important;
        }

        .card-footer .btn:hover:before, .card-footer .btn:focus:before, .card-footer .btn:active:before {
            border-radius: 0 0 4px 4px;
        }

        .ajax-loader {
            width: unset;
            height: unset;
            background-color: unset;
            z-index: 1;
            position: absolute;
            left: 0;
            right: 0;
        }

        #preload-shipping {
            top: 20em;
        }

        #preload-summary {
            top: 17em;
        }

        #snap-midtrans {
            z-index: 9999999 !important;
        }
    </style>
@endpush
@section('content')
    <div class="breadcrumbs" style="background-image: url('{{$bio->background != null ?
    asset('storage/users/background/'.$bio->background) : asset('images/page-header/users.jpg')}}')">
        <div class="breadcrumbs-overlay"></div>
        <div class="page-title">
            <h2>Checkout Cart</h2>
            <p>Di sini Anda dapat mengelola pesanan Anda dan menyelesaikan pembayarannya.</p>
        </div>
        <ul class="crumb">
            <li><a href="{{route('beranda')}}"><i class="fa fa-home"></i></a></li>
            <li style="text-transform: none"><i class="fa fa-angle-double-right"></i>
                <a href="{{route('user.profil')}}">Akun</a></li>
            <li><a href="{{URL::current()}}"><i class="fa fa-angle-double-right"></i> Cart</a></li>
            <li><a href="#" onclick="goToAnchor()"><i class="fa fa-angle-double-right"></i> Checkout</a></li>
        </ul>
    </div>

    <section class="none-margin" style="padding: 40px 0">
        <div class="container px-0">
            <form id="form-pembayaran" class="row" method="POST" onkeydown="return event.key != 'Enter';">
                @csrf
                <input type="hidden" name="user_id" value="{{$user->id}}">
                <input type="hidden" name="lang" value="{{app()->getLocale()}}">

                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="card mb-4">
                        <div class="card-content">
                            <div class="card-title">
                                <h4 class="text-center" style="color: #5bb300">Daftar Pesanan</h4>
                                <h5 class="text-center mb-2" style="text-transform: none">
                                    Kelola pesanan Anda terlebih dahulu sebelum menyelesaikan pembayarannya</h5>
                                <hr class="mt-0">
                                <div class="component-accordion">
                                    <div class="panel-group" id="accordion" role="tablist">
                                        @php $a=1; $b=1; $c=1; $d=1; $e=1; @endphp
                                        @foreach($carts as $monthYear => $archive)
                                            @php $a++; $b++; $c++; $d++; $e++; @endphp
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="heading-{{$a}}">
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse"
                                                           href="#collapse-{{$b}}" aria-expanded="false"
                                                           aria-controls="collapse-{{$c}}" class="collapsed">
                                                            {{$monthYear}}
                                                            <b>Rp{{number_format($archive->sum('total'), 2,',','.') . ' ('.$archive->sum('qty').' produk)'}}</b>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse-{{$d}}" class="panel-collapse collapse"
                                                     role="tabpanel" aria-labelledby="heading-{{$e}}"
                                                     aria-expanded="false" style="height: 0;" data-parent="#accordion">
                                                    <div class="panel-body">
                                                        @foreach($archive as $i => $row)
                                                            @php
                                                                $produk = $row->getProduk;
                                                                $subtotal += $row->total;
                                                                $weight = ($produk->berat / 1000) * $row->qty;
                                                                $total_weight += $weight;
                                                            @endphp
                                                            <div class="media">
                                                                <div class="content-area media-left media-middle"
                                                                     style="width: 20%" id="preview{{$row->id}}"
                                                                     onclick="preview('{{$row->id}}','{{$produk->nama}}',
                                                                         '{{route('get.galeri.produk', ['produk' => $produk->permalink])}}')">
                                                                    <img class="media-object" alt="icon"
                                                                         src="{{asset('storage/produk/thumb/'.$produk->gambar)}}">
                                                                    <div class="custom-overlay">
                                                                        <div class="custom-text">
                                                                            <i class="fa fa-clone fa-2x"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="ml-2 media-body">
                                                                    <h5 class="mt-3 mb-1">
                                                                        <a href="{{route('produk', ['produk' => $produk->permalink])}}">
                                                                            <i class="fa fa-box-open mr-1"></i>
                                                                            {{$produk->nama}}
                                                                        </a>
                                                                    </h5>
                                                                    <blockquote class="mb-3 pr-0"
                                                                                style="font-size: 14px;text-transform: none">
                                                                        <div class="toggle toggle-border mb-3"
                                                                             data-state="close">
                                                                            <div
                                                                                class="togglet toggleta font-weight-normal text-uppercase">
                                                                                <i class="toggle-closed fa fa-chevron-down"></i>
                                                                                <i class="toggle-open fa fa-chevron-up"></i>
                                                                                Kalkulasi
                                                                            </div>
                                                                            <div class="togglec">
                                                                                <ul class="list-group list-group-flush">
                                                                                    <li class="list-group-item border-none">
                                                                                        Qty.
                                                                                        <b class="float-right">{{$row->qty}}
                                                                                            pcs</b>
                                                                                    </li>
                                                                                    <li class="list-group-item border-none">
                                                                                        Harga /pcs
                                                                                        <b class="float-right">Rp{{number_format($produk->is_diskon == true ? $produk->harga_diskon : $produk->harga,2,',','.')}}</b>
                                                                                    </li>
                                                                                    <li class="list-group-item border-none">
                                                                                        Berat
                                                                                        <b class="float-right">
                                                                                            {{number_format($weight,2,',','.')}}
                                                                                            kg</b>
                                                                                    </li>
                                                                                </ul>
                                                                                <hr class="my-2">
                                                                                <ul class="list-group list-group-flush">
                                                                                    <li class="list-group-item border-none">
                                                                                        TOTAL
                                                                                        <b class="float-right"
                                                                                           style="font-size: large">Rp{{number_format($row->total,2,',','.')}}</b>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <div class="toggle toggle-border mb-3"
                                                                             data-state="close">
                                                                            <div
                                                                                class="togglet toggleta font-weight-normal text-uppercase">
                                                                                <i class="toggle-closed fa fa-chevron-down"></i>
                                                                                <i class="toggle-open fa fa-chevron-up"></i>
                                                                                Detail Produk
                                                                            </div>
                                                                            <div class="togglec">
                                                                                <table
                                                                                    style="margin: 0;font-size: 14px;font-weight: 600">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td>Kategori</td>
                                                                                        <td>:&nbsp;</td>
                                                                                        <td>
                                                                                            {{$produk->getSubkategori->getKategori->nama}}
                                                                                            ,
                                                                                            <a href="{{route('cari', ['kat' => $produk->getSubkategori->id])}}">
                                                                                                {{$produk->getSubkategori->nama}}</a>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Deskripsi</td>
                                                                                        <td>:&nbsp;</td>
                                                                                        <td>{{$produk->deskripsi}}</td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                {!! $produk->detail !!}
                                                                            </div>
                                                                        </div>
                                                                    </blockquote>
                                                                </div>
                                                            </div>
                                                            <hr class="mt-3">
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="heading-note">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse"
                                                       href="#collapse-note" aria-expanded="false"
                                                       aria-controls="collapse-note" class="collapsed">
                                                        Catatan
                                                        <b class="show-note">&ndash;</b>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapse-note" class="panel-collapse collapse"
                                                 role="tabpanel" aria-labelledby="heading-note"
                                                 aria-expanded="false" style="height: 0;" data-parent="#accordion">
                                                <div class="panel-body">
                                                    <textarea class="form-control mb-4" id="note" name="note" rows="6"
                                                              placeholder="Tulis catatan Anda di sini..." required
                                                              style="resize: vertical;border: 0;box-shadow: none;"></textarea>
                                                    <button id="btn_note" class="btn btn-color2 btn-block"
                                                            type="button" disabled>
                                                        <i class="fa fa-sticky-note mr-2"></i> SIMPAN PERUBAHAN
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                    <div class="panel-group mb-0" id="accordion2" role="tablist">
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
                                                <div class="panel-body pb-0">
                                                    <div
                                                        class="row {{count($addresses) > 0 ? '' : 'text-center'}} addressee">
                                                        @if(count($addresses) > 0)
                                                            @foreach($addresses as $row)
                                                                @php $occupancy = $row->isUtama == false ? $row->getOccupancy->name : $row->getOccupancy->name.' [Alamat Utama]'; @endphp
                                                                <div class="col-lg-12">
                                                                    <label class="card-label"
                                                                           for="shipping_{{$row->id}}">
                                                                        <input id="shipping_{{$row->id}}"
                                                                               class="card-rb" type="radio"
                                                                               name="pengiriman_id"
                                                                               value="{{$row->id}}"
                                                                               data-name="{{$occupancy}}">
                                                                        <div class="card card-input"
                                                                             onclick="getShipping('{{$row->kecamatan_id}}','{{$row->lat.','.$row->long}}','shipping','{{$occupancy}}')">
                                                                            <div class="row">
                                                                                <div class="col-lg-12">
                                                                                    <div class="media p-4">
                                                                                        <div
                                                                                            class="media-left media-middle"
                                                                                            style="width: 20%">
                                                                                            <img class="media-object"
                                                                                                 alt="icon"
                                                                                                 src="{{asset('images/icons/occupancy/'.$row->getOccupancy->image)}}">
                                                                                        </div>
                                                                                        <div class="ml-2 media-body">
                                                                                            <h5 class="mt-0 mb-1">
                                                                                                <i class="fa fa-building mr-2"></i>{{$row->getOccupancy->name}}
                                                                                                {!! $row->isUtama == false ? '' :
                                                                                                '<span style="font-weight: 500;color: unset">[Alamat Utama]</span>'!!}
                                                                                            </h5>
                                                                                            <blockquote class="mb-0"
                                                                                                        style="font-size: 14px;text-transform: none">
                                                                                                <table class="m-0"
                                                                                                       style="font-size: 14px">
                                                                                                    <tr data-toggle="tooltip"
                                                                                                        data-placement="left"
                                                                                                        title="Nama Lengkap">
                                                                                                        <td>
                                                                                                            <i class="fa fa-id-card"></i>
                                                                                                        </td>
                                                                                                        <td>&nbsp;</td>
                                                                                                        <td>{{$row->nama}}</td>
                                                                                                    </tr>
                                                                                                    <tr data-toggle="tooltip"
                                                                                                        data-placement="left"
                                                                                                        title="Telepon">
                                                                                                        <td>
                                                                                                            <i class="fa fa-phone fa-flip-horizontal"></i>
                                                                                                        </td>
                                                                                                        <td>&nbsp;</td>
                                                                                                        <td>{{$row->telp}}</td>
                                                                                                    </tr>
                                                                                                    <tr data-toggle="tooltip"
                                                                                                        data-placement="left"
                                                                                                        title="Kabupaten / Kota">
                                                                                                        <td>
                                                                                                            <i class="fa fa-city"></i>
                                                                                                        </td>
                                                                                                        <td>&nbsp;</td>
                                                                                                        <td>{{$row->getKecamatan->getKota->getProvinsi->nama.', '.$row->getKecamatan->getKota->nama}}</td>
                                                                                                    </tr>
                                                                                                    <tr data-toggle="tooltip"
                                                                                                        data-placement="left"
                                                                                                        title="Kecamatan">
                                                                                                        <td>
                                                                                                            <i class="fa fa-map-signs"></i>
                                                                                                        </td>
                                                                                                        <td>&nbsp;</td>
                                                                                                        <td>{{$row->getKecamatan->nama}}</td>
                                                                                                    </tr>
                                                                                                    <tr data-toggle="tooltip"
                                                                                                        data-placement="left"
                                                                                                        title="Alamat">
                                                                                                        <td>
                                                                                                            <i class="fa fa-map-marker-alt"></i>
                                                                                                        </td>
                                                                                                        <td>&nbsp;</td>
                                                                                                        <td>{{$row->alamat.' - '. $row->kode_pos}}</td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </blockquote>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
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
                                            <div class="panel-heading" role="tab" id="heading-rate">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse"
                                                       href="#collapse-rate" aria-expanded="false"
                                                       aria-controls="collapse-rate" class="collapsed">
                                                        Opsi Pengiriman
                                                        <b class="show-rate">&ndash;</b>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapse-rate" class="panel-collapse collapse"
                                                 role="tabpanel" aria-labelledby="heading-rate"
                                                 aria-expanded="false" style="height:0;"
                                                 data-parent="#accordion2">
                                                <div class="panel-body">
                                                    <div class="row form-group">
                                                        <div class="col-lg-12">
                                                            <label class="form-control-label" for="kode_kurir">
                                                                Logistik <span class="required">*</span>
                                                            </label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-shipping-fast"></i></span>
                                                                <select id="kode_kurir" name="kode_kurir"
                                                                        class="form-control" required>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <label class="form-control-label" for="layanan_kurir">
                                                                Jenis Layanan <span class="required">*</span>
                                                            </label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-bolt"></i></span>
                                                                <select id="layanan_kurir" name="layanan_kurir"
                                                                        class="form-control" disabled required>
                                                                </select>
                                                            </div>
                                                        </div>
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
                                                <div class="panel-body pb-0">
                                                    <div
                                                        class="row {{count($addresses) > 0 ? '' : 'text-center'}} addressee">
                                                        @if(count($addresses) > 0)
                                                            @foreach($addresses as $row)
                                                                @php $occupancy = $row->isUtama == false ? $row->getOccupancy->name : $row->getOccupancy->name.' [Alamat Utama]'; @endphp
                                                                <div class="col-lg-12">
                                                                    <label class="card-label"
                                                                           for="billing_{{$row->id}}">
                                                                        <input id="billing_{{$row->id}}"
                                                                               class="card-rb" type="radio"
                                                                               name="penagihan_id"
                                                                               value="{{$row->id}}"
                                                                               data-name="{{$occupancy}}">
                                                                        <div class="card card-input"
                                                                             onclick="getShipping('{{$row->kecamatan_id}}','{{$row->lat.','.$row->long}}','billing','{{$occupancy}}')">
                                                                            <div class="row">
                                                                                <div class="col-lg-12">
                                                                                    <div class="media p-4">
                                                                                        <div
                                                                                            class="media-left media-middle"
                                                                                            style="width: 20%">
                                                                                            <img class="media-object"
                                                                                                 alt="icon"
                                                                                                 src="{{asset('images/icons/occupancy/'.$row->getOccupancy->image)}}">
                                                                                        </div>
                                                                                        <div class="ml-2 media-body">
                                                                                            <h5 class="mt-0 mb-1">
                                                                                                <i class="fa fa-building mr-2"></i>{{$row->getOccupancy->name}}
                                                                                                {!! $row->isUtama == false ? '' :
                                                                                                '<span style="font-weight: 500;color: unset">[Alamat Utama]</span>'!!}
                                                                                            </h5>
                                                                                            <blockquote class="mb-0"
                                                                                                        style="font-size: 14px;text-transform: none">
                                                                                                <table class="m-0"
                                                                                                       style="font-size: 14px">
                                                                                                    <tr data-toggle="tooltip"
                                                                                                        data-placement="left"
                                                                                                        title="Nama Lengkap">
                                                                                                        <td>
                                                                                                            <i class="fa fa-id-card"></i>
                                                                                                        </td>
                                                                                                        <td>&nbsp;</td>
                                                                                                        <td>{{$row->nama}}</td>
                                                                                                    </tr>
                                                                                                    <tr data-toggle="tooltip"
                                                                                                        data-placement="left"
                                                                                                        title="Telepon">
                                                                                                        <td>
                                                                                                            <i class="fa fa-phone fa-flip-horizontal"></i>
                                                                                                        </td>
                                                                                                        <td>&nbsp;</td>
                                                                                                        <td>{{$row->telp}}</td>
                                                                                                    </tr>
                                                                                                    <tr data-toggle="tooltip"
                                                                                                        data-placement="left"
                                                                                                        title="Kabupaten / Kota">
                                                                                                        <td>
                                                                                                            <i class="fa fa-city"></i>
                                                                                                        </td>
                                                                                                        <td>&nbsp;</td>
                                                                                                        <td>{{$row->getKecamatan->getKota->getProvinsi->nama.', '.$row->getKecamatan->getKota->nama}}</td>
                                                                                                    </tr>
                                                                                                    <tr data-toggle="tooltip"
                                                                                                        data-placement="left"
                                                                                                        title="Kecamatan">
                                                                                                        <td>
                                                                                                            <i class="fa fa-map-signs"></i>
                                                                                                        </td>
                                                                                                        <td>&nbsp;</td>
                                                                                                        <td>{{$row->getKecamatan->nama}}</td>
                                                                                                    </tr>
                                                                                                    <tr data-toggle="tooltip"
                                                                                                        data-placement="left"
                                                                                                        title="Alamat">
                                                                                                        <td>
                                                                                                            <i class="fa fa-map-marker-alt"></i>
                                                                                                        </td>
                                                                                                        <td>&nbsp;</td>
                                                                                                        <td>{{$row->alamat.' - '. $row->kode_pos}}</td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </blockquote>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
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
                                                <a href="{{route('user.profil')}}" class="btn btn-block btn-color2">
                                                    <i class="fa fa-map-marked-alt mr-2"></i> Tambah Alamat</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                                        disabled style="font-size: 14px">SET</button>
                                            </span>
                                        </div>
                                        <span id="error_promo" class="help-block">
                                            <b style="text-transform: none"></b>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="preload-summary" class="ajax-loader" style="display: none">
                            <div class="preloader4"></div>
                        </div>
                        <ul class="list-group list-group-flush mb-0">
                            <li class="list-group-item border-none">
                                Subtotal ({{$total_item}} produk)
                                <b class="float-right">Rp{{number_format($subtotal,2,',','.')}}</b>
                            </li>
                            <li class="list-group-item border-none">
                                Berat
                                <b class="float-right">{{number_format($total_weight,2,',','.')}} kg</b>
                            </li>
                            <li class="list-group-item border-none">
                                Ongkir
                                <b class="float-right show-ongkir">&ndash;</b>
                            </li>
                            <li class="list-group-item border-none">
                                Durasi Pengiriman
                                <b class="float-right show-delivery text-lowercase">&ndash;</b>
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
                                    Rp{{number_format($subtotal,2,',','.')}}</b>
                            </li>
                        </ul>
                        <div id="summary-alert" class="card-content py-2">
                            <div class="alert alert-warning text-justify">
                                <i class="fa fa-exclamation-sign"></i><b>PERHATIAN!</b>
                                <span
                                    id="shipping-alert">Silahkan pilih alamat pengiriman pesanan Anda terlebih dahulu.</span>
                                <span id="rate-alert" style="display: none">Selanjutnya, pilih opsi pengiriman sesuai kebutuhan Anda.</span>
                                <span id="billing-alert" style="display: none">Terakhir, pilih alamat penagihan pesanan Anda.</span>
                            </div>
                        </div>
                        <div class="card-footer mt-2 p-0">
                            <button id="btn_pay" type="button" style="text-align: left" disabled
                                    class="btn btn-color2 btn-block text-uppercase border-none">
                                CHECKOUT <i class="fa fa-chevron-right float-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="cart_ids" value="{{$cart_ids}}">
                <input type="hidden" name="subtotal" value="{{$subtotal}}">
                <input id="total_weight" type="hidden" name="weight" value="{{ceil($total_weight * 1000)}}">
                <input type="hidden" name="discount">
                <input type="hidden" name="discount_price">
                <input id="ongkir" type="hidden" name="ongkir">
                <input id="durasi_pengiriman" type="hidden" name="durasi_pengiriman">
                <input type="hidden" name="nama_kurir">
                <input type="hidden" name="layanan_kurir">
                <input type="hidden" name="total" value="{{$subtotal}}">
                <input type="hidden" name="code" value="{{$code}}">
                <input type="hidden" name="lang" value="{{app()->getLocale()}}">
                <input type="hidden" name="transaction_id">
                <input type="hidden" name="pdf_url">
            </form>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{asset('vendor/lightgallery/lib/picturefill.min.js')}}"></script>
    <script src="{{asset('vendor/lightgallery/dist/js/lightgallery-all.min.js')}}"></script>
    <script src="{{asset('vendor/lightgallery/modules/lg-video.min.js')}}"></script>
    <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{env('MIDTRANS_SERVER_KEY')}}"></script>

    <script>
        var collapse = $('.panel-collapse'), upload_input = $("#file"), link_input = $("#link"), check_file = null,
            btn_pay = $("#btn_pay"), kode_kurir = $("#kode_kurir"), layanan_kurir = $("#layanan_kurir"),
            harga_diskon = 0, ongkir = 0, etd = '', str_etd = '', unit = '', total = parseInt('{{$subtotal}}');

        $(function () {
            collapse.on('show.bs.collapse', function () {
                $(this).siblings('.panel-heading').addClass('active');
                $(this).siblings('.panel-heading').find('a').addClass('active font-weight-bold');
                $(this).siblings('.panel-heading').find('b').toggle(300);

                $('html,body').animate({scrollTop: $(this).parent().parent().offset().top}, 0);
            });

            collapse.on('hide.bs.collapse', function () {
                $(this).siblings('.panel-heading').removeClass('active');
                $(this).siblings('.panel-heading').find('a').removeClass('active font-weight-bold');
                $(this).siblings('.panel-heading').find('b').toggle(300);

                goToAnchor();
            });

            $(".panel-body hr:last-child").remove();

            $('.toggle').each(function () {
                var element = $(this), elementState = element.attr('data-state');

                if (elementState != 'open') {
                    element.children('.togglec').hide();
                } else {
                    element.children('.togglet').addClass("toggleta");
                }

                element.children('.togglet').off('click').on('click', function () {
                    $(this).toggleClass('toggleta').next('.togglec').slideToggle(300);
                    return true;
                });
            });
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

        $("#note").on('keyup', function () {
            if (!$(this).val() || $.trim($(this).val()) == "") {
                $("#btn_note").attr('disabled', 'disabled');
            } else {
                $("#btn_note").removeAttr('disabled');
            }
        });

        $("#btn_note").on('click', function () {
            $('#collapse-note').collapse('hide');
            $(".show-note").text($("#note").val().length > 20 ? $("#note").val().slice(0, 20) + "..." : $("#note").val());
        });

        function getShipping(kecamatan_id, latLng, check, name) {
            $(".show-" + check).text(name);
            $('#collapse-' + check).collapse('hide');

            if (check == 'shipping') {
                clearTimeout(this.delay);
                this.delay = setTimeout(function () {
                    $.ajax({
                        url: "{{route('get.rajaongkir.cost')}}?destination=" + kecamatan_id + '&weight=' + $("#total_weight").val(),
                        data: {destination: kecamatan_id, weight: $("#total_weight").val()},
                        type: "POST",
                        beforeSend: function () {
                            $('#preload-shipping, #preload-summary').show();
                            $("#accordion2, .list-group-flush, #summary-alert").css('opacity', '.3');
                        },
                        complete: function () {
                            $('#preload-shipping, #preload-summary').hide();
                            $("#accordion2, .list-group-flush, #summary-alert").css('opacity', '1');
                        },
                        success: function (data) {
                            kode_kurir.empty();
                            layanan_kurir.attr('disabled', 'disabled').empty();
                            $(".show-rate, .show-ongkir, .show-delivery").html('&ndash;');
                            $(".show-total").text("Rp" + number_format(total, 2, ',', '.'));

                            var logistic = data['rajaongkir']['results'];
                            if (logistic.length > 0) {
                                $("#shipping-alert, #billing-alert").hide();
                                $("#rate-alert").show();
                                $("#heading-rate").parent().show();

                                kode_kurir.empty().append('<option></option>');
                                $.each(logistic, function (i, val) {
                                    kode_kurir.append('<option value="' + val.code + '" data-index="' + i + '" ' +
                                        'data-kode="' + val.code + '">' + val.name + '</option>');
                                });

                                kode_kurir.select2({
                                    placeholder: "-- Pilih --",
                                    allowClear: true,
                                    width: '100%',
                                    templateResult: format,
                                    templateSelection: format,
                                    escapeMarkup: function (m) {
                                        return m;
                                    }
                                });

                                kode_kurir.on('change', function () {
                                    $(".show-ongkir, .show-delivery").html('&ndash;');
                                    $(".show-total").text("Rp" + number_format(total, 2, ',', '.'));

                                    $('#preload-summary').show();
                                    $(".list-group-flush, #summary-alert").css('opacity', '.3');

                                    clearTimeout(this.delay);
                                    this.delay = setTimeout(function () {
                                        $('#preload-summary').hide();
                                        $(".list-group-flush, #summary-alert").css('opacity', '1');

                                        if ($(this).val() != "") {
                                            layanan_kurir.removeAttr('disabled').empty().append('<option></option>');
                                            $.each(logistic[$("option[value=" + $(this).val() + "]", this).attr('data-index')]['costs'], function (i, val) {
                                                layanan_kurir.append('<option value="' + val.service + '" ' +
                                                    'data-kode="' + kode_kurir.val() + '" ' +
                                                    'data-etd="' + val.cost[0].etd + '" ' +
                                                    'data-ongkir="' + val.cost[0].value + '">' + val.service + '</option>');
                                            });

                                            layanan_kurir.select2({
                                                placeholder: "-- Pilih --",
                                                allowClear: true,
                                                width: '100%',
                                                templateResult: format,
                                                templateSelection: format,
                                                escapeMarkup: function (m) {
                                                    return m;
                                                }
                                            });

                                        } else {
                                            layanan_kurir.attr('disabled', 'disabled').empty();
                                            $(".show-rate, .show-ongkir, .show-delivery").html('&ndash;');
                                            $(".show-total").text("Rp" + number_format(total, 2, ',', '.'));
                                        }
                                    }.bind(this), 800);

                                    $("#shipping-alert, #billing-alert").hide();
                                    $("#summary-alert, #rate-alert").show();
                                    btn_pay.prop('disabled', true);
                                });

                                layanan_kurir.on('change', function () {
                                    $('#preload-summary').show();
                                    $(".list-group-flush, #summary-alert").css('opacity', '.3');

                                    clearTimeout(this.delay);
                                    this.delay = setTimeout(function () {
                                        $('#preload-summary').hide();
                                        $(".list-group-flush, #summary-alert").css('opacity', '1');

                                        if ($(this).val() != "") {
                                            etd = $("option[value=\"" + $(this).val() + "\"]", this).attr('data-etd');
                                            ongkir = $("option[value=\"" + $(this).val() + "\"]", this).attr('data-ongkir');

                                            formatETD(etd);

                                            $(".show-rate").text(kode_kurir.select2('data')[0]['text']);
                                            $(".show-ongkir").text("Rp" + number_format(ongkir, 2, ',', '.'));
                                            $(".show-delivery").html(str_etd);
                                            $(".show-total").text("Rp" + number_format(parseInt(total) + parseInt(ongkir) - parseInt(harga_diskon), 2, ',', '.'));

                                            $("#ongkir").val(ongkir);
                                            $("#durasi_pengiriman").val(etd);
                                            $("#form-pembayaran input[name=nama_kurir]").val(kode_kurir.select2('data')[0]['text']);
                                            $("#form-pembayaran input[name=layanan_kurir]").val($(this).val());
                                            $("#form-pembayaran input[name=total]").val(parseInt(total) + parseInt(ongkir) - parseInt(harga_diskon));
                                            $('#collapse-rate').collapse('hide');

                                        } else {
                                            $(".show-rate, .show-ongkir, .show-delivery").html('&ndash;');
                                            $(".show-total").text("Rp" + number_format(total, 2, ',', '.'));
                                        }
                                    }.bind(this), 800);

                                    $("#heading-billing").parent().show();
                                    $("#shipping-alert, #rate-alert").hide();

                                    if (!$(".card-rb[name=penagihan_id]:checked").val()) {
                                        $("#summary-alert, #billing-alert").show();
                                    } else {
                                        $("#promo_code, #btn_pay").removeAttr('disabled');
                                        $("#summary-alert, #billing-alert").hide();
                                    }
                                });

                            } else {
                                $("#shipping-alert").show();
                                $("#rate-alert, #billing-alert").hide();
                                $("#heading-rate, #heading-billing").parent().hide();
                                $(".show-ongkir, .show-delivery").text('N/A');
                                $("#ongkir, #durasi_pengiriman, #total").val(null);
                            }
                        },
                        error: function () {
                            swal('Oops..', 'Terjadi kesalahan! Silahkan, segarkan browser Anda.', 'error');
                        }
                    });
                }.bind(this), 800);

            } else {
                $("#promo_code, #btn_pay").removeAttr('disabled');
                $("#summary-alert").hide();
            }
        }

        function format(option) {
            var optimage = $(option.element).data('kode'),
                optongkir = $(option.element).data('ongkir'),
                optetd = $(option.element).data('etd');

            if (!option.id) {
                return option.text;
            }

            if (!optongkir && !optetd) {
                return '<img width="64" src="{{asset('images/kurir')}}/' + optimage + '.png" style="padding: 5px">' +
                    '<b>' + option.text + '</b>';
            } else {
                formatETD(optetd);

                return '<img width="80" src="{{asset('images/kurir')}}/' + optimage + '.png" ' +
                    'style="padding: 5px;float: left"><b>' + option.text + '</b><br>' +
                    '<i class="fa fa-money-bill-wave mr-2"></i><b>Rp' + number_format(optongkir, 2, ',', '.') + '</b>&ensp;|&ensp;' +
                    '<i class="fa fa-calendar-check mr-2"></i><b class="text-lowercase">' + str_etd + '</b>';
            }
        }

        function formatETD(etd) {
            if (etd != "") {
                if (etd.toString().indexOf('HARI') > -1) {
                    unit = '';
                } else if (etd.toString().indexOf('JAM') > -1) {
                    unit = '';
                } else {
                    unit = ' hari';
                }

                if (etd.toString().indexOf('+') > -1) {
                    str_etd = '&ge; ' + etd.toString().replace('+', '') + unit;
                } else {
                    if (etd == '1-1') {
                        str_etd = '&le; 1' + unit
                    } else {
                        str_etd = etd.toString().replace('-', ' – ') + unit;
                    }
                }
            } else {
                str_etd = 'N/A';
            }
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
                            harga_diskon = data.discount_price;
                            $("#promo_code").css('border-color', '#ced4da');
                            $("#error_promo").show().find('b').text(data.caption).css('color', '#5bb300');
                            $("#btn_set").removeAttr('disabled');

                            $("#discount").show().find('strong').text(data.discount + '%');
                            $("#discount b").text(data.str_discount);
                            $(".show-total").text(data.str_total);
                            $("#form-pembayaran input[name=discount]").val(data.discount);
                            $("#form-pembayaran input[name=discount_price]").val(harga_diskon);
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
            harga_diskon = 0;
            $("#discount").hide().find('b').text(null);
            $(".show-total").text('Rp' + number_format(parseInt(total) + parseInt(ongkir) - parseInt(harga_diskon), 2, ',', '.'));
            $("#form-pembayaran input[name=discount], #form-pembayaran input[name=discount_price]").val(null);
            $("#form-pembayaran input[name=total]").val(parseInt(total) + parseInt(ongkir) - parseInt(harga_diskon));
        }

        btn_pay.on("click", function () {
            if (!kode_kurir.val() || !layanan_kurir.val()) {
                swal('PERHATIAN!', 'Field logistik dan jenis layanannya tidak boleh dikosongi!', 'warning');
            } else {
                clearTimeout(this.delay);
                this.delay = setTimeout(function () {
                    $.ajax({
                        url: '{{route('get.midtrans.snap')}}',
                        type: "GET",
                        data: $("#form-pembayaran").serialize(),
                        beforeSend: function () {
                            btn_pay.prop("disabled", true).html(
                                'LOADING&hellip; <span class="spinner-border spinner-border-sm float-right" role="status" aria-hidden="true"></span>'
                            );
                        },
                        complete: function () {
                            btn_pay.prop("disabled", false).html('CHECKOUT <i class="fa fa-chevron-right float-right"></i>');
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
            }
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

        $(window).on('beforeunload', function () {
            return "You have attempted to leave this page. Are you sure?";
        });
    </script>
@endpush
