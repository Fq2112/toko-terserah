@extends('layouts.mst')
@section('title', 'Sunting Profil: '.$user->name.' | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('css/card.css')}}">
    <link rel="stylesheet" href="{{asset('css/gmaps.css')}}">
    <style>
        blockquote {
            background: unset;
            border-color: unset;
            color: unset;
        }

        .has-feedback .form-control-feedback {
            width: 36px;
            height: 36px;
            line-height: 36px;
        }

        .image-upload > input {
            display: none;
        }

        .image-upload label {
            cursor: pointer;
            width: 100%;
        }
    </style>
@endpush
@section('content')
    <div class="breadcrumbs" style="background-image: url('{{$bio->background != null ?
    asset('storage/users/background/'.$bio->background) : asset('images/page-header/users.jpg')}}')">
        <div class="breadcrumbs-overlay"></div>
        <div class="page-title">
            <h2>Sunting Profil</h2>
            <p>Di sini Anda dapat mengatur avatar dan latar belakang profil Anda, data personal dan juga daftar alamat
                Anda.</p>
        </div>
        <ul class="crumb">
            <li><a href="{{route('beranda')}}"><i class="fa fa-home"></i></a></li>
            <li style="text-transform: none"><i class="fa fa-angle-double-right"></i>
                <a href="{{URL::current()}}">Akun</a></li>
            <li><a href="#" onclick="goToAnchor()"><i class="fa fa-angle-double-right"></i> Sunting Profil</a></li>
        </ul>
    </div>

    <section class="none-margin" style="padding: 40px 0 40px 0">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-5 col-sm-12 text-center">
                    <div class="card">
                        <form class="form-horizontal" role="form" method="POST" id="form-ava"
                              enctype="multipart/form-data">
                            @csrf
                            {{ method_field('put') }}
                            <div class="img-card image-upload">
                                <label for="file-input">
                                    <img style="width: 100%" class="show_ava" alt="Avatar" src="{{$bio->ava
                                    == "" ? asset('images/faces/'.rand(1,6).'.jpg') :
                                    asset('storage/users/ava/'.$bio->ava)}}" data-placement="bottom"
                                         data-toggle="tooltip" title="Klik disini untuk mengubah avatar Anda!">
                                </label>
                                <input id="file-input" name="ava" type="file" accept="image/*">
                                <div id="progress-upload">
                                    <div class="progress-bar progress-bar-info progress-bar-striped active"
                                         role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                         aria-valuemax="100" style="background-color: #5bb300;z-index: 20">
                                    </div>
                                </div>
                            </div>
                        </form>

                        <form class="form-horizontal mb-0" role="form" method="POST" id="form-personal"
                              action="{{route('user.update.profil')}}">
                            @csrf
                            {{ method_field('put') }}
                            <div class="card-content">
                                <div class="card-title text-center">
                                    <h4 class="aj_name" style="color: #5bb300">{{$user->name}}</h4>
                                    <h5 class="show_username" style="text-transform: none">{{$user->username}}</h5>
                                </div>
                                <div class="card-title">
                                    <div class="row">
                                        <div class="col-lg-12 text-right">
                                            <small style="font-weight: 600">
                                                <span id="show_personal_settings" class="float-right"
                                                      style="cursor: pointer;color: #f89406">
                                                    <i class="fa fa-edit mr-2"></i>PERSONAL</span>
                                                <span id="hide_personal_settings" class="float-right"
                                                      style="color: #dc3545;cursor: pointer;display:none">
                                                    <i class="fa fa-undo mr-2"></i>BATAL</span>
                                            </small>
                                        </div>
                                    </div>
                                    <table class="stats_personal m-0" style="font-size: 14px">
                                        <tr data-toggle="tooltip" data-placement="right" title="Jenis Kelamin">
                                            <td><i class="fa fa-transgender"></i></td>
                                            <td>&nbsp;</td>
                                            <td>{{$bio->gender != "" ? ucfirst($bio->gender) : '(kosong)'}}</td>
                                        </tr>
                                        <tr data-toggle="tooltip" data-placement="right" title="Tanggal Lahir">
                                            <td><i class="fa fa-birthday-cake"></i></td>
                                            <td>&nbsp;</td>
                                            <td>{{$bio->dob != "" ? \Carbon\Carbon::parse($bio->dob)->format('j F Y') : '(kosong)'}}</td>
                                        </tr>
                                        <tr data-toggle="tooltip" data-placement="right" title="Telepon">
                                            <td><i class="fa fa-phone fa-flip-horizontal"></i></td>
                                            <td>&nbsp;</td>
                                            <td>{{$bio->phone != "" ? $bio->phone : '(kosong)'}}</td>
                                        </tr>
                                        <tr data-toggle="tooltip" data-placement="right" title="Alamat Utama">
                                            <td><i class="fa fa-map-marked-alt"></i></td>
                                            <td>&nbsp;</td>
                                            <td>{{$address != "" ? $address->alamat.' - '.$address->kode_pos.' ('.$address->getOccupancy->name.').' : '(kosong)'}}</td>
                                        </tr>
                                    </table>
                                    <hr class="stats_personal" style="margin: 10px 0">
                                    <table class="stats_personal m-0" style="font-size: 14px">
                                        <tr data-toggle="tooltip" data-placement="right" title="Bergabung Sejak">
                                            <td><i class="fa fa-calendar-check"></i></td>
                                            <td>&nbsp;</td>
                                            <td>{{$user->created_at->formatLocalized('%d %B %Y')}}</td>
                                        </tr>
                                        <tr data-toggle="tooltip" data-placement="right" title="Update Terakhir">
                                            <td><i class="fa fa-clock"></i></td>
                                            <td>&nbsp;</td>
                                            <td class="text-lowercase">{{$user->updated_at->diffForHumans()}}</td>
                                        </tr>
                                    </table>
                                    <div id="personal_settings" style="display: none">
                                        <div class="row form-group">
                                            <div class="col-lg-12">
                                                <label class="form-control-label" for="name">
                                                    Nama Lengkap <span class="required">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                                    <input id="name" type="text" class="form-control"
                                                           name="name" placeholder="Nama lengkap"
                                                           value="{{$user->name}}" required autofocus>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-12">
                                                <label class="form-control-label" for="gender">
                                                    Jenis Kelamin <span class="required">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-transgender"></i></span>
                                                    <select id="gender" name="gender"
                                                            class="form-control use-select2" required>
                                                        <option></option>
                                                        <option
                                                            value="pria" {{$bio->gender == 'pria' ? 'selected' : ''}}>
                                                            Pria
                                                        </option>
                                                        <option
                                                            value="wanita" {{$bio->gender == 'wanita' ? 'selected' : ''}}>
                                                            Wanita
                                                        </option>
                                                        <option
                                                            value="lainnya" {{$bio->gender == 'lainnya' ? 'selected' : ''}}>
                                                            Lainnya
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-12">
                                                <label class="form-control-label" for="dob">
                                                    Tanggal Lahir <span class="required">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-birthday-cake"></i></span>
                                                    <input id="dob" class="form-control datepicker" name="dob"
                                                           type="text" placeholder="yyyy-mm-dd" maxlength="10"
                                                           value="{{$bio->dob}}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-12">
                                                <label class="form-control-label" for="phone">
                                                    Nomor Telepon <span class="required">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-phone fa-flip-horizontal"></i></span>
                                                    <input placeholder="Nomor telepon"
                                                           type="text" class="form-control" name="phone" required
                                                           onkeypress="return numberOnly(event, false)"
                                                           value="{{$bio->phone != "" ? $bio->phone : ''}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-read-more">
                                <button id="btn_save_personal" class="btn btn-link btn-block" disabled>
                                    <i class="fa fa-user mr-2"></i>SIMPAN PERUBAHAN
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-8 col-md-7 col-sm-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <form role="form" method="POST" id="form-background" enctype="multipart/form-data">
                                    @csrf
                                    {{ method_field('put') }}
                                    <div class="img-card image-upload">
                                        <label for="input-background">
                                            <img style="width: 100%" class="show_background" alt="Background"
                                                 data-toggle="tooltip" data-placement="bottom"
                                                 title="Klik disini untuk mengubah gambar latar belakang Anda!"
                                                 src="{{$bio->background != null ?
                                                 asset('storage/users/background/'.$bio->background) :
                                                 asset('images/page-header/users.jpg')}}">
                                        </label>
                                        <input id="input-background" name="background" type="file" accept="image/*">
                                        <div id="progress-upload2">
                                            <div class="progress-bar progress-bar-info progress-bar-striped active"
                                                 role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                 aria-valuemax="100" style="background-color: #5bb300;z-index: 20">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="card-content">
                                    <div class="card-title">
                                        <small id="show_background_settings">
                                            Latar Belakang
                                            <span class="pull-right" style="cursor: pointer; color: #f89406">
                                                <i class="fa fa-edit"></i>&nbsp;SUNTING</span>
                                        </small>
                                        <hr class="mt-0">
                                        <blockquote style="text-transform: none">
                                            <table style="font-size: 14px; margin-top: 0">
                                                <tr>
                                                    <td><i class="fa fa-image"></i></td>
                                                    <td id="show_background_name">
                                                        &nbsp;{{$bio->background != "" ? $bio->background : '(kosong)'}}
                                                    </td>
                                                </tr>
                                            </table>
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <form class="form-horizontal mb-0" role="form" method="POST" id="form-address"
                                      action="{{route('user.profil-alamat.create')}}">
                                    @csrf
                                    <input id="method" type="hidden" name="_method">
                                    <input id="lat" type="hidden" name="lat">
                                    <input id="long" type="hidden" name="long">
                                    <div class="card-content">
                                        <div class="card-title">
                                            <small style="font-weight: 600">
                                                Daftar Alamat
                                                <span id="show_address_settings" class="float-right"
                                                      style="cursor: pointer;color: #5bb300">
                                                <i class="fa fa-map-marked-alt mr-2"></i>TAMBAH</span>
                                                <span id="hide_address_settings" class="float-right"
                                                      style="color: #dc3545;cursor: pointer;display:none">
                                                <i class="fa fa-undo mr-2"></i>BATAL</span>
                                            </small>
                                            <hr class="mt-0">
                                            <div class="mt-0 stats_address" style="font-size: 14px;">
                                                @if(count($addresses) > 0)
                                                    @foreach($addresses as $row)
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="media">
                                                                    <div class="media-left media-middle"
                                                                         style="width: 20%">
                                                                        <img class="media-object" alt="icon"
                                                                             src="{{asset('images/icons/occupancy/'.$row->getOccupancy->image)}}">
                                                                    </div>
                                                                    <div class="ml-2 media-body">
                                                                        <h5 class="mt-0 mb-1">
                                                                            <i class="fa fa-building mr-2"></i>{{$row->getOccupancy->name}}
                                                                            {!! $row->isUtama == false ? '' :
                                                                            '<span style="font-weight: 500;color: unset">[Alamat Utama]</span>'!!}
                                                                            <span class="float-right">
                                                                            <a style="color: #f89406;cursor: pointer;"
                                                                               onclick="editAddress('{{$row->nama}}',
                                                                                   '{{$row->telp}}','{{$row->lat}}',
                                                                                   '{{$row->long}}','{{$row->kota_id}}',
                                                                                   '{{$row->alamat}}','{{$row->kode_pos}}',
                                                                                   '{{$row->getOccupancy->id}}',
                                                                                   '{{$row->getOccupancy->name}}',
                                                                                   '{{$row->isUtama}}','{{route('user.profil-alamat.update', ['id' => $row->id])}}')">
                                                                                SUNTING<i class="fa fa-edit ml-2"></i>
                                                                            </a>
                                                                            <small style="color: #7f7f7f">&nbsp;&#124;&nbsp;</small>
                                                                            <a style="color: #dc3545;cursor: pointer;"
                                                                               onclick="deleteAddress('{{$row->isUtama}}',
                                                                                   '{{$row->getOccupancy->name}}','{{$row->alamat}}',
                                                                                   '{{route('user.profil-alamat.delete', ['id' => $row->id])}}')">
                                                                                <i class="fa fa-eraser mr-2"></i>HAPUS
                                                                            </a>
                                                                        </span>
                                                                        </h5>
                                                                        <blockquote class="mb-0"
                                                                                    style="font-size: 14px;text-transform: none">
                                                                            <table class="m-0" style="font-size: 14px">
                                                                                <tr data-toggle="tooltip"
                                                                                    data-placement="left"
                                                                                    title="Nama Lengkap">
                                                                                    <td><i class="fa fa-id-card"></i>
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
                                                                                    <td><i class="fa fa-city"></i></td>
                                                                                    <td>&nbsp;</td>
                                                                                    <td>{{$row->getKota->getProvinsi->nama.
                                                                                ', '.$row->getKota->nama}}</td>
                                                                                </tr>
                                                                                <tr data-toggle="tooltip"
                                                                                    data-placement="left"
                                                                                    title="Alamat">
                                                                                    <td>
                                                                                        <i class="fa fa-map-marker-alt"></i>
                                                                                    </td>
                                                                                    <td>&nbsp;</td>
                                                                                    <td>{{$row->alamat.' - '.
                                                                                $row->kode_pos}}</td>
                                                                                </tr>
                                                                            </table>
                                                                        </blockquote>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr class="mt-3">
                                                    @endforeach
                                                @else
                                                    <p class="mb-0 text-justify">Mohon untuk menambahkan alamat agar
                                                        mempermudah proses pemesanan Anda.</p>
                                                @endif
                                            </div>
                                            <div id="address_settings" style="display: none">
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
                                                                    Simpan Alamat Sebagai <span
                                                                        class="required">*</span>
                                                                </label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-building"></i></span>
                                                                    <select id="occupancy_id" name="occupancy_id"
                                                                            class="form-control use-select2" required>
                                                                        <option></option>
                                                                        @foreach($occupancy as $row)
                                                                            <option
                                                                                value="{{$row->id}}">{{$row->name}}</option>
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
                                        </div>
                                    </div>
                                    <div class="card-read-more">
                                        <button id="btn_save_address" class="btn btn-link btn-block" disabled>
                                            <i class="fa fa-map-marked-alt mr-2"></i>SIMPAN PERUBAHAN
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIljHbKjgtTrpZhEiHum734tF1tolxI68&libraries=geometry,places"></script>
    <script>
        $(function () {
            $(".stats_address hr:last-child").remove();

            @if($check == 'false')
            swal({
                title: "PERHATIAN!",
                text: "Sebelum Anda mulai berbelanja, silahkan lengkapi profil Anda terlebih dahulu.",
                icon: 'warning',
                closeOnEsc: false,
                closeOnClickOutside: false,
            }).then((confirm) => {
                if (confirm) {
                    $('html,body').animate({scrollTop: $("#form-ava").offset().top}, 500);
                }
            });
            @endif
        });

        var google, myLatlng, geocoder, map, marker, infoWindow;

        function init(lat, long) {
            geocoder = new google.maps.Geocoder();
            myLatlng = new google.maps.LatLng(lat, long);

            var mapOptions = {
                zoom: 15,
                center: myLatlng,
                scrollwheel: true,
            }, mapElement = document.getElementById('map');

            map = new google.maps.Map(mapElement, mapOptions);

            marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                draggable: true,
                icon: '{{asset('images/pin.png')}}',
                anchorPoint: new google.maps.Point(0, -29)
            });

            infoWindow = new google.maps.InfoWindow({
                maxWidth: 350,
                content:
                    '<div id="iw-container">' +
                    '<div class="iw-title">Alamat</div>' +
                    '<div class="iw-content">' +
                    '<div class="iw-subTitle">Silahkan tentukan alamat Anda terlebih dahulu.</div>' +
                    '<img src="{{asset('images/searchPlace.png')}}">' +
                    '</div><div class="iw-bottom-gradient"></div></div>'
            });

            marker.addListener('click', function () {
                infoWindow.open(map, marker);
            });

            google.maps.event.addListener(map, 'click', function () {
                infoWindow.close();
            });

            google.maps.event.addListener(marker, "dragend", function (event) {
                geocodePosition(marker.getPosition());
                $("#lat").val(event.latLng.lat());
                $("#long").val(event.latLng.lng());
            });

            var autocomplete = new google.maps.places.Autocomplete(document.getElementById('address_map'));

            autocomplete.bindTo('bounds', map);

            autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

            autocomplete.addListener('place_changed', function () {
                marker.setVisible(false);

                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    window.alert("Tidak tersedia detail untuk input: '" + place.name + "'");
                    return;
                }

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }

                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                for (var i = 0; i < place.address_components.length; i++) {
                    for (var j = 0; j < place.address_components[i].types.length; j++) {
                        if (place.address_components[i].types[j] == "postal_code") {
                            $("#postal_code").val(place.address_components[i].long_name);
                        }
                    }
                }

                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }

                infoWindow.setContent(
                    '<div id="iw-container">' +
                    '<div class="iw-title">Alamat</div>' +
                    '<div class="iw-content">' +
                    '<div class="iw-subTitle" style="text-transform: none">' + place.name + '</div>' +
                    '<img src="{{asset('images/searchPlace.png')}}">' +
                    '<p>' + address + '</p>' +
                    '</div><div class="iw-bottom-gradient"></div></div>'
                );
                infoWindow.open(map, marker);
                $("#lat").val(place.geometry.location.lat());
                $("#long").val(place.geometry.location.lng());

                google.maps.event.addListener(infoWindow, 'domready', function () {
                    var iwOuter = $('.gm-style-iw');
                    var iwBackground = iwOuter.prev();

                    iwBackground.children(':nth-child(2)').css({'display': 'none'});
                    iwBackground.children(':nth-child(4)').css({'display': 'none'});

                    iwOuter.css({left: '5px', top: '1px'});
                    iwOuter.parent().parent().css({left: '0'});

                    iwBackground.children(':nth-child(1)').attr('style', function (i, s) {
                        return s + 'left: -39px !important;'
                    });

                    iwBackground.children(':nth-child(3)').attr('style', function (i, s) {
                        return s + 'left: -39px !important;'
                    });

                    iwBackground.children(':nth-child(3)').find('div').children().css({
                        'box-shadow': 'rgba(72, 181, 233, 0.6) 0 1px 6px',
                        'z-index': '1'
                    });

                    var iwCloseBtn = iwOuter.next();
                    iwCloseBtn.css({
                        background: '#fff',
                        opacity: '1',
                        width: '30px',
                        height: '30px',
                        right: '15px',
                        top: '6px',
                        border: '6px solid #48b5e9',
                        'border-radius': '50%',
                        'box-shadow': '0 0 5px #3990B9'
                    });

                    if ($('.iw-content').height() < 140) {
                        $('.iw-bottom-gradient').css({display: 'none'});
                    }

                    iwCloseBtn.mouseout(function () {
                        $(this).css({opacity: '1'});
                    });
                });
            });
        }

        function geocodePosition(pos) {
            geocoder.geocode({
                latLng: pos
            }, function (responses) {
                if (responses && responses.length > 0) {
                    marker.formatted_address = responses[0].formatted_address;
                } else {
                    marker.formatted_address = 'Tidak dapat menentukan alamat di lokasi ini.';
                }

                for (var i = 0; i < responses[0].address_components.length; i++) {
                    for (var j = 0; j < responses[0].address_components[i].types.length; j++) {
                        if (responses[0].address_components[i].types[j] == "postal_code") {
                            $("#postal_code").val(responses[0].address_components[i].long_name);
                        }
                    }
                }

                infoWindow.setContent(
                    '<div id="iw-container">' +
                    '<div class="iw-title">Alamat</div>' +
                    '<div class="iw-content">' +
                    '<div class="iw-subTitle" style="text-transform: none">' + marker.formatted_address + '</div>' +
                    '<img src="{{asset('images/searchPlace.png')}}">' +
                    '</div><div class="iw-bottom-gradient"></div></div>'
                );
                infoWindow.open(map, marker);
                $("#address_map").val(marker.formatted_address);
            });
        }

        $("#show_personal_settings").on('click', function () {
            $(this).toggle(300);
            $("#hide_personal_settings").toggle(300);

            resetterPersonal();

            $('html,body').animate({scrollTop: $("#form-personal").offset().top}, 500);
        });

        $("#hide_personal_settings").on('click', function () {
            $(this).toggle(300);
            $("#show_personal_settings").toggle(300);

            resetterPersonal();
        });

        function resetterPersonal() {
            $("#personal_settings").toggle(300);
            $(".stats_personal").toggle(300);

            if ($("#btn_save_personal").attr('disabled')) {
                $("#btn_save_personal").removeAttr('disabled');
            } else {
                $("#btn_save_personal").attr('disabled', 'disabled');
            }
        }

        $("#show_background_settings").on('click', function () {
            $("#input-background").trigger('click');
            $('html,body').animate({scrollTop: $("#form-background").offset().top}, 500);
        });

        $("#show_address_settings").on('click', function () {
            $(this).toggle(300);
            $("#hide_address_settings").toggle(300);

            resetterAddress();

            $('html,body').animate({scrollTop: $("#form-address").parent().parent().parent().offset().top}, 500);
        });

        $("#hide_address_settings").on('click', function () {
            $(this).toggle(300);
            $("#show_address_settings").toggle(300);

            resetterAddress();
        });

        function resetterAddress() {
            $("#address_settings").toggle(300);
            $(".stats_address").toggle(300);

            init(-7.2819551, 112.6569592);
            infoWindow.setContent(
                '<div id="iw-container">' +
                '<div class="iw-title">Alamat</div>' +
                '<div class="iw-content">' +
                '<div class="iw-subTitle">Silahkan tentukan alamat Anda terlebih dahulu.</div>' +
                '<img src="{{asset('images/searchPlace.png')}}">' +
                '</div><div class="iw-bottom-gradient"></div></div>'
            );
            infoWindow.open(map, marker);

            $("#method, #lat, #long, #address_name, #address_phone, #address_map, #postal_code").val(null);
            $("#kota_id, #occupancy_id").val(null).trigger('change');
            $("#form-address").attr('action', '{{route('user.profil-alamat.create')}}');
            $("#isUtama").prop('checked', false);

            if ($("#btn_save_address").attr('disabled')) {
                $("#btn_save_address").removeAttr('disabled');
            } else {
                $("#btn_save_address").attr('disabled', 'disabled');
            }
        }

        function editAddress(name, phone, lat, long, kota_id, address, postal_code, occupancy_id, occupancy, isUtama, url) {
            var main_str = isUtama == 1 ? ' <span class="font-weight-normal">[Alamat Utama]</span>' : '';

            $("#show_address_settings").hide();
            $("#hide_address_settings").show();
            $("#address_settings").toggle(300);
            $(".stats_address").toggle(300);

            init(lat, long);
            infoWindow.setContent(
                '<div id="iw-container">' +
                '<div class="iw-title">Alamat</div>' +
                '<div class="iw-content">' +
                '<div class="iw-subTitle" style="text-transform: none">' + occupancy + main_str + '</div>' +
                '<img src="{{asset('images/searchPlace.png')}}">' +
                '<p>' + address + '</p>' +
                '</div><div class="iw-bottom-gradient"></div></div>'
            );
            infoWindow.open(map, marker);

            $("#address_name").val(name);
            $("#address_phone").val(phone);
            $("#address_map").val(address);
            $("#postal_code").val(postal_code);
            $("#kota_id").val(kota_id).trigger('change');
            $("#occupancy_id").val(occupancy_id).trigger('change');
            if (isUtama == 1) {
                $("#isUtama").prop('checked', true);
            } else {
                $("#isUtama").prop('checked', false);
            }

            $("#method").val('PUT');
            $("#lat").val(lat);
            $("#long").val(long);
            $("#form-address").attr('action', url);

            if ($("#btn_save_address").attr('disabled')) {
                $("#btn_save_address").removeAttr('disabled');
            } else {
                $("#btn_save_address").attr('disabled', 'disabled');
            }

            $('html,body').animate({scrollTop: $("#form-address").parent().parent().parent().offset().top}, 500);
        }

        function deleteAddress(isUtama, occupancy, address, url) {
            if (isUtama == 1) {
                swal('PERHATIAN!', 'Anda tidak diizinkan menghapus alamat utama Anda! Jika Anda tetap ingin menghapusnya, silahkan buat alamat baru dan jadikan sebagai alamat utama Anda terlebih dahulu.', 'warning');
            } else {
                swal({
                    title: 'Hapus Alamat "' + occupancy + '"',
                    text: 'Apakah Anda yakin untuk menghapus alamat ini "' + address + '"? Anda tidak dapat mengembalikannya!',
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
        }

        document.getElementById("file-input").onchange = function () {
            var files_size = this.files[0].size,
                max_file_size = 2000000, allowed_file_types = ['image/png', 'image/gif', 'image/jpeg', 'image/pjpeg'],
                file_name = $(this).val().replace(/C:\\fakepath\\/i, ''),
                progress_bar_id = $("#progress-upload .progress-bar");

            if (!window.File && window.FileReader && window.FileList && window.Blob) {
                swal('PERHATIAN!', "Browser yang Anda gunakan tidak support! Silahkan perbarui atau gunakan browser yang lainnya.", 'warning');

            } else {
                if (files_size > max_file_size) {
                    swal('ERROR!', "Ukuran total " + file_name + " adalah " + humanFileSize(files_size) +
                        ", ukuran file yang diperbolehkan adalah " + humanFileSize(max_file_size) +
                        ", coba unggah file yang ukurannya lebih kecil!", 'error');

                } else {
                    $(this.files).each(function (i, ifile) {
                        if (ifile.value !== "") {
                            if (allowed_file_types.indexOf(ifile.type) === -1) {
                                swal('ERROR!', "Tipe file " + file_name + " tidak support!", 'error');

                            } else {
                                $.ajax({
                                    type: 'POST',
                                    url: '{{route('user.update.pengaturan')}}',
                                    data: new FormData($("#form-ava")[0]),
                                    contentType: false,
                                    processData: false,
                                    mimeType: "multipart/form-data",
                                    xhr: function () {
                                        var xhr = $.ajaxSettings.xhr();
                                        if (xhr.upload) {
                                            xhr.upload.addEventListener('progress', function (event) {
                                                var percent = 0;
                                                var position = event.loaded || event.position;
                                                var total = event.total;
                                                if (event.lengthComputable) {
                                                    percent = Math.ceil(position / total * 100);
                                                }
                                                //update progressbar
                                                $("#progress-upload").css("display", "block");
                                                progress_bar_id.css("width", +percent + "%");
                                                progress_bar_id.text(percent + "%");
                                                if (percent == 100) {
                                                    progress_bar_id.removeClass("progress-bar-info");
                                                    progress_bar_id.addClass("progress-bar");
                                                } else {
                                                    progress_bar_id.removeClass("progress-bar");
                                                    progress_bar_id.addClass("progress-bar-info");
                                                }
                                            }, true);
                                        }
                                        return xhr;
                                    },
                                    success: function (data) {
                                        $(".show_ava").attr('src', data);
                                        swal('SUKSES!', 'Avatar Anda berhasil diperbarui!', 'success');
                                        $("#progress-upload").css("display", "none");
                                    },
                                    error: function () {
                                        swal('Oops...', 'Terjadi suatu kesalahan!  Silahkan segarkan browser Anda.', 'error');
                                    }
                                });
                                return false;
                            }
                        } else {
                            swal('Oops...', 'Tidak ada file yang dipilih!', 'error');
                        }
                    });
                }
            }
        };

        document.getElementById("input-background").onchange = function () {
            var files_size = this.files[0].size,
                max_file_size = 2000000, allowed_file_types = ['image/png', 'image/gif', 'image/jpeg', 'image/pjpeg'],
                file_name = $(this).val().replace(/C:\\fakepath\\/i, ''),
                progress_bar_id = $("#progress-upload2 .progress-bar");

            if (!window.File && window.FileReader && window.FileList && window.Blob) {
                swal('PERHATIAN!', "Browser yang Anda gunakan tidak support! Silahkan perbarui atau gunakan browser yang lainnya.", 'warning');

            } else {
                if (files_size > max_file_size) {
                    swal('ERROR!', "Ukuran total " + file_name + " adalah " + humanFileSize(files_size) +
                        ", ukuran file yang diperbolehkan adalah " + humanFileSize(max_file_size) +
                        ", coba unggah file yang ukurannya lebih kecil!", 'error');

                } else {
                    $(this.files).each(function (i, ifile) {
                        if (ifile.value !== "") {
                            if (allowed_file_types.indexOf(ifile.type) === -1) {
                                swal('ERROR!', "Tipe file " + file_name + " tidak support!", 'error');

                            } else {
                                $.ajax({
                                    type: 'POST',
                                    url: '{{route('user.update.pengaturan')}}',
                                    data: new FormData($("#form-background")[0]),
                                    contentType: false,
                                    processData: false,
                                    mimeType: "multipart/form-data",
                                    xhr: function () {
                                        var xhr = $.ajaxSettings.xhr();
                                        if (xhr.upload) {
                                            xhr.upload.addEventListener('progress', function (event) {
                                                var percent = 0;
                                                var position = event.loaded || event.position;
                                                var total = event.total;
                                                if (event.lengthComputable) {
                                                    percent = Math.ceil(position / total * 100);
                                                }
                                                //update progressbar
                                                $("#progress-upload2").css("display", "block");
                                                progress_bar_id.css("width", +percent + "%");
                                                progress_bar_id.text(percent + "%");
                                                if (percent == 100) {
                                                    progress_bar_id.removeClass("progress-bar-info");
                                                    progress_bar_id.addClass("progress-bar");
                                                } else {
                                                    progress_bar_id.removeClass("progress-bar");
                                                    progress_bar_id.addClass("progress-bar-info");
                                                }
                                            }, true);
                                        }
                                        return xhr;
                                    },
                                    success: function (data) {
                                        $(".breadcrumbs").css('background-image', 'url("{{asset('storage/users/background')}}/' + data + '")');
                                        $(".show_background").attr('src', '{{asset('storage/users/background')}}/' + data);
                                        $("#show_background_name").html("&nbsp;" + data);

                                        swal('SUKSES!', 'Latar belakang profil Anda berhasil diperbarui!', 'success');
                                        $("#progress-upload2").css("display", "none");
                                    },
                                    error: function () {
                                        swal('Oops...', 'Terjadi suatu kesalahan!  Silahkan segarkan browser Anda.', 'error');
                                    }
                                });
                                return false;
                            }
                        } else {
                            swal('Oops...', 'Tidak ada file yang dipilih!', 'error');
                        }
                    });
                }
            }
        };

        function humanFileSize(size) {
            var i = Math.floor(Math.log(size) / Math.log(1024));
            return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
        }

        function goToAnchor() {
            $('html,body').animate({scrollTop: $(".crumb").offset().top}, 500);
        }
    </script>
@endpush
