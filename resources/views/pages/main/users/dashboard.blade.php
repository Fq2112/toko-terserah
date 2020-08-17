@extends('layouts.mst')
@section('title', 'Dashboard – Riwayat Pemesanan: '.Auth::user()->name.' | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('css/tracking-log.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('admins/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Select-1.2.4/css/select.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Buttons-1.5.6/css/buttons.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/lightgallery/dist/css/lightgallery.min.css')}}">
    <style>
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

        blockquote {
            background: unset;
            border-color: #eee;
            color: #555;
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
            background: #fff;
        }

        .toggle .togglet,
        .toggle .toggleta {
            display: block;
            position: relative;
            line-height: 24px;
            padding: 0 1em;
            margin: 0;
            font-size: 12px;
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
            font-size: 14px;
            margin: .5em 0 .25em;
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

        td .input-group-btn .btn-color7:hover:before, td .input-group-btn .btn-color7:focus:before, td .input-group-btn .btn-color7:active:before {
            border-radius: 4px 0 0 4px;
        }

        td .input-group-btn .btn-color4:hover:before, td .input-group-btn .btn-color4:focus:before, td .input-group-btn .btn-color4:active:before {
            border-radius: 0;
        }

        td .input-group-btn .btn-color2:hover:before, td .input-group-btn .btn-color2:focus:before, td .input-group-btn .btn-color2:active:before {
            border-radius: 0 4px 4px 0;
        }

        .tracking-list > * {
            font-size: 14px;
        }
    </style>
@endpush
@section('content')
    <div class="breadcrumbs" style="background-image: url('{{Auth::user()->getBio->background != null ?
    asset('storage/users/background/'.Auth::user()->getBio->background) : asset('images/page-header/users.jpg')}}')">
        <div class="breadcrumbs-overlay"></div>
        <div class="page-title">
            <h2>Dashboard: Riwayat Pemesanan</h2>
            <p>Di sini Anda dapat melihat riwayat pemesanan Anda beserta statusnya.</p>
        </div>
        <ul class="crumb">
            <li><a href="{{route('beranda')}}"><i class="fa fa-home"></i></a></li>
            <li style="text-transform: none"><i class="fa fa-angle-double-right"></i>
                <a href="{{URL::current()}}">Akun</a></li>
            <li><a href="#" onclick="goToAnchor()"><i class="fa fa-angle-double-right"></i> Dashboard</a></li>
        </ul>
    </div>

    <section class="none-margin" style="padding: 40px 0 40px 0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive" id="dt-pesanan">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th width="5%" class="text-center">#</th>
                                <th width="50%">Detail Pesanan</th>
                                <th width="15%" class="text-center">Status</th>
                                <th width="10%" class="text-center">Dikirim</th>
                                <th width="10%" class="text-center">Diterima</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($pesanan as $row)
                                @php
                                    $carts = \App\Models\Keranjang::whereIn('id', $row->keranjang_ids)->get();
                                    if (strpos($row->durasi_pengiriman, 'HARI') !== false) {
                                        $unit = '';
                                    } elseif (strpos($row->durasi_pengiriman, 'JAM') !== false) {
                                        $unit = '';
                                    } else {
                                        $unit = ' hari';
                                    }

                                    if (strpos($row->durasi_pengiriman, '+') !== false) {
                                        $str_etd = '&ge; ' . str_replace('+','',$row->durasi_pengiriman) . $unit;
                                    } else {
                                        if ($row->durasi_pengiriman == '1-1') {
                                            $str_etd = '&le; 1' . $unit;
                                        } else {
                                            $str_etd = str_replace('-',' – ',$row->durasi_pengiriman) . $unit;
                                        }
                                    }

                                    if(is_null($row->tgl_diterima)) {
                                        if(is_null($row->tgl_pengiriman)) {
                                            if($row->isLunas == false){
                                                $class = 'danger';
                                                $status = 'MENUNGGU PEMBAYARAN';
                                            } else {
                                                $class = 'info';
                                                $status = $row->isAmbil == false ? 'SEDANG DIKEMAS' : 'SIAP DIAMBIL';
                                            }
                                        } else {
                                            $class = 'warning';
                                            $status = 'DALAM PENGIRIMAN';
                                        }
                                    } else {
                                        $class = 'success';
                                        $status = 'PESANAN SELESAI';
                                    }
                                @endphp
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle">
                                        <a href="{{route('user.download.file', ['code' => $row->uni_code])}}">
                                            <h5>#{{$row->uni_code}}</h5></a>
                                        <div class="toggle toggle-border mb-3" data-state="close">
                                            <div class="togglet toggleta font-weight-normal text-uppercase">
                                                <i class="toggle-closed fa fa-chevron-down"></i>
                                                <i class="toggle-open fa fa-chevron-up"></i>
                                                Kalkulasi
                                            </div>
                                            <div class="togglec">
                                                <ul class="list-group list-group-flush mb-0">
                                                    <li class="list-group-item border-none">
                                                        Subtotal ({{$carts->sum('qty')}} item)
                                                        <b class="float-right">Rp{{number_format($carts->sum('total'),2,',','.')}}</b>
                                                    </li>
                                                    <li class="list-group-item border-none">
                                                        Berat
                                                        <b class="float-right">{{number_format($row->berat_barang / 1000,2,',','.')}}
                                                            kg</b>
                                                    </li>
                                                    <li class="list-group-item border-none">
                                                        Ongkir
                                                        <b class="float-right show-ongkir">Rp{{number_format($row->ongkir,2,',','.')}}</b>
                                                    </li>
                                                    <li class="list-group-item border-none">
                                                        Durasi Pengiriman
                                                        <b class="float-right show-delivery text-lowercase">{!! $str_etd !!}</b>
                                                    </li>
                                                    @if($row->is_discount == true)
                                                        <li id="discount" class="list-group-item border-none">
                                                            Diskon <b>{{$row->discount}}%</b>
                                                            <b class="float-right">-Rp{{number_format(ceil($carts->sum('total') * $row->discount / 100),2,',','.')}}</b>
                                                        </li>
                                                    @endif
                                                </ul>
                                                <hr class="my-2">
                                                <ul class="list-group list-group-flush mb-0">
                                                    <li class="list-group-item border-none">
                                                        TOTAL<b class="float-right show-total" style="font-size: large">
                                                            Rp{{number_format($row->total_harga,2,',','.')}}</b>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="toggle toggle-border mb-3" data-state="close">
                                            <div class="togglet toggleta font-weight-normal text-uppercase">
                                                <i class="toggle-closed fa fa-chevron-down"></i>
                                                <i class="toggle-open fa fa-chevron-up"></i>
                                                Produk
                                            </div>
                                            <div class="togglec">
                                                @foreach($carts as $cart)
                                                    @php
                                                        $produk = $cart->getProduk;
                                                        $weight = ($produk->berat / 1000) * $cart->qty;
                                                    @endphp
                                                    <div class="media">
                                                        <div class="content-area media-left media-middle"
                                                             style="width: 20%" id="preview{{$cart->id}}"
                                                             onclick="preview('{{$cart->id}}','{{$produk->nama}}',
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
                                                                <ul class="list-group list-group-flush">
                                                                    <li class="list-group-item border-none">
                                                                        Jenis
                                                                        <b class="float-right">{{$produk->isGrosir == true ? 'Grosir' : 'Retail'}}</b>
                                                                    </li>
                                                                    <li class="list-group-item border-none">
                                                                        Qty.
                                                                        <b class="float-right">{{$cart->qty}}
                                                                            pcs</b>
                                                                    </li>
                                                                    <li class="list-group-item border-none">
                                                                        Harga /pcs
                                                                        <b class="float-right">
                                                                            @if($produk->isGrosir == true)
                                                                                Rp{{number_format($produk->isDiskonGrosir == true ? $produk->harga_diskon_grosir : $produk->harga_grosir,2,',','.')}}
                                                                            @else
                                                                                Rp{{number_format($produk->is_diskon == true ? $produk->harga_diskon : $produk->harga,2,',','.')}}
                                                                            @endif
                                                                        </b>
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
                                                                           style="font-size: large">Rp{{number_format($cart->total,2,',','.')}}</b>
                                                                    </li>
                                                                </ul>
                                                            </blockquote>
                                                        </div>
                                                    </div>
                                                    <hr class="mt-3">
                                                @endforeach
                                                @if(!is_null($row->note))
                                                    <b>Catatan:</b>
                                                    <p>{{$row->note}}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <span class="label label-{{$class}}">{{$status}}</span>
                                    </td>
                                    <td style="vertical-align: middle"
                                        align="center">{{!is_null($row->tgl_pengiriman) ? \Carbon\Carbon::parse($row->tgl_pengiriman)->formatLocalized('%d %B %Y') : '-'}}</td>
                                    <td style="vertical-align: middle"
                                        align="center">{{!is_null($row->tgl_diterima) ? \Carbon\Carbon::parse($row->tgl_diterima)->formatLocalized('%d %B %Y') : '-'}}</td>
                                    <td style="vertical-align: middle" align="center">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a href="{{route('user.download.file', ['code' => $row->uni_code])}}"
                                                   class="btn btn-color7 btn-sm" style="border-radius:4px 0 0 4px;"
                                                   data-toggle="tooltip" title="Faktur Pesanan">
                                                    <i class="fa fa-download" style="margin-right: 0"></i>
                                                </a>
                                                @if($row->isAmbil == false && $row->is_kurir_terserah == false)
                                                    <button class="btn btn-color4 btn-sm"
                                                            data-toggle="tooltip" title="Lacak Pesanan"
                                                            onclick="lacakPesanan('{{$row->uni_code}}','{{$row->resi}}',
                                                                '{{$row->kode_kurir}}','{{$row->layanan_kurir}}')">
                                                        <i class="fa fa-crosshairs" style="margin-right: 0"></i>
                                                    </button>
                                                @endif
                                                @if($row->isAmbil == false && is_null($row->tgl_diterima))
                                                    <button class="btn btn-color2 btn-sm"
                                                            data-toggle="tooltip" title="Paket Diterima"
                                                            onclick="paketDiterima('{{$row->uni_code}}','{{$row->tgl_pengiriman}}',
                                                                '{{route('user.received',['code' => $row->uni_code])}}')">
                                                        <i class="fa fa-box-open" style="margin-right: 0"></i>
                                                    </button>
                                                @else
                                                    <button class="btn btn-color2 btn-sm" title="Pesan Ulang"
                                                            style="border-radius:0 4px 4px 0;" data-toggle="tooltip"
                                                            onclick="pesanUlang('{{$row->uni_code}}','{{$row->tgl_diterima}}',
                                                                '{{route('user.reorder',['code' => $row->uni_code])}}')">
                                                        <i class="fa fa-shopping-cart" style="margin-right: 0"></i>
                                                    </button>
                                                @endif
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="modal fade" id="modalWaybill" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close mt-1" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title" style="font-size: 18px !important;"></h4>
                                </div>
                                <div class="modal-body px-5 py-0">
                                    <div id="preload-waybill" class="ajax-loader">
                                        <div class="preloader4"></div>
                                    </div>
                                    <div class="tracking-list my-0"></div>
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
    <script src="{{asset('admins/modules/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Buttons-1.5.6/js/buttons.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/lightgallery/lib/picturefill.min.js')}}"></script>
    <script src="{{asset('vendor/lightgallery/dist/js/lightgallery-all.min.js')}}"></script>
    <script src="{{asset('vendor/lightgallery/modules/lg-video.min.js')}}"></script>
    <script>
        $(function () {
            $("#dt-pesanan table").DataTable({
                columnDefs: [{targets: 5, sortable: false}],
                language: {
                    "emptyTable": "Anda belum membuat pesanan apapun",
                    "info": "Menampilkan _START_ - _END_ dari _TOTAL_ pesanan",
                    "infoEmpty": "Menampilkan 0 pesanan",
                    "infoFiltered": "(difilter dari _MAX_ total pesanan)",
                    "loadingRecords": "Memuat...",
                    "processing": "Mengolah...",
                    "search": "Cari:",
                    "zeroRecords": "Pesanan yang Anda cari tidak ditemukan.",
                    "lengthMenu": "Tampilkan _MENU_ pesanan",
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
                fnDrawCallback: function (oSettings) {
                    $('.use-nicescroll').getNiceScroll().resize();
                    $('[data-toggle="tooltip"]').tooltip();

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
                },
            });

            @if(session('reorder'))
            swal({
                title: "Checkout Cart",
                text: "{{session('reorder')}}",
                icon: 'warning',
                dangerMode: true,
                buttons: ["Tidak", "Ya, checkout sekarang!"],
                closeOnEsc: false,
                closeOnClickOutside: false,
            }).then((confirm) => {
                if (confirm) {
                    swal({icon: "success", buttons: false});
                    $("#form-cart_ids").submit();
                }
            });
            @endif
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

        function lacakPesanan(code, resi, kode_kurir, layanan_kurir) {
            $(".tracking-list").empty();

            if (resi != "") {
                $("#modalWaybill .modal-title").html(kode_kurir.toUpperCase() + ' ' + layanan_kurir + ' #<b>' + resi + '</b>');
                $("#modalWaybill").modal('show');

                clearTimeout(this.delay);
                this.delay = setTimeout(function () {
                    $.ajax({
                        url: "{{route('get.rajaongkir.waybill')}}",
                        data: {waybill: resi, courier: kode_kurir},
                        type: "GET",
                        beforeSend: function () {
                            $('#preload-waybill').show();
                            $(".tracking-list").css('opacity', '.3');
                        },
                        complete: function () {
                            $('#preload-waybill').hide();
                            $(".tracking-list").css('opacity', '1');
                        },
                        success: function (data) {
                            var waybill = data['rajaongkir']['result'];
                            if (kode_kurir != 'pos') {
                                $.each(waybill['manifest'], function (i, val) {
                                    $(".tracking-list").prepend(
                                        '<div class="tracking-item intransit">' +
                                        '<div class="tracking-icon status-intransit">' +
                                        '<svg class="svg-inline--fa fa-shipping-fast fa-w-20" aria-hidden="true" ' +
                                        'data-prefix="fas" data-icon="shipping-fast" role="img" ' +
                                        'xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">' +
                                        '<path fill="currentColor" d="M624 352h-16V243.9c0-12.7-5.1-24.9-14.1-33.9L494 110.1c-9-9-21.2-14.1-33.9-14.1H416V48c0-26.5-21.5-48-48-48H112C85.5 0 64 21.5 64 48v48H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h272c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H40c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h208c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h208c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H64v128c0 53 43 96 96 96s96-43 96-96h128c0 53 43 96 96 96s96-43 96-96h48c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zM160 464c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm320 0c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm80-208H416V144h44.1l99.9 99.9V256z">' +
                                        '</path></svg></div>' +
                                        '<div class="tracking-date">' + moment(val.manifest_date).format("DD MMMM YYYY") + '' +
                                        '<span>' + val.manifest_time + '</span></div>' +
                                        '<div class="tracking-content">' + waybill['delivery_status'].status + '' +
                                        '<span>' + val.manifest_description + '</span></div></div>');
                                });

                            } else {
                                $.each(waybill['manifest'], function (i, val) {
                                    $(".tracking-list").append(
                                        '<div class="tracking-item intransit">' +
                                        '<div class="tracking-icon status-intransit">' +
                                        '<svg class="svg-inline--fa fa-shipping-fast fa-w-20" aria-hidden="true" ' +
                                        'data-prefix="fas" data-icon="shipping-fast" role="img" ' +
                                        'xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">' +
                                        '<path fill="currentColor" d="M624 352h-16V243.9c0-12.7-5.1-24.9-14.1-33.9L494 110.1c-9-9-21.2-14.1-33.9-14.1H416V48c0-26.5-21.5-48-48-48H112C85.5 0 64 21.5 64 48v48H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h272c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H40c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h208c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h208c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H64v128c0 53 43 96 96 96s96-43 96-96h128c0 53 43 96 96 96s96-43 96-96h48c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zM160 464c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm320 0c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm80-208H416V144h44.1l99.9 99.9V256z">' +
                                        '</path></svg></div>' +
                                        '<div class="tracking-date">' + moment(val.manifest_date).format("DD MMMM YYYY") + '' +
                                        '<span>' + val.manifest_time + '</span></div>' +
                                        '<div class="tracking-content">' + waybill['delivery_status'].status + '' +
                                        '<span>' + val.manifest_description + '</span></div></div>');
                                });
                            }

                            $(".tracking-list .tracking-item:first-child").removeClass('intransit').addClass('outfordelivery')
                                .find('.tracking-icon').removeClass('status-intransit').addClass('status-outfordelivery')
                                .find('.tracking-date').css('color', '#5bb300')
                                .find('.tracking-content').css('color', '#5bb300');
                        },
                        error: function () {
                            swal('Oops..', 'Terjadi kesalahan! Silahkan, segarkan browser Anda.', 'error');
                        }
                    });
                }.bind(this), 800);

            } else {
                swal('PERHATIAN!', 'Nomor resi untuk pesanan [' + code + '] Anda belum tersedia!', 'warning');
            }
        }

        function paketDiterima(code, cek, uri) {
            if (cek != "") {
                swal({
                    title: "Apakah Anda yakin?",
                    text: "Dengan melanjutkan ini, Anda mengakui bahwa Anda telah menerima paket pesanan [" + code + "] dan tidak ada masalah.",
                    icon: 'warning',
                    dangerMode: true,
                    buttons: ["Tidak", "Ya, saya telah menerimanya!"],
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                }).then((confirm) => {
                    if (confirm) {
                        swal({icon: "success", buttons: false});
                        window.location.href = uri;
                    }
                });
            } else {
                swal('PERHATIAN!', 'Paket pesanan [' + code + '] Anda belum dikirimkan!', 'warning');
            }
        }

        function pesanUlang(code, cek, uri) {
            if (cek != "") {
                swal({
                    title: "Pesan Ulang",
                    text: "Apakah Anda yakin akan memesan ulang semua produk yang ada di pesanan [" + code + "] tersebut?",
                    icon: 'warning',
                    dangerMode: true,
                    buttons: ["Tidak", "Ya, pesan sekarang!"],
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                }).then((confirm) => {
                    if (confirm) {
                        swal({icon: "success", buttons: false});
                        window.location.href = uri;
                    }
                });
            } else {
                swal('PERHATIAN!', 'Anda belum menerima pesanan [' + code + '] tersebut!', 'warning');
            }
        }

        function goToAnchor() {
            $('html,body').animate({scrollTop: $(".crumb").offset().top}, 500);
        }
    </script>
@endpush
