@extends('layouts.mst')
@section('title', 'Wishlist ('.count($wishlist).' produk): '.Auth::user()->name.' | '.env('APP_TITLE'))
@push('styles')
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

        .single-price {
            font-size: 16px;
            font-family: 'Raleway', sans-serif;
            font-weight: 700;
        }

        .single-price s {
            color: #aaa !important;
            padding-left: 5px;
            font-size: 14px;
        }

        .single-price span {
            color: #555 !important;
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
    </style>
@endpush
@section('content')
    <div class="breadcrumbs" style="background-image: url('{{Auth::user()->getBio->background != null ?
    asset('storage/users/background/'.Auth::user()->getBio->background) : asset('images/page-header/users.jpg')}}')">
        <div class="breadcrumbs-overlay"></div>
        <div class="page-title">
            <h2>Wishlist</h2>
            <p>Di sini Anda dapat mengelola produk-produk {{env('APP_NAME')}} yang telah Anda tambahkan ke wishlist
                sebelumnya.</p>
        </div>
        <ul class="crumb">
            <li><a href="{{route('beranda')}}"><i class="fa fa-home"></i></a></li>
            <li style="text-transform: none"><i class="fa fa-angle-double-right"></i>
                <a href="{{URL::current()}}">Akun</a></li>
            <li><a href="#" onclick="goToAnchor()"><i class="fa fa-angle-double-right"></i> Wishlist</a></li>
        </ul>
    </div>

    <section class="none-margin" style="padding: 40px 0 40px 0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive" id="dt-produk">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Produk</th>
                                <th class="text-center">Diskon</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($wishlist as $row)
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle">
                                        <div class="row float-left mr-0">
                                            <div class="col-lg-12">
                                                <a href="javascript:void(0)" id="preview{{$row->id}}"
                                                   onclick="preview('{{$row->id}}','{{$row->getProduk->nama}}',
                                                       '{{route('get.galeri.produk', ['produk' => $row->getProduk->permalink])}}')">
                                                    <img width="100" alt="Thumbnail" class="img-thumbnail"
                                                         src="{{asset('storage/produk/thumb/'.$row->getProduk->gambar)}}">
                                                </a>
                                            </div>
                                        </div>
                                        <span class="label label-{{$row->getProduk->stock > 0 ? 'success' : 'danger'}}">
                                                Tersedia: <b>{{$row->getProduk->stock}}</b> pcs</span>
                                        <br><a
                                            href="{{route('produk', ['produk' => $row->getProduk->permalink])}}"><b>{{$row->getProduk->nama}}</b></a>
                                        <p>{{$row->getProduk->deskripsi}}</p>
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <span
                                            class="label label-{{$row->getProduk->is_diskon == true ? 'success' : 'default'}}">
                                            {{$row->getProduk->is_diskon == true ? $row->getProduk->diskon : 0}}%</span>
                                    </td>
                                    <td style="vertical-align: middle">
                                        <p class="single-price mb-0"
                                           style="color: {{$row->getProduk->is_diskon == true ? '#5bb300' : ''}};">
                                            @if($row->getProduk->is_diskon == true)
                                                Rp{{number_format($row->getProduk->harga_diskon,2,',','.')}}
                                                <s>Rp{{number_format($row->getProduk->harga,2,',','.')}}</s>
                                            @else
                                                Rp{{number_format($row->getProduk->harga,2,',','.')}}
                                            @endif
                                        </p>
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-color2 btn-sm" style="border-radius:4px 0 0 4px;"
                                                        data-toggle="tooltip" title="Tambah ke Cart"
                                                        {{$row->getProduk->stock > 0 ? '' : 'disabled'}}
                                                        onclick="tambahCart('{{$row->getProduk->nama}}',
                                                            '{{route('produk.cek.cart', ['produk' => $row->getProduk->permalink])}}',
                                                            '{{route('produk.add.cart', ['produk' => $row->getProduk->permalink])}}')">
                                                    <i class="fa fa-shopping-cart" style="margin-right: 0"></i>
                                                </button>
                                                <button class="btn btn-color5 btn-sm" style="border-radius:0 4px 4px 0;"
                                                        data-toggle="tooltip" title="Hapus Wishlist"
                                                        onclick="hapusWishlist('{{route('user.delete.wishlist', ['id' => encrypt($row->id)])}}',
                                                            '{{$row->getProduk->nama}}')">
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
    <script>
        $(function () {
            $("#dt-produk table").DataTable({
                dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                columnDefs: [{"sortable": false, "targets": 4}],
                language: {
                    "emptyTable": "Anda belum menambahkan wishlist apapun",
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
                        text: '<i class="fa fa-shopping-cart mr-2"></i> <b>Tambah Semua ke Cart</b>',
                        className: 'btn btn-color2 btn-sm btn-tambah'
                    },
                    {
                        text: '<i class="fa fa-trash-alt mr-2"></i> <b>Hapus Semua Wishlist</b>',
                        className: 'btn btn-color5 btn-sm btn-hapus'
                    }
                ],
                fnDrawCallback: function (oSettings) {
                    $('.use-nicescroll').getNiceScroll().resize();
                    $('[data-toggle="tooltip"]').tooltip();

                    $(".btn-tambah").on('click', function () {
                        @if(count($wishlist) > 0)
                        swal({
                            title: 'Tambah Semua ke Cart',
                            text: 'Apakah Anda yakin akan menambahkan semua produk yang masih tersedia dan ada di wishlist ke cart Anda? Anda tidak dapat mengembalikannya!',
                            icon: 'warning',
                            dangerMode: true,
                            buttons: ["Tidak", "Ya"],
                            closeOnEsc: false,
                            closeOnClickOutside: false,
                        }).then((confirm) => {
                            if (confirm) {
                                swal({icon: "success", buttons: false});
                                window.location.href = '{{route('user.mass-add.cart')}}';
                            }
                        });
                        @else
                        swal('PERHATIAN!', 'Tidak ada produk di dalam wishlist Anda!', 'warning');
                        @endif
                    });

                    $(".btn-hapus").on('click', function () {
                        @if(count($wishlist) > 0)
                        swal({
                            title: 'Hapus Semua Wishlist',
                            text: 'Apakah Anda yakin akan menghapus semua produk dari wishlist Anda? Anda tidak dapat mengembalikannya!',
                            icon: 'warning',
                            dangerMode: true,
                            buttons: ["Tidak", "Ya"],
                            closeOnEsc: false,
                            closeOnClickOutside: false,
                        }).then((confirm) => {
                            if (confirm) {
                                swal({icon: "success", buttons: false});
                                window.location.href = '{{route('user.mass-delete.wishlist')}}';
                            }
                        });
                        @else
                        swal('PERHATIAN!', 'Tidak ada produk di dalam wishlist Anda!', 'warning');
                        @endif
                    });
                },
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

        function tambahCart(nama, cek_uri, add_uri) {
            swal({
                title: "Tambah ke Cart",
                text: "Apakah Anda yakin untuk menambahkan produk \"" + nama + "\" ke dalam cart Anda?",
                icon: 'warning',
                dangerMode: true,
                buttons: ["Tidak", "Ya"],
                closeOnEsc: false,
                closeOnClickOutside: false,
            }).then((confirm) => {
                if (confirm) {
                    let input = document.createElement("input");
                    input.id = 'qty-cart';
                    input.value = '1';
                    input.type = 'number';
                    input.min = '1';
                    input.className = 'swal-content__input';

                    swal({
                        text: 'Kuantitas: ' + name,
                        content: input,
                        dangerMode: true,
                        buttons: ["Batal", "Tambah ke Cart"],
                        closeOnEsc: false,
                        closeOnClickOutside: false,
                    }).then(val => {
                        if (!val) throw null;
                        $("#form-cart input[name=_method], #form-cart input[name=qty_lama]").val(null);
                        $("#form-cart input[name=qty]").val($("#qty-cart").val());
                        $("#form-cart").attr('action', add_uri).submit();
                    });

                    $("#qty-cart").on('keyup', function () {
                        var el = $(this);
                        if (!el.val() || el.val() == "" || parseInt(el.val()) <= 0) {
                            el.val(1);
                        }

                        $.get(cek_uri, function (data) {
                            if (data.status == true) {
                                el.attr('max', data.stock);
                                el.parent().find('.text-danger').remove();

                                if (parseInt(el.val()) > data.stock) {
                                    if (data.stock > 0) {
                                        el.parent().append("<p class='text-success'>Tersedia: <b>" + data.stock + "</b> pcs</p>");
                                    } else {
                                        el.parent().append("<p class='text-danger'>Tersedia: <b>" + data.stock + "</b> pcs</p>");
                                    }
                                    el.val(data.stock);
                                }

                            } else {
                                swal('PERHATIAN!', data.message, 'warning');
                            }
                        });
                    });
                }
            });
        }

        function hapusWishlist(url, nama) {
            swal({
                title: 'Hapus Wishlist',
                text: 'Apakah Anda yakin akan menghapus produk "' + nama + '" dari wishlist Anda? Anda tidak dapat mengembalikannya!',
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

        function goToAnchor() {
            $('html,body').animate({scrollTop: $(".crumb").offset().top}, 500);
        }
    </script>
@endpush
