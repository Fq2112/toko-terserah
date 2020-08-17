@extends('layouts.mst')
@section('title', $produk->nama.' | '.env('APP_TITLE'))
@push('styles')
    <style>
        .single-price s {
            text-decoration: line-through;
            color: #aaa !important;
            padding-left: 5px;
            font-size: 20px;
        }

        .single-price span {
            color: #555 !important;
        }

        span.old-price {
            text-decoration: line-through;
            color: #aaa !important;
            font-size: 14px;
        }

        #form-beli input[name=qty]:disabled {
            cursor: no-drop;
        }

        #tab-deskripsi ul {
            margin-left: 2rem;
        }

        .tabs-default ul li a span.badge {
            background: #999;
        }

        .tabs-default ul li a:hover span.badge, .tabs-default ul li a.selected span.badge {
            background: #fff;
            color: #5bb300;
            transition: all .3s ease-in-out;
        }

        .rating-input {
            border: none;
            float: left;
        }

        .rating-input > input {
            display: none;
        }

        .rating-input > label:before {
            margin: 0 5px 0 5px;
            font-size: 1.25em;
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            display: inline-block;
            content: "\f005";
        }

        .rating-input > .half:before {
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            content: "\f089";
            position: absolute;
        }

        .rating-input > label {
            color: #ddd;
            float: right;
        }

        .rating-input > input:checked ~ label,
        .rating-input:not(:checked) > label:hover,
        .rating-input:not(:checked) > label:hover ~ label {
            color: #ffc100;
        }

        .rating-input > input:checked + label:hover,
        .rating-input > input:checked ~ label:hover,
        .rating-input > label:hover ~ input:checked ~ label,
        .rating-input > input:checked ~ label:hover ~ label {
            color: #e1a500;
        }

        .gallery.ulasan .full {
            width: 150px;
        }

        .gallery:not(.ulasan) .full {
            width: 400px;
        }

        @media (min-width: 320px) and (max-width: 480px) {
            .gallery:not(.ulasan) .previews, .gallery:not(.ulasan) .full {
                float: none;
            }
        }

        .btn-tags {
            background: #fff;
            text-transform: none;
            color: #333;
            padding: .5em 1em;
            border: 1px solid #e4e4e4;
        }

        .shop-item {
            width: unset;
        }

        ul.list-unstyled li i {
            color: #5bb300 !important;
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
                                            @if($produk->isGrosir == true)
                                                <div class="sale" style="top: 10px;left: unset !important;right: 35px">
                                                    <p style="font-size: 11px">GROSIR</p>
                                                </div>
                                            @endif
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
                                                <span><a href="javascript:ulasan()"><b>{{count($produk->getUlasan)}}</b> ulasan</a></span>
                                                <p>Tersedia: <span
                                                        style="margin-right: 0;color: {{$produk->stock > 0 ? '':'#a94442'}}"><b>{{$produk->stock}}</b> pcs</span>&ensp;|&ensp;Berat:
                                                    <span
                                                        style="color: #f89406"><b>{{number_format($produk->berat / 1000,2,',','.')}}</b> kg</span>
                                                </p>
                                                <p>{{$produk->deskripsi}}</p>
                                                <p class="single-price">
                                                    @if($produk->isGrosir == true)
                                                        @if($produk->isDiskonGrosir == true)
                                                            Rp{{number_format($produk->harga_diskon_grosir,2,',','.')}}
                                                            <s>Rp{{number_format($produk->harga_grosir,2,',','.')}}
                                                                <span
                                                                    class="ml-2">-{{$produk->diskonGrosir}}%</span></s>
                                                        @else
                                                            Rp{{number_format($produk->harga_grosir,2,',','.')}}
                                                        @endif
                                                    @else
                                                        @if($produk->is_diskon == true)
                                                            Rp{{number_format($produk->harga_diskon,2,',','.')}}
                                                            <s>Rp{{number_format($produk->harga,2,',','.')}}
                                                                <span class="ml-2">-{{$produk->diskon}}%</span></s>
                                                        @else
                                                            Rp{{number_format($produk->harga,2,',','.')}}
                                                        @endif
                                                    @endif
                                                </p>
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
                                                                {{!is_null($cek_wishlist) ? 'disabled' : ''}} style="background: transparent !important;color: #5bb300 !important;border: 1px solid #5bb300;">
                                                            <i class="fa fa-heart mr-0" style="font-size: 14px"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="cat">
                                                    Kategori: <b>{{$produk->getSubkategori->getKategori->nama}}</b>,
                                                    <a href="{{route('cari', ['kat' => $produk->getSubkategori->id])}}">
                                                        <b>{{$produk->getSubkategori->nama}}</b></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product-meta">
                                        <div id="tabs-default" class="tabs-default">
                                            <ul class="title-tabs none-style">
                                                <li>
                                                    <a href="#tab-deskripsi">
                                                        <b><i class="fa fa-list-alt mr-2"></i>DETAIL PRODUK</b>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#tab-ulasan">
                                                        <b><i class="fa fa-comment-alt mr-2"></i>ULASAN PRODUK</b>
                                                        <span
                                                            class="badge ml-2">{{count($produk->getUlasan) > 999 ? '999+' : count($produk->getUlasan)}}</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#tab-qna">
                                                        <b><i class="fa fa-comments mr-2"></i>QnA PRODUK</b>
                                                        <span
                                                            class="badge ml-2">{{count($produk->getQnA) > 999 ? '999+' : count($produk->getQnA)}}</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="content-tabs">
                                                <div id="tab-deskripsi">{!! $produk->detail !!}</div>

                                                <div id="tab-ulasan">
                                                    @if(!is_null($cek_ulasan))
                                                        <div class="comment-list">
                                                            <h4>ULASAN SAYA</h4>
                                                            @php
                                                                $user = $cek_ulasan->getUser;
                                                                $bio = $user->getBio;
                                                                $stars = \App\Support\Facades\Rating::stars($cek_ulasan->bintang);
                                                            @endphp
                                                            <div class="comment-item">
                                                                <img alt="Ava" src="{{$bio->ava != "" ?
                                                                    asset('storage/users/ava/'.$bio->ava) :
                                                                    asset('images/faces/'.rand(1,6).'.jpg')}}">
                                                                <div class="box-info">
                                                                    <div class="meta">
                                                                        <strong>{{$user->name}}</strong> –
                                                                        {{\Carbon\Carbon::parse($cek_ulasan->created_at)->diffForHumans()}}
                                                                        <div class="rating">{!! $stars !!}</div>
                                                                    </div>
                                                                    <div class="text">
                                                                        <p>{{$cek_ulasan->deskripsi}}</p>
                                                                        @if(!is_null($cek_ulasan->gambar))
                                                                            <div class="gallery ulasan">
                                                                                <div class="full float-none m-0">
                                                                                    <img class="galeri" alt=""
                                                                                         src="{{asset('storage/produk/ulasan/'.$cek_ulasan->gambar)}}">
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div class="review mb-5">
                                                        <h4>{{!is_null($cek_ulasan) ? 'SUNTING' : 'TULIS'}} ULASAN</h4>
                                                        <form id="form-ulasan" class="comment-form mt-3" method="post"
                                                              action="{{route('produk.submit.ulasan',['produk' => $produk->permalink])}}"
                                                              enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                   value="{{!is_null($cek_ulasan) ? encrypt($cek_ulasan->id) : null}}">
                                                            <fieldset id="rating" class="rating-input mr-3"
                                                                      aria-required="true">
                                                                <input type="radio" id="star5" name="rating" value="5"
                                                                    {{!is_null($cek_ulasan) && $cek_ulasan->bintang == '5' ? 'checked' : ''}}>
                                                                <label class="full" for="star5" data-toggle="tooltip"
                                                                       title="Terbaik"></label>

                                                                <input type="radio" id="star4half" name="rating"
                                                                       value="4.5" {{!is_null($cek_ulasan) && $cek_ulasan->bintang == '4.5' ? 'checked' : ''}}>
                                                                <label class="half" for="star4half"
                                                                       data-toggle="tooltip"
                                                                       title="Keren"></label>

                                                                <input type="radio" id="star4" name="rating"
                                                                       value="4" {{!is_null($cek_ulasan) && $cek_ulasan->bintang == '4' ? 'checked' : ''}}>
                                                                <label class="full" for="star4" data-toggle="tooltip"
                                                                       title="Cukup baik"></label>

                                                                <input type="radio" id="star3half" name="rating"
                                                                       value="3.5" {{!is_null($cek_ulasan) && $cek_ulasan->bintang == '3.5' ? 'checked' : ''}}>
                                                                <label class="half" for="star3half"
                                                                       data-toggle="tooltip"
                                                                       title="Baik"></label>

                                                                <input type="radio" id="star3" name="rating"
                                                                       value="3" {{!is_null($cek_ulasan) && $cek_ulasan->bintang == '3' ? 'checked' : ''}}>
                                                                <label class="full" for="star3" data-toggle="tooltip"
                                                                       title="Standar"></label>

                                                                <input type="radio" id="star2half" name="rating"
                                                                       value="2.5" {{!is_null($cek_ulasan) && $cek_ulasan->bintang == '2.5' ? 'checked' : ''}}>
                                                                <label class="half" for="star2half"
                                                                       data-toggle="tooltip"
                                                                       title="Cukup buruk"></label>

                                                                <input type="radio" id="star2" name="rating"
                                                                       value="2" {{!is_null($cek_ulasan) && $cek_ulasan->bintang == '2' ? 'checked' : ''}}>
                                                                <label class="full" for="star2" data-toggle="tooltip"
                                                                       title="Buruk"></label>

                                                                <input type="radio" id="star1half" name="rating"
                                                                       value="1.5" {{!is_null($cek_ulasan) && $cek_ulasan->bintang == '1.5' ? 'checked' : ''}}>
                                                                <label class="half" for="star1half"
                                                                       data-toggle="tooltip"
                                                                       title="Sangat buruk"></label>

                                                                <input type="radio" id="star1" name="rating"
                                                                       value="1" {{!is_null($cek_ulasan) && $cek_ulasan->bintang == '1' ? 'checked' : ''}}>
                                                                <label class="full" for="star1" data-toggle="tooltip"
                                                                       title="Menyedihkan"></label>

                                                                <input type="radio" id="starhalf" name="rating"
                                                                       value="0.5" {{!is_null($cek_ulasan) && $cek_ulasan->bintang == '0.5' ? 'checked' : ''}}>
                                                                <label class="half" for="starhalf" data-toggle="tooltip"
                                                                       title="Sangat menyedihkan"></label>
                                                            </fieldset>
                                                            <input id="gambar" type="file" name="gambar"
                                                                   accept="image/*">
                                                            <p class="comment-form-comment">
                                                                <textarea id="deskripsi" name="deskripsi" required
                                                                          placeholder="Tulis ulasan Anda di sini..."
                                                                          style="resize: vertical;height: 100px;line-height: unset;padding: 15px">{{!is_null($cek_ulasan) ? $cek_ulasan->deskripsi : null}}</textarea>
                                                            </p>
                                                            <p class="form-submit">
                                                                <button type="submit" class="btn btn-block btn-color2">
                                                                    <i class="fa fa-comment-alt mr-2"></i>
                                                                    <b>{{!is_null($cek_ulasan) ? 'SIMPAN PERUBAHAN' : 'KIRIM ULASAN'}}</b>
                                                                </button>
                                                            </p>
                                                        </form>
                                                    </div>

                                                        @if(count($produk->getUlasan) > 0)
                                                        <div class="comment-list">
                                                            <h4>{{!is_null($cek_ulasan) ? count($produk->getUlasan) - 1 : count($produk->getUlasan)}}
                                                                ULASAN {{!is_null($cek_ulasan) ? 'LAINNYA' : ''}}</h4>
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
                                                                            {{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}
                                                                            <div class="rating">{!! $stars !!}</div>
                                                                        </div>
                                                                        <div class="text">
                                                                            <p>{{$row->deskripsi}}</p>
                                                                            @if(!is_null($row->gambar))
                                                                                <div class="gallery ulasan">
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
                                                </div>

                                                <div id="tab-qna">
                                                    @if(count($qna_ku) > 0)
                                                        <div class="comment-list">
                                                            <h4>{{count($qna_ku)}} PERTANYAAN SAYA</h4>
                                                            @foreach($qna_ku as $row)
                                                                @php
                                                                    $user = $row->getUser;
                                                                    $bio = $user->getBio;
                                                                @endphp
                                                                <div class="comment-item">
                                                                    <img alt="Ava" src="{{$bio->ava != "" ?
                                                                    asset('storage/users/ava/'.$bio->ava) :
                                                                    asset('images/faces/'.rand(1,6).'.jpg')}}">
                                                                    <div class="box-info">
                                                                        <div class="meta">
                                                                            <strong>{{$user->name}}</strong> –
                                                                            {{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}
                                                                        </div>
                                                                        <div class="text">
                                                                            <p>{{$row->tanya}}</p>

                                                                            @if(!is_null($row->jawab))
                                                                                <div class="comment-item mb-0">
                                                                                    <img alt="Logo"
                                                                                         src="{{asset('images/logotype.png')}}">
                                                                                    <div class="box-info">
                                                                                        <div class="meta">
                                                                                            <strong>{{env('APP_NAME')}}</strong>
                                                                                            –
                                                                                            {{\Carbon\Carbon::parse($row->updated_at)->diffForHumans()}}
                                                                                        </div>
                                                                                        <div class="text">
                                                                                            <p>{{$row->jawab}}</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif

                                                    <div class="review mb-5">
                                                        <h4>TULIS PERTANYAAN</h4>
                                                        <form id="form-qna" class="comment-form mt-3" method="post"
                                                              action="{{route('produk.submit.qna',['produk' => $produk->permalink])}}">
                                                            @csrf
                                                            <p class="comment-form-comment">
                                                                <textarea id="tanya" name="tanya" class="mb-3" required
                                                                          placeholder="Tulis pertanyaan Anda di sini..."
                                                                          style="resize: vertical;height: 100px;line-height: unset;padding: 15px"></textarea>
                                                                @foreach($qna_tag as $tag)
                                                                    <button type="button"
                                                                            @if(strlen($tag->pertanyaan) >= 25)
                                                                            data-toggle="tooltip"
                                                                            title="{{$tag->pertanyaan}}"
                                                                            @endif
                                                                            class="btn btn-sm btn-color8 btn-tags"
                                                                            onclick="$('#tanya').val('{{$tag->pertanyaan}}')">
                                                                        {{\Illuminate\Support\Str::limit($tag->pertanyaan,25,'...')}}
                                                                    </button>
                                                                @endforeach
                                                            </p>
                                                            <p class="form-submit">
                                                                <button type="submit" class="btn btn-block btn-color2">
                                                                    <i class="fa fa-comments mr-2"></i>
                                                                    <b>KIRIM PERTANYAAN</b>
                                                                </button>
                                                            </p>
                                                        </form>
                                                    </div>

                                                    @if(count($produk->getQnA) > 0)
                                                        <div class="comment-list">
                                                            <h4>{{count($produk->getQnA) - count($qna_ku)}} PERTANYAAN
                                                                {{count($qna_ku) > 0 ? 'LAINNYA' : ''}}</h4>
                                                            @foreach($qna as $row)
                                                                @php
                                                                    $user = $row->getUser;
                                                                    $bio = $user->getBio;
                                                                @endphp
                                                                <div class="comment-item">
                                                                    <img alt="Ava" src="{{$bio->ava != "" ?
                                                                    asset('storage/users/ava/'.$bio->ava) :
                                                                    asset('images/faces/'.rand(1,6).'.jpg')}}">
                                                                    <div class="box-info">
                                                                        <div class="meta">
                                                                            <strong>{{$user->name}}</strong> –
                                                                            {{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}
                                                                        </div>
                                                                        <div class="text">
                                                                            <p>{{$row->tanya}}</p>

                                                                            @if(!is_null($row->jawab))
                                                                                <div class="comment-item mb-0">
                                                                                    <img alt="Logo"
                                                                                         src="{{asset('images/logotype.png')}}">
                                                                                    <div class="box-info">
                                                                                        <div class="meta">
                                                                                            <strong>{{env('APP_NAME')}}</strong>
                                                                                            –
                                                                                            {{\Carbon\Carbon::parse($row->updated_at)->diffForHumans()}}
                                                                                        </div>
                                                                                        <div class="text">
                                                                                            <p>{{$row->jawab}}</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="pro-related">
                                    <h4>PRODUK TERKAIT</h4>
                                    <div class="shop-owl">
                                        @foreach($related as $row)
                                            @php
                                                $ulasan = $row->getUlasan;
                                                $stars = \App\Support\Facades\Rating::stars_ul($ulasan->avg('bintang'));
                                            @endphp
                                            <div class="shop-item hover effect-10">
                                                <a href="{{route('produk', ['produk' => $row->permalink])}}">
                                                    <img src="{{asset('storage/produk/thumb/'.$row->gambar)}}"
                                                         alt="Thumbnail"></a>
                                                <div class="stars">
                                                    <ul class="list-unstyled">
                                                        {!! $stars !!}
                                                    </ul>
                                                </div>

                                                @if($row->isGrosir == true)
                                                    @if($row->isDiskonGrosir == true)
                                                        <div class="new">
                                                            <p>-{{$row->diskonGrosir}}%</p>
                                                        </div>
                                                    @endif
                                                    <div class="sale"
                                                         style="top: 10px;left: unset !important;right: 10px">
                                                        <p style="font-size: 11px">GROSIR</p>
                                                    </div>
                                                    <div class="info">
                                                        <h4>
                                                            <a href="{{route('produk', ['produk' => $row->permalink])}}">{{$row->nama}}</a>
                                                        </h4>
                                                        <div class="price">
                                                            @if($row->isDiskonGrosir == true)
                                                                <span>Rp{{number_format($row->harga_diskon_grosir,2,',','.')}}</span>
                                                                <br>
                                                                <span
                                                                    class="old-price">Rp{{number_format($row->harga_grosir,2,',','.')}}</span>
                                                            @else
                                                                <span>Rp{{number_format($row->harga_grosir,2,',','.')}}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    @if($row->is_diskon == true)
                                                        <div class="new">
                                                            <p>-{{$row->diskon}}%</p>
                                                        </div>
                                                    @endif
                                                    <div class="info">
                                                        <h4>
                                                            <a href="{{route('produk', ['produk' => $row->permalink])}}">{{$row->nama}}</a>
                                                        </h4>
                                                        <div class="price">
                                                            @if($row->is_diskon == true)
                                                                <span>Rp{{number_format($row->harga_diskon,2,',','.')}}</span>
                                                                <br>
                                                                <span
                                                                    class="old-price">Rp{{number_format($row->harga,2,',','.')}}</span>
                                                            @else
                                                                <span>Rp{{number_format($row->harga,2,',','.')}}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="cart-overlay">
                                                    <a href="javascript:void(0)" class="info btn_cart"
                                                       data-name="{{$row->nama}}"
                                                       data-cek="{{route('produk.cek.cart', ['produk' => $row->permalink])}}"
                                                       data-add="{{route('produk.add.cart', ['produk' => $row->permalink])}}">
                                                        <i class="fa fa-shopping-cart mr-2"></i>Tambah ke Cart</a>
                                                    <p class="icon-links">
                                                        <a href="{{route('produk', ['produk' => $row->permalink])}}">
                                                            <span class="fa fa-search"></span></a>
                                                        <a href="javascript:void(0)" class="info-2 btn_wishlist"
                                                           data-cek="{{route('produk.cek.wishlist', ['produk' => $row->permalink])}}"
                                                           data-add="{{route('produk.add.wishlist', ['produk' => $row->permalink])}}">
                                                            <span class="fa fa-heart"></span></a>
                                                    </p>
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
            $('#tabs-default').responsiveTabs({
                startCollapsed: 'accordion'
            });

            $(".shop-owl").owlCarousel({
                navigation: true,
                navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
                slideSpeed: 600,
                autoPlay: 8000,
                items: 4,
                itemsDesktop: [1199, 3],
                itemsDesktopSmall: [979, 2],
                itemsTablet: [768, 2],
                itemsMobile: [479, 2],
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
        });

        $("#form-ulasan").on('submit', function (e) {
            e.preventDefault();
            @auth
            if (!$('input[name="rating"]:checked').val()) {
                swal('PERHATIAN!', 'Field rating tidak boleh dikosongi!', 'warning');
            } else {
                $(this)[0].submit();
            }
            @elseauth('admin')
            swal('PERHATIAN!', 'Fitur ini hanya berfungsi ketika Anda masuk sebagai Pelanggan.', 'warning');
            @else
            openLoginModal();
            @endauth
        });

        $("#form-qna").on('submit', function (e) {
            e.preventDefault();
            @auth
            $(this)[0].submit();
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
