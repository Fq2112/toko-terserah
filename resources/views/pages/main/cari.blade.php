@extends('layouts.mst')
@section('title', 'Cari Produk'.$title.'dengan Harga Terbaik | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('vendor/ion-rangeslider/css/ion.rangeslider.css')}}" type="text/css">
    <style>
        .sidebar .widget li.select2-search {
            border-bottom: 0;
        }

        .select2-container--default .select2-selection--single {
            border-radius: 4px;
        }

        .irs-bar,
        .irs-from,
        .irs-to,
        .irs-single,
        .irs-handle > i:first-child,
        .irs-handle.state_hover > i:first-child,
        .irs-handle:hover > i:first-child {
            background-color: #5bb300 !important;
        }

        .irs-from:before,
        .irs-to:before,
        .irs-single:before {
            border-top-color: #5bb300 !important;
        }

        .irs-single, .irs-handle {
            cursor: grab;
        }

        .irs-single:focus, .irs-handle:focus,
        .irs-single:active, .irs-handle:active {
            cursor: grabbing;
        }

        .irs-line, .irs-bar {
            cursor: pointer;
        }
    </style>
@endpush
@section('content')
    <section class="page-content page-sidebar none-padding">
        <div class="container">
            <div class="row">
                <div class="col-sm-5 col-md-4 col-lg-3">
                    <div class="sidebar">
                        <div class="widget">
                            <h4>Kategori Produk</h4>
                            <select id="sub" name="sub" class="form-control" multiple>
                                <option></option>
                                @foreach($kategori as $row)
                                    <optgroup label="{{$row->nama}}">
                                        @foreach(\App\Models\SubKategori::where('kategori_id', $row->id)->orderBy('nama')->get() as $sub)
                                            <option value="{{$sub->id}}">{{$sub->nama}}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div class="widget">
                            <h4>Harga Produk</h4>
                            <input id="harga" name="harga" class="input-range-slider">
                        </div>
                    </div>
                </div>
                <div class="col-sm-7 col-md-8 col-lg-9">
                    <h2>Hasil Pencarian</h2>
                    <div class="top-filter mb-3">
                        <p class="woocommerce-result-count">
                            Menampilkan <b id="count"></b> dari <b id="count-total"></b> produk</p>
                        <form class="woocommerce-ordering">
                            <select id="sort" name="sort">
                                <option></option>
                                <option value="popularitas">Popularitas</option>
                                <option value="rating">Rating Tertinggi</option>
                                <option value="harga-asc">Harga: rendah ke tinggi</option>
                                <option value="harga-desc">Harga: tinggi ke rendah</option>
                            </select>
                        </form>
                    </div>
                    <div class="ajax-loader" style="display: none">
                        <div class="preloader4"></div>
                    </div>
                    <div class="row" id="search-result"></div>
                    <div class="row text-right">
                        <div class="col-lg-12 myPagination text-right">
                            <ul class="pagination"></ul>
                        </div>
                    </div>
                    <div class="row search-result"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{asset('vendor/masonry/masonry.pkgd.min.js')}}"></script>
    <script src="{{asset('vendor/ion-rangeslider/js/ion.rangeslider.min.js')}}"></script>
    <script>
        var keyword = $("#keyword"), btn_reset = $("#btn_reset"),
            sort = $("#sort"), kat = $("#sub"), harga = $("#harga"),
            $sort = '', $kat = '{{$kat}}', $harga = '',
            range_max = parseInt('{{abs(round((\App\Models\Produk::getMahal() + 500), -3))}}');

        $(function () {
            keyword.autocomplete({
                source: function (request, response) {
                    $.getJSON('{{route('get.cari-nama.produk')}}', {q: request.term}, function (data) {
                        response(data)
                    });
                },
                focus: function (event, ui) {
                    event.preventDefault();
                },
                select: function (event, ui) {
                    event.preventDefault();
                    keyword.val(ui.item.label);
                    loadData();
                }
            });

            sort.select2({
                placeholder: "-- Urutkan Berdasarkan --",
                allowClear: true,
                width: '100%',
            });

            kat.select2({
                placeholder: "-- Pilih Kategori --",
                allowClear: true,
                width: '100%',
            });

            harga.ionRangeSlider({
                type: "double",
                grid: true,
                grid_num: 5,
                min: 0,
                max: range_max,
                from: parseInt('{{\App\Models\Produk::getMurah()}}'),
                to: parseInt('{{\App\Models\Produk::getMahal()}}'),
                drag_interval: true,
                prefix: 'Rp',
                prettify_separator: '.',
                onChange: function (data) {
                    if (data.from > range_max - 1 || data.to > range_max - 1) {
                        range_max += 10000;
                        harga.data("ionRangeSlider").update({max: range_max});
                    }

                    $harga = data.from + '-' + data.to;
                    loadData();
                }
            });

            @if(!is_null($kat))
            kat.val($kat.split(',')).change();
            @endif

            loadData();
        });

        keyword.on("keyup", function () {
            if (!$(this).val()) {
                $(this).removeAttr('value');
            } else {
                btn_reset.show();
            }

            loadData();
        });

        btn_reset.on("click", function () {
            keyword.removeAttr('value');
            $(this).hide();

            loadData();
        });

        kat.on('change', function () {
            if ($(this).find('option:selected').length > 0) {
                $kat = $(this).val().join(',');
            }
            loadData();
        });

        sort.on('change', function () {
            loadData();
        });

        function loadData() {
            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: "{{route('get.cari-data.produk')}}",
                    type: "GET",
                    data: {kat: $kat, q: keyword.val(), harga: $harga, sort: sort.val()},
                    beforeSend: function () {
                        $('.ajax-loader').show();
                        $('#search-result, .myPagination').hide();
                    },
                    complete: function () {
                        $('.ajax-loader').hide();
                        $('#search-result, .myPagination').show();
                    },
                    success: function (data) {
                        successLoad(data);
                    },
                    error: function () {
                        swal('Oops..', 'Terjadi kesalahan! Silahkan, segarkan browser Anda.', 'error');
                    }
                });
            }.bind(this), 800);
            return false;
        }

        $('.myPagination ul').on('click', 'li', function () {
            $('html,body').animate({scrollTop: $(".page-content").offset().top}, 500);

            var $url, page = $(this).children().text(),
                active = $(this).parents("ul").find('.active').eq(0).text(),
                hellip_prev = $(this).closest('.hellip_prev').next().find('a').text(),
                hellip_next = $(this).closest('.hellip_next').prev().find('a').text();

            if (page > 0) {
                $url = "{{url('/cari/data')}}" + '?page=' + page;
            }
            if ($(this).hasClass('prev')) {
                $url = "{{url('/cari/data')}}" + '?page=' + parseInt(active - 1);
            }
            if ($(this).hasClass('next')) {
                $url = "{{url('/cari/data')}}" + '?page=' + parseInt(+active + +1);
            }
            if ($(this).hasClass('hellip_prev')) {
                $url = "{{url('/cari/data')}}" + '?page=' + parseInt(hellip_prev - 1);
                page = parseInt(hellip_prev - 1);
            }
            if ($(this).hasClass('hellip_next')) {
                $url = "{{url('/cari/data')}}" + '?page=' + parseInt(+hellip_next + +1);
                page = parseInt(+hellip_next + +1);
            }
            if ($(this).hasClass('first')) {
                $url = "{{url('/cari/data')}}" + '?page=1';
            }
            if ($(this).hasClass('last')) {
                $url = "{{url('/cari/data')}}" + '?page=' + last_page;
            }
            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: $url,
                    type: "GET",
                    data: {kat: $kat, q: keyword.val(), harga: $harga, sort: sort.val()},
                    beforeSend: function () {
                        $('.ajax-loader').show();
                        $('#search-result, .myPagination').hide();
                    },
                    complete: function () {
                        $('.ajax-loader').hide();
                        $('#search-result, .myPagination').show();
                    },
                    success: function (data) {
                        successLoad(data, page);
                    },
                    error: function () {
                        swal('Oops..', 'Terjadi kesalahan! Silahkan, segarkan browser Anda.', 'error');
                    }
                });
            }.bind(this), 800);
            return false;
        });

        function successLoad(data, page) {
            var $q = '', total = '', $result = '', $disc_elm = '', $price = '',
                pagination = '', $page = '', $_kat = '', $_harga = '', $_sort = '';

            $q = keyword.val() != "" ? ' untuk <b>"' + keyword.val() + '"</b>' : '';
            if (data.total > 1) {
                total = $.trim(data.total) ?
                    ' (<b>' + data.from + '</b> - ' + '<b>' + data.to + '</b> dari <b>' + data.total + '</b>)' : '';
            } else {
                total = '';
            }
            $(".woocommerce-result-count").html('Menampilkan <b>' + data.total + '</b> produk' + $q + total);

            if (data.total > 0) {
                $.each(data.data, function (i, val) {
                    $disc_elm = val.is_diskon == 1 ? '<div class="n-content"><p>-' + val.diskon + '%</p></div>' : '';
                    $price = val.is_diskon == 1 ? '<p class="price mb-0">Rp' + number_format(val.harga_diskon, 2, ",", ".") + '</p>' +
                        '<s>Rp' + number_format(val.harga, 2, ",", ".") + '</s>' :
                        '<p class="price mb-0">Rp' + number_format(val.harga, 2, ",", ".") + '</p>';

                    $result +=
                        '<div class="col-md-4 item">' +
                        '<div class="item-product first hover effect-10">' +
                        '<div class="product-thumb">' +
                        '<div class="midd"><a href="' + val.route_detail + '">' +
                        '<img src="' + val.dir_img + '" alt="' + val.nama + '"></a>' + $disc_elm + '</div></div>' +
                        '<div class="info-product pt-0">' +
                        '<h4><a href="' + val.route_detail + '">' + val.nama + '</a></h4>' +
                        '<div class="rating">' + val.stars + '</div>' + $price + '</div>' +
                        '<div class="cart-overlay">' +
                        '<a href="javascript:void(0)" class="info btn_cart" ' +
                        'onclick="cart(\'' + val.nama + '\',\'' + val.cek_cart + '\',\'' + val.add_cart + '\')">' +
                        '<i class="fa fa-shopping-cart mr-2"></i>Tambah ke Cart</a>' +
                        '<p class="icon-links">' +
                        '<a href="' + val.route_detail + '"><span class="fa fa-search"></span></a>' +
                        '<a href="javascript:void(0)" class="info-2 btn_wishlist" ' +
                        'onclick="wishlist(\'' + val.cek_wishlist + '\',\'' + val.add_wishlist + '\')">' +
                        '<span class="fa fa-heart"></span></a></p>' +
                        '</div></div></div>';
                });
                $("#search-result").empty().append($result);

                setTimeout(function () {
                    reinitMasonry();
                }, 600);

            } else {
                $("#search-result").css('height', 'unset')
                    .html('<div class="col-lg-12"><img src="{{asset('images/empty-cart.gif')}}" alt="Empty"></div>');
            }

            if (data.last_page >= 1) {
                if (data.current_page > 4) {
                    pagination += '<li class="page-item first">' +
                        '<a class="page-link" href="' + data.first_page_url + '">' +
                        '<i class="fa fa-angle-double-left"></i></a></li>';
                }
                if ($.trim(data.prev_page_url)) {
                    pagination += '<li class="page-item prev">' +
                        '<a class="page-link" href="' + data.prev_page_url + '" rel="prev">' +
                        '<i class="fa fa-angle-left"></i></a></li>';
                } else {
                    pagination += '<li class="page-item disabled">' +
                        '<span class="page-link"><i class="fa fa-angle-left"></i></span></li>';
                }
                if (data.current_page > 4) {
                    pagination += '<li class="page-item hellip_prev">' +
                        '<a class="page-link" style="cursor: pointer"><b>&hellip;</b></a></li>'
                }
                for ($i = 1; $i <= data.last_page; $i++) {
                    if ($i >= data.current_page - 3 && $i <= data.current_page + 3) {
                        if (data.current_page == $i) {
                            pagination += '<li class="page-item active"><span class="page-link"><b>' + $i + '</b></span></li>'
                        } else {
                            pagination += '<li class="page-item">' +
                                '<a class="page-link" style="cursor: pointer"><b>' + $i + '</b></a></li>'
                        }
                    }
                }
                if (data.current_page < data.last_page - 3) {
                    pagination += '<li class="page-item hellip_next">' +
                        '<a class="page-link" style="cursor: pointer"><b>&hellip;</b></a></li>'
                }
                if ($.trim(data.next_page_url)) {
                    pagination += '<li class="page-item next">' +
                        '<a class="page-link" href="' + data.next_page_url + '" rel="next">' +
                        '<i class="fa fa-angle-right"></i></a></li>';
                } else {
                    pagination += '<li class="page-item disabled">' +
                        '<span class="page-link"><i class="fa fa-angle-right"></i></span></li>';
                }
                if (data.current_page < data.last_page - 3) {
                    pagination += '<li class="page-item last">' +
                        '<a class="page-link" href="' + data.last_page_url + '">' +
                        '<i class="fa fa-angle-double-right"></i></a></li>';
                }
            }
            $('.myPagination ul').html(pagination);

            if (page != "" && page != undefined) {
                $page = '&page=' + page;
            }
            if (kat.find('option:selected').length > 0) {
                $_kat = '&kat=' + $kat;
            }
            if ($harga != '') {
                $_harga = '&harga=' + $harga;
            }
            if (sort.val() != '') {
                $_sort = '&sort=' + sort.val();
            }
            window.history.replaceState("", "", '{{url('/cari')}}?q=' + keyword.val() + $_kat + $_harga + $_sort + $page);

            document.title = keyword.val() != '' ?
                'Cari Produk "' + keyword.val() + '" dengan Harga Terbaik | {{env('APP_TITLE')}}' :
                'Cari Produk dengan Harga Terbaik | {{env('APP_TITLE')}}';
        }

        function reinitMasonry() {
            var grid = $("#search-result");

            // init
            grid.masonry({
                itemSelector: '.item'
            });

            // destroy
            grid.masonry('destroy');
            grid.removeData('masonry');

            // re-init
            grid.masonry({
                itemSelector: '.item'
            });
        }

        function wishlist(cek, add) {
            @auth
            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.get(cek, function (data) {
                    if (data.status == true) {
                        $.ajax({
                            url: add,
                            type: 'post',
                            data: {_token: '{{csrf_token()}}'},
                            success: function (data) {
                                if (data.status == true) {
                                    $(".show_wishlist").text('( ' + data.total + ' )');
                                    swal('SUKSES!', data.message, 'success');
                                }
                            },
                            error: function () {
                                swal('Oops..', 'Terjadi kesalahan! Silahkan, segarkan browser Anda.', 'error');
                            }
                        });
                    } else {
                        swal('PERHATIAN!', data.message, 'warning');
                    }
                });
            }.bind(this), 800);

            @elseauth('admin')
            swal('PERHATIAN!', 'Fitur ini hanya berfungsi ketika Anda masuk sebagai Pelanggan.', 'warning');

            @else
            openLoginModal();
            @endauth
        }

        function cart(name, cek_uri, add_uri) {
            @auth
            swal({
                title: "Tambah ke Cart",
                text: "Apakah Anda yakin untuk menambahkan produk \"" + name + "\" ke dalam cart Anda?",
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
                                el.parent().find('p').remove();

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
            @elseauth('admin')
            swal('PERHATIAN!', 'Fitur ini hanya berfungsi ketika Anda masuk sebagai Pelanggan.', 'warning');

            @else
            openLoginModal();
            @endauth
        }
    </script>
@endpush
