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
                <div class="col-sm-4 col-md-4 col-lg-3">
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
                <div class="col-sm-8 col-md-8 col-lg-9">
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
                    <img src="{{asset('images/empty-cart.gif')}}" class="img-responsive ajax-loader">
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
        var sort = $("#sort"), kat = $("#sub"), harga = $("#harga"), $kat = '{{$kat}}', $harga = '',
            range_max = parseInt('{{abs(round((\App\Models\Produk::getMahal() + 500), -3))}}') + 10000;

        $(function () {
            $('.ajax-loader').hide();
            $('#search-result, .myPagination').show();

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
                to: parseInt('{{abs(round((\App\Models\Produk::getMurah() + 500), -3))}}') + 25000,
                drag_interval: true,
                prefix: 'Rp',
                prettify_separator: '.',
                onChange: function (data) {
                    if (data.from > range_max - 1 || data.to > range_max - 1) {
                        range_max += 10000;
                        harga.data("ionRangeSlider").update({max: range_max});
                    }

                    if (data.from > 0) {
                        resetter(1, data.from, data.to);
                    } else {
                        resetter(0);
                    }
                }
            });

            @if(!is_null($kat))
            kat.val($kat.split(',')).change();
            @endif
        });

        function resetter(check, from, to) {
            if(check == 1) {
                $harga = from + '-' + to;
                loadData();
            } else {
                $harga = '';
                range_max = parseInt('{{abs(round((\App\Models\Produk::getMahal() + 500), -3))}}') + 10000;
                harga.data("ionRangeSlider").update({
                    max: range_max,
                    from: parseInt('{{abs(round((\App\Models\Produk::getMurah() + 500), -3))}}'),
                    to: parseInt('{{abs(round((\App\Models\Produk::getMurah() + 500), -3))}}') + 25000,
                });
            }
        }

        function loadData() {
            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: "{{route('get.cari-data.produk')}}",
                    type: "GET",
                    data: {kat: kat.val(), q: keyword.val(), harga: $harga, sort: sort.val()},
                    beforeSend: function () {
                        $('.ajax-loader').show();
                        $('#search-result, .myPagination').hide();
                    },
                    complete: function () {
                        $('.ajax-loader').hide();
                        $('#search-result, .myPagination').show();
                    },
                    success: function (data) {
                        console.log(data);
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
            $('html,body').animate({scrollTop: $("#myTab").offset().top}, 500);
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
                    data: {kat: kat.val(), q: keyword.val(), harga: $harga, sort: sort.val()},
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
            var $result = '', pagination = '', $page = '', $_kat = '', $_harga = '', $_sort = '';
            $.each(data.data, function (i, val) {
                $result +=
                    '<div class="col-md-3">\n' +
                    '                            <div class="item-product first">\n' +
                    '                                <div class="product-thumb">\n' +
                    '                                    <div class="midd">\n' +
                    '                                        <a href="product.html"><img src="images/shop/1.jpg" alt=""></a>\n' +
                    '                                        <div class="n-content">\n' +
                    '                                            <p>New</p>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="info-product">\n' +
                    '                                    <h4><a href="product.html">Dictum spsuming</a></h4>\n' +
                    '                                    <div class="rating">\n' +
                    '                                        <i class="fa fa-star"></i>\n' +
                    '                                        <i class="fa fa-star"></i>\n' +
                    '                                        <i class="fa fa-star"></i>\n' +
                    '                                        <i class="fa fa-star"></i>\n' +
                    '                                        <i class="fa fa-star-o"></i>\n' +
                    '                                    </div>\n' +
                    '                                    <p class="price">$430</p>\n' +
                    '                                    <div class="add-cart">\n' +
                    '                                        <a href="#" class="shop-btn">Add to Cart</a>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>\n' +
                    '                        </div>';
            });
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
            if (!kat.val()) {
                $_kat = '&kat=' + kat.val();
            }
            if($harga != '') {
                $_harga = '&harga=' + $harga;
            }
            if(!sort.val()) {
                $_sort = '&sort=' + sort.val();
            }
            window.history.replaceState("", "", '{{url('/cari')}}?q=' + keyword.val() + $_kat + $_harga + $_sort + $page);
            return false;
        }
    </script>
@endpush
