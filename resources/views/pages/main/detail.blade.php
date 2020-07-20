@extends('layouts.mst')
@section('title', $produk->nama.' | '.env('APP_TITLE'))
@push('styles')
    <style>
        .single-price span {
            text-decoration: line-through;
            color: #aaa !important;
            padding-left: 5px;
            font-size: 20px;
        }

        span.old-price {
            text-decoration: line-through;
            color: #aaa !important;
            font-size: 14px;
        }

        #form-beli input[name=qty]:disabled {
            cursor: no-drop;
        }

        .btn_wishlist {
            background: transparent !important;
            color: #5bb300 !important;
            border: 1px solid #5bb300;
        }

        .gallery .full {
            width: 400px;
        }

        .varian {
            display: inline-block !important;
        }

        #tab-deskripsi ul {
            margin-left: 2rem;
        }
    </style>
@endpush
@section('content')
    <section class="page-content page-sidebar none-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="content-container">
                        <div class="content-inner">
                            <div class="padding">
                                <div class="pro-details">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="gallery">
                                                <div class="previews">
                                                    <a class="selected"
                                                       data-full="{{asset('storage/produk/thumb/'.$produk->gambar)}}">
                                                        <img width="100" alt="Thumbnail"
                                                             src="{{asset('storage/produk/thumb/'.$produk->gambar)}}"></a>
                                                    @if(!is_null($produk->galeri))
                                                        @foreach($produk->galeri as $img)
                                                            <a data-full="{{asset('storage/produk/galeri/'.$img)}}">
                                                                <img width="100" alt="Galeri"
                                                                     src="{{asset('storage/produk/galeri/'.$img)}}"></a>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="full">
                                                    <img src="{{asset('storage/produk/thumb/'.$produk->gambar)}}"
                                                         alt="Thumbnail">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h3>{{$produk->nama}}</h3>
                                            <div class="single-rating">
                                                <span>{!! $stars !!}</span>
                                                <span><a href="javascript:ulasan()"><b>{{count($ulasan)}}</b> ulasan</a></span>
                                                <p>Tersedia: <span style="color: {{$produk->stock > 0 ? '':'#a94442'}}">
                                                        <b>{{$produk->stock}}</b> pcs</span></p>
                                                <p>{{$produk->deskripsi}}</p>
                                                <p class="single-price">
                                                    @if($produk->is_diskon == true)
                                                        Rp{{number_format($produk->harga_diskon,2,',','.')}}
                                                        <span>Rp{{number_format($produk->harga,2,',','.')}}</span>
                                                    @else
                                                        Rp{{number_format($produk->harga,2,',','.')}}
                                                    @endif
                                                </p>
                                                {{--@if(!is_null($produk->varian))
                                                    <div class="gallery">
                                                        <div class="previews">
                                                            @foreach($produk->varian as $img)
                                                                <a class="varian"
                                                                   data-full="{{asset('storage/produk/varian/'.$img)}}">
                                                                    <img width="100" alt="Varian"
                                                                         src="{{asset('storage/produk/varian/'.$img)}}">
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif--}}
                                                <div class="product-cart">
                                                    <form id="form-beli" method="post"
                                                          action="{{route('produk.add.cart', ['produk' => $produk->permalink])}}">
                                                        @csrf
                                                        <input type="number" min="1" max="{{$produk->stock}}" size="4"
                                                               name="qty" value="1" data-toggle="tooltip" title="Qty."
                                                               class="input-text qty text" required
                                                            {{$produk->stock > 0 ? '' : 'disabled'}}>
                                                        <button type="submit" class="btn btn-color2"
                                                            {{$produk->stock > 0 ? '' : 'disabled'}}>
                                                            <i class="fa fa-shopping-cart mr-2"></i> Tambah ke Cart
                                                        </button>
                                                        <button type="button" class="btn btn-color2 btn_wishlist"
                                                                data-cek="{{route('produk.cek.wishlist', ['produk' => $produk->permalink])}}"
                                                                data-add="{{route('produk.add.wishlist', ['produk' => $produk->permalink])}}"
                                                            {{\App\Models\Favorit::where('produk_id', $produk->id)->where('user_id', Auth::id())->first() ? 'disabled' : ''}}>
                                                            <i class="fa fa-heart mr-0" style="font-size: 14px"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="cat">
                                                    Kategori:
                                                    <a href="javascript:void(0)">
                                                        {{$produk->getSubkategori->getKategori->nama}}</a>,
                                                    <a href="{{route('cari', ['kat' => $produk->getSubkategori->id])}}">
                                                        {{$produk->getSubkategori->nama}}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product-meta">
                                        <div id="tabs-default" class="tabs-default">
                                            <ul class="title-tabs none-style">
                                                <li><a href="#tab-deskripsi"> DETAIL PRODUK</a></li>
                                                <li><a href="#tab-ulasan"> ULASAN ({{count($ulasan)}}) </a></li>
                                            </ul>
                                            <div class="content-tabs">
                                                <div id="tab-deskripsi">{!! $produk->detail !!}</div>
                                                <div id="tab-ulasan">
                                                    @if(count($ulasan) > 0)
                                                        <div class="comment-list">
                                                            <h4>{{count($ulasan)}} KOMENTAR</h4>
                                                            @foreach($ulasan as $row)
                                                                @php
                                                                    $user = $row->getUser;
                                                                    $bio = $user->getBio;
                                                                    $stars = \App\Support\Facades\Rating::stars($row->bintang);
                                                                @endphp
                                                                <div class="comment-item">
                                                                    <img alt="Ava" src="{{$bio->ava != "" ?
                                                                    asset('storage/users/ava/'.$bio->ava) :
                                                                    asset('images/faces/'.rand(1,6).'.jpg')}}">
                                                                    <div class="box-info">
                                                                        <div class="meta">
                                                                            <strong>{{$user->name}}</strong> –
                                                                            {{\Carbon\Carbon::parse($row->created_at)->formatLocalized('%d %B %Y')}}
                                                                            <div class="rating">{!! $stars !!}</div>
                                                                        </div>
                                                                        <div class="text">
                                                                            <p>{{$row->deskripsi}}</p>
                                                                            @if(!is_null($row->gambar))
                                                                                <div class="gallery">
                                                                                    <div class="full float-none m-0">
                                                                                        <img class="galeri" alt=""
                                                                                             src="{{asset('storage/produk/ulasan/'.$row->gambar)}}">
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                    <div class="review">
                                                        <h4>TULIS ULASAN</h4>
                                                        <div class="rating">
                                                            {!! \App\Support\Facades\Rating::stars(5) !!}
                                                        </div>
                                                        <form id="form-ulasan" action="#" class="comment-form">
                                                            <div class="row-comment">
                                                                <p class="col-6 comment-form-author">
                                                                    <input id="author" name="author" type="text"
                                                                           value="" placeholder="your name">
                                                                </p>
                                                                <p class="col-6 comment-form-email">
                                                                    <input id="email" name="email" type="email" value=""
                                                                           placeholder="your email">
                                                                </p>
                                                            </div>
                                                            <p class="comment-form-comment">
                                                                <textarea id="comment" name="comment"
                                                                          placeholder="your review..."></textarea>
                                                            </p>
                                                            <p class="form-submit">
                                                                <input name="submit" type="submit" id="submit"
                                                                       class="submit btn btn-color" value="submit">
                                                            </p>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="pro-related">
                                    <h4>PRODUK TERKAIT</h4>
                                    <div id="product-owl" class="pro-slider">
                                        @foreach($related as $row)
                                            @php
                                                $ulasan = $row->getUlasan;
                                                $stars = \App\Support\Facades\Rating::stars($ulasan->avg('bintang'));
                                            @endphp
                                            <div class="item-product">
                                                <div class="product-thumb">
                                                    <div class="midd">
                                                        <a href="{{route('produk', ['produk' => $row->permalink])}}">
                                                            <img src="{{asset('storage/produk/thumb/'.$row->gambar)}}"
                                                                 alt="">
                                                        </a>
                                                    </div>
                                                </div>
                                                @if($row->is_diskon == true)
                                                    <div class="new">
                                                        <p>-{{$row->diskon}}%</p>
                                                    </div>
                                                @endif
                                                <div class="info-product">
                                                    <h4><a href="{{route('produk', ['produk' => $row->permalink])}}">
                                                            {{$row->nama}}</a></h4>
                                                    <div class="rating">{!! $stars !!}</div>
                                                    @if($row->is_diskon == true)
                                                        <p class="price mb-0">
                                                            Rp{{number_format($row->harga_diskon,2,',','.')}}</p>
                                                        <span class="old-price">
                                                            Rp{{number_format($row->harga,2,',','.')}}</span>
                                                    @else
                                                        <p class="price mb-0">
                                                            Rp{{number_format($row->harga,2,',','.')}}</p>
                                                    @endif
                                                    <div class="add-cart mt-3">
                                                        <a href="javascript:void(0)" class="related-btn btn_cart"
                                                           data-name="{{$row->nama}}"
                                                           data-cek="{{route('produk.cek.cart', ['produk' => $row->permalink])}}"
                                                           data-add="{{route('produk.add.cart', ['produk' => $row->permalink])}}">
                                                            Tambah ke Cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
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
    <script type="text/javascript" src="{{asset('js/jquery.responsiveTabs.js')}}"></script>
    <script>
        $(function () {
            $(".previews .varian:first-child").addClass('selected');

            $('#tabs-default').responsiveTabs({
                startCollapsed: 'accordion'
            });

            $("#img-preview").owlCarousel({
                navigation: false,
                slideSpeed: 600,
                autoPlay: 7000,
                singleItem: true,
                pagination: true,
                navigationText: [
                    "<i class='fa fa-caret-left'></i>",
                    "<i class='fa fa-caret-right'></i>"
                ],
            });

            $("#product-owl").owlCarousel({
                navigation: false,
                navigationText: ["<i class='fa fa-caret-left'></i>", "<i class='fa fa-caret-right'></i>"],
                slideSpeed: 600,
                autoPlay: 8000,
                items: 4,
                itemsDesktop: [1199, 2],
                itemsDesktopSmall: [979, 2],
                itemsTablet: [768, 2],
                itemsMobile: [479, 1],
                pagination: false
            });
        });

        $("#form-beli input[name=qty]").on('keyup', function () {
            var el = $(this);
            if (!el.val() || el.val() == "" || parseInt(el.val()) <= 0) {
                el.val(1);
            }

            @auth
            $.get("{{route('produk.cek.cart', ['produk' => $produk->permalink])}}", function (data) {
                if (data.status == true) {
                    el.attr('max', data.stock);
                    if (parseInt(el.val()) > data.stock) {
                        el.val(data.stock);
                    }
                } else {
                    swal('PERHATIAN!', data.message, 'warning');
                }
            });
            @else
            if (parseInt(el.val()) > parseInt('{{$produk->stock}}')) {
                el.val(parseInt('{{$produk->stock}}'));
            }
            @endauth
        });

        $("#form-beli").on('submit', function (e) {
            e.preventDefault();
            @auth
            swal({
                title: "Tambah ke Cart",
                text: "Apakah Anda yakin untuk menambahkan produk {{$produk->nama}} ke dalam cart Anda?",
                icon: 'warning',
                dangerMode: true,
                buttons: ["Tidak", "Ya"],
                closeOnEsc: false,
                closeOnClickOutside: false,
            }).then((confirm) => {
                if (confirm) {
                    $(this)[0].submit();
                }
            });
            @elseauth('admin')
            swal('PERHATIAN!', 'Fitur ini hanya berfungsi ketika Anda masuk sebagai Pelanggan.', 'warning');
            @else
            openLoginModal();
            @endauth
        });

        $(".btn_wishlist").on("click", function () {
                @auth
            var route = $(this).data('add');

            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.get($(this).data('cek'), function (data) {
                    if (data.status == true) {
                        $.ajax({
                            url: route,
                            type: 'post',
                            data: {_token: '{{csrf_token()}}'},
                            success: function (data) {
                                if (data.status == true) {
                                    $(".btn_wishlist").prop('disabled', true);
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
        });

        $(".btn_cart").on("click", function () {
            var name = $(this).data('name'), cek_uri = $(this).data('cek'), add_uri = $(this).data('add');

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
                                el.parent().find('.text-danger').remove();

                                if (parseInt(el.val()) > data.stock) {
                                    el.parent().append("<p class='text-danger'>Tersedia: <b>" + data.stock + "</b> pcs</p>");
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
        });

        function ulasan() {
            $("#tabs-default ul li:nth-child(2)").find('a').click();
            $('html,body').animate({scrollTop: $(".pro-details").offset().top}, 500);
        }
    </script>
@endpush
