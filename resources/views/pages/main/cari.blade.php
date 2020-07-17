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
        .irs-handle:hover > i:first-child { background-color: #5bb300 !important; }

        .irs-from:before,
        .irs-to:before,
        .irs-single:before { border-top-color: #5bb300 !important; }

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
                    <div class="top-filter">
                        <p class="woocommerce-result-count">Menampilkan <b>1 - 6</b> dari <b>10</b> produk</p>
                        <form class="woocommerce-ordering">
                            <select id="sort" name="sort">
                                <option></option>
                                <option value="popularitas">Popularitas</option>
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
                from: parseInt('{{abs(round((\App\Models\Produk::getMurah() + 500), -3))}}'),
                to: range_max,
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
            var $result = '', $img = '', $route_detail = '', $disc_elm = '', price = 0, $price = '',
                pagination = '', $page = '', $_kat = '', $_harga = '', $_sort = '';

            if (data.data.length > 0) {
                $.each(data.data, function (i, val) {
                    $img = '{{asset('storage/produk/thumb')}}/' + val.gambar;
                    $route_detail = '{{url('/')}}/' + val.permalink;

                    price = val.is_diskon == 1 ? parseInt(val.harga - (val.harga * val.diskon / 100)) : 0;

                    $disc_elm = val.is_diskon == 1 ? '<div class="n-content"><p>-' + val.diskon + '%</p></div>' : '';
                    $price = val.is_diskon == 1 ? '<p class="price mb-0">Rp' + number_format(price, 2, ",", ".") + '</p>' +
                        '<s>Rp' + number_format(val.harga, 2, ",", ".") + '</s>' :
                        '<p class="price mb-0">Rp' + number_format(val.harga, 2, ",", ".") + '</p>';

                    $result +=
                        '<div class="col-lg-3 col-md-4 col-sm-6">' +
                        '<div class="item-product first" style="cursor: pointer" ' +
                        'onclick="window.location.href=\'' + $route_detail + '\'">' +
                        '<div class="product-thumb">' +
                        '<div class="midd"><a href="' + $route_detail + '">' +
                        '<img src="' + $img + '" alt="' + val.nama + '"></a>' + $disc_elm + '</div></div>' +
                        '<div class="info-product pt-0">' +
                        '<h4><a href="' + $route_detail + '">' + val.nama + '</a></h4>' +
                        '<div class="rating">' +
                        '<i class="fa fa-star"></i>' +
                        '<i class="fa fa-star"></i>' +
                        '<i class="fa fa-star"></i>' +
                        '<i class="fa fa-star"></i>' +
                        '<i class="far fa-star"></i>' +
                        '</div>' + $price + '</div></div></div>';
                });
            } else {
                $result += '<div class="col-lg-12"><img src="{{asset('images/empty-cart.gif')}}" alt="Empty"></div>'
            }
            $("#search-result").empty().append($result);

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
                        '<a class="page-link" style="cursor: pointer">&hellip;</a></li>'
                }
                for ($i = 1; $i <= data.last_page; $i++) {
                    if ($i >= data.current_page - 3 && $i <= data.current_page + 3) {
                        if (data.current_page == $i) {
                            pagination += '<li class="page-item active"><span class="page-link">' + $i + '</span></li>'
                        } else {
                            pagination += '<li class="page-item">' +
                                '<a class="page-link" style="cursor: pointer">' + $i + '</a></li>'
                        }
                    }
                }
                if (data.current_page < data.last_page - 3) {
                    pagination += '<li class="page-item hellip_next">' +
                        '<a class="page-link" style="cursor: pointer">&hellip;</a></li>'
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
            return false;
        }
    </script>
@endpush
