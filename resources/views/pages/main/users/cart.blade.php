@extends('layouts.mst')
@section('title', 'Cart ('.count($carts).' produk): '.Auth::user()->name.' | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('css/card.css')}}">
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

        .btn-link {
            border: 1px solid #ccc;
            text-decoration: none !important;
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
                                <th class="text-center">Qty.</th>
                                <th class="text-center">Berat</th>
                                <th class="text-right">Total</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($carts as $row)
                                @php $wishlist = \App\Models\Favorit::where('user_id', Auth::id())->where('produk_id', $row->produk_id)->first() @endphp
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
                                                Tersedia: <b>{{$row->getProduk->stock}}</b> pcs</span><br>
                                        <a href="{{route('produk', ['produk' => $row->getProduk->permalink])}}"><b>{{$row->getProduk->nama}}</b></a>
                                        <p class="single-price mb-0">
                                            @if($row->getProduk->is_diskon == true)
                                                Rp{{number_format($row->getProduk->harga_diskon,2,',','.')}}
                                                <s>Rp{{number_format($row->getProduk->harga,2,',','.')}}</s>
                                                <span>-{{$row->getProduk->diskon}}%</span>
                                            @else
                                                Rp{{number_format($row->getProduk->harga,2,',','.')}}
                                            @endif
                                        </p>
                                        <p>{{$row->getProduk->deskripsi}}</p>
                                    </td>
                                    <td style="vertical-align: middle" align="center"><b>{{$row->qty}}</b> pcs</td>
                                    <td style="vertical-align: middle" align="center">
                                        <b>{{number_format($row->berat / 1000,2,',','.')}}</b> kg
                                    </td>
                                    <td style="vertical-align: middle" align="right">
                                        <b>Rp{{number_format($row->total,2,',','.')}}</b>
                                    </td>
                                    <td style="vertical-align: middle" align="center">
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
                columnDefs: [{"sortable": false, "targets": 5}],
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
                        text: '<i class="fa fa-heart mr-2"></i> <b>Pindah Semua ke Wishlist</b>',
                        className: 'btn btn-color2 btn-sm btn-wishlist'
                    },
                    {
                        text: '<i class="fa fa-trash-alt mr-2"></i> <b>Hapus Semua Cart</b>',
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

        function goToAnchor() {
            $('html,body').animate({scrollTop: $(".crumb").offset().top}, 500);
        }
    </script>
@endpush
