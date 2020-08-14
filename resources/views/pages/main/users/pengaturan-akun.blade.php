@extends('layouts.mst')
@section('title', 'Pengaturan Akun: '.$user->name.' | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('css/card.css')}}">
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

        @import url('https://fonts.googleapis.com/css?family=Abel');

        .center {
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
        }

        .memberCard {
            font-family: Abel, Arial, Verdana, sans-serif;
            width: 450px;
            height: 250px;
            background: linear-gradient(#f8f8f8, #fff);
            box-shadow: 0 8px 16px -8px rgba(0, 0, 0, 0.4);
            border-radius: 6px;
            overflow: hidden;
            position: relative;
            margin: 1.5rem;
        }

        .memberCard h1 {
            text-align: center;
        }

        .memberCard .additional {
            position: absolute;
            width: 150px;
            height: 100%;
            background: linear-gradient(#03a678, #00b16a);
            transition: width 0.4s;
            overflow: hidden;
            z-index: 2;
        }

        .memberCard.green .additional {
            background: linear-gradient(#92bCa6, #A2CCB6);
        }


        .memberCard:hover .additional {
            width: 100%;
            border-radius: 0 5px 5px 0;
        }

        .memberCard .additional .user-card {
            width: 150px;
            height: 100%;
            position: relative;
            float: left;
        }

        .memberCard .additional .user-card::after {
            content: "";
            display: block;
            position: absolute;
            top: 10%;
            right: -2px;
            height: 80%;
            border-left: 2px solid rgba(0, 0, 0, 0.025);
        }

        .memberCard .additional .user-card .level,
        .memberCard .additional .user-card .points {
            top: 15%;
            color: #fff;
            text-transform: uppercase;
            font-size: 0.75em;
            font-weight: bold;
            background: rgba(0, 0, 0, 0.15);
            padding: 0.125rem 0.75rem;
            border-radius: 100px;
            white-space: nowrap;
        }

        .memberCard .additional .user-card .points {
            top: 85%;
        }

        .memberCard .additional .user-card svg {
            top: 50%;
        }

        .memberCard .additional .more-info {
            width: 300px;
            float: left;
            position: absolute;
            left: 150px;
            height: 100%;
        }

        .memberCard .additional .more-info h1 {
            color: #fff;
            margin-bottom: 0;
        }

        .memberCard.green .additional .more-info h1 {
            color: #224C36;
        }

        .memberCard .additional .coords {
            margin: 0 1rem;
            color: #fff;
            font-size: 1rem;
        }

        .memberCard.green .additional .coords {
            color: #325C46;
        }

        .memberCard .additional .coords span + span {
            float: right;
        }

        .memberCard .additional .stats {
            font-size: 2rem;
            display: flex;
            position: absolute;
            bottom: 1rem;
            left: 1rem;
            right: 1rem;
            top: auto;
            color: #fff;
        }

        .memberCard.green .additional .stats {
            color: #325C46;
        }

        .memberCard .additional .stats > div {
            flex: 1;
            text-align: center;
        }

        .memberCard .additional .stats i {
            display: block;
        }

        .memberCard .additional .stats div.title {
            font-size: 0.75rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .memberCard .additional .stats div.value {
            font-size: 1.5rem;
            font-weight: bold;
            line-height: 1.5rem;
        }

        .memberCard .additional .stats div.value.infinity {
            font-size: 2.5rem;
        }

        .memberCard .general {
            width: 300px;
            height: 100%;
            position: absolute;
            top: 0;
            right: 0;
            z-index: 1;
            box-sizing: border-box;
            padding: 1rem;
            padding-top: 0;
        }

        .memberCard .general .more {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            font-size: 0.9em;
        }
    </style>
@endpush
@section('content')
    <div class="breadcrumbs" style="background-image: url('{{$bio->background != null ?
    asset('storage/users/background/'.$bio->background) : asset('images/page-header/users.jpg')}}')">
        <div class="breadcrumbs-overlay"></div>
        <div class="page-title">
            <h2>Pengaturan Akun</h2>
            <p>Di sini Anda dapat mengatur avatar, username, dan kata sandi akun {{env('APP_NAME')}} Anda.</p>
        </div>
        <ul class="crumb">
            <li><a href="{{route('beranda')}}"><i class="fa fa-home"></i></a></li>
            <li style="text-transform: none"><i class="fa fa-angle-double-right"></i>
                <a href="{{URL::current()}}">Akun</a></li>
            <li><a href="#" onclick="goToAnchor()"><i class="fa fa-angle-double-right"></i> Pengaturan</a></li>
        </ul>
    </div>

    <section class="none-margin" style="padding: 40px 0 40px 0">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 text-center">
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

                        <form class="form-horizontal mb-0" role="form" method="POST" id="form-username">
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
                                                <span id="show_username_settings" class="float-right"
                                                      style="cursor: pointer;color: #f89406">
                                                    <i class="fa fa-edit mr-2"></i>USERNAME</span>
                                                <span id="hide_username_settings" class="float-right"
                                                      style="color: #dc3545;cursor: pointer;display:none">
                                                    <i class="fa fa-undo mr-2"></i>BATAL</span>
                                            </small>
                                        </div>
                                    </div>
                                    <table class="stats_username m-0" style="font-size: 14px">
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
                                            <td>{{$alamat != "" ? $alamat->alamat.' - '.$alamat->kode_pos.' ('.$alamat->getOccupancy->name.').' : '(kosong)'}}</td>
                                        </tr>
                                    </table>
                                    <hr class="stats_username" style="margin: 10px 0">
                                    <table class="stats_username m-0" style="font-size: 14px">
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
                                    <div id="username_settings" style="display: none">
                                        <div id="error_username" class="row form-group has-feedback"
                                             style="margin-bottom: 0">
                                            <div class="col-lg-12">
                                                <input id="username" type="text" class="form-control"
                                                       name="username" placeholder="Username"
                                                       value="{{$user->username}}" minlength="4" required>
                                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                                <span class="help-block">
                                                    <b class="strong-error" id="aj_username"
                                                       style="text-transform: none"></b>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-read-more">
                                <button id="btn_save_username" class="btn btn-link btn-block" disabled>
                                    <i class="fa fa-lock mr-2"></i>SIMPAN PERUBAHAN
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8 col-md-6 col-sm-12">
                    <div class="card">
                        <form class="form-horizontal" role="form" method="POST" id="form-password">
                            @csrf
                            {{ method_field('put') }}
                            <div class="card-content">
                                <div class="card-title">
                                    <small style="font-weight: 600">Pengaturan Akun</small>
                                    <hr class="mt-0">
                                    <small>E-mail Utama (terverifikasi)</small>
                                    <div class="row form-group has-feedback">
                                        <div class="col-md-12">
                                            <input type="email" class="form-control" value="{{$user->email}}" disabled>
                                            <span class="glyphicon glyphicon-check form-control-feedback"></span>
                                        </div>
                                    </div>

                                    <small style="cursor: pointer; color: #f89406" id="show_password_settings">
                                        Ubah Kata Sandi ?</small>
                                    <div id="password_settings" style="display: none">
                                        <div id="error_curr_pass" class="row form-group has-feedback">
                                            <div class="col-md-12">
                                                <input placeholder="Kata sandi lama" id="check_password" type="password"
                                                       class="form-control" name="password" minlength="6" required
                                                       autofocus>
                                                <span class="glyphicon glyphicon-eye-open form-control-feedback"
                                                      style="pointer-events: all;cursor: pointer"></span>
                                                <span class="help-block">
                                                    <b class="strong-error aj_pass" style="text-transform: none"></b>
                                                </span>
                                            </div>
                                        </div>

                                        <div id="error_new_pass" class="row form-group has-feedback">
                                            <div class="col-md-12">
                                                <input placeholder="Kata sandi baru" id="password" type="password"
                                                       class="form-control" name="new_password" minlength="6" required>
                                                <span class="glyphicon glyphicon-eye-open form-control-feedback"
                                                      style="pointer-events: all;cursor: pointer"></span>
                                                @if ($errors->has('new_password'))
                                                    <span class="help-block">
                                                <b
                                                    class="strong-error">{{ $errors->first('new_password') }}</b>
                                            </span>
                                                @endif
                                            </div>
                                            <div class="col-md-12">
                                                <input placeholder="Ulangi kata sandi baru" id="password-confirm"
                                                       type="password"
                                                       class="form-control" name="password_confirmation" minlength="6"
                                                       required
                                                       onkeyup="return checkPassword()">
                                                <span class="glyphicon glyphicon-eye-open form-control-feedback"
                                                      style="pointer-events: all;cursor: pointer"></span>
                                                <span class="help-block">
                                            <b class="strong-error aj_new_pass" style="text-transform: none"></b>
                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-read-more">
                                <button id="btn_save_password" class="btn btn-link btn-block" disabled>
                                    <i class="fa fa-lock mr-2"></i>SIMPAN PERUBAHAN
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="card" style="background: #eee;">
                        <div class="card-content">
                            <div class="memberCard">
                                <div class="additional">
                                    <div class="user-card">
                                        <div class="level center">
                                            Level 13
                                        </div>
                                        <div class="points center">
                                            5,312 Points
                                        </div>
                                        {{--<img width="110" class="show_ava" alt="Avatar"
                                             src="{{$bio->ava == "" ? asset('images/faces/'.rand(1,6).'.jpg') :
                                             asset('storage/users/ava/'.$bio->ava)}}">--}}
                                        <svg width="110" height="110" viewBox="0 0 250 250"
                                             xmlns="http://www.w3.org/2000/svg" role="img"
                                             aria-labelledby="title desc" class="center">
                                            <title id="title">Teacher</title>
                                            <desc id="desc">Cartoon of a Caucasian woman smiling, and wearing black
                                                glasses and a purple shirt with white collar drawn by Alvaro
                                                Montoro.
                                            </desc>
                                            <style>
                                                .skin {
                                                    fill: #eab38f;
                                                }

                                                .eyes {
                                                    fill: #1f1f1f;
                                                }

                                                .hair {
                                                    fill: #2f1b0d;
                                                }

                                                .line {
                                                    fill: none;
                                                    stroke: #2f1b0d;
                                                    stroke-width: 2px;
                                                }
                                            </style>
                                            <defs>
                                                <clipPath id="scene">
                                                    <circle cx="125" cy="125" r="115"/>
                                                </clipPath>
                                                <clipPath id="lips">
                                                    <path
                                                        d="M 106,132 C 113,127 125,128 125,132 125,128 137,127 144,132 141,142  134,146  125,146  116,146 109,142 106,132 Z"/>
                                                </clipPath>
                                            </defs>
                                            <circle cx="125" cy="125" r="120" fill="rgba(0,0,0,0.15)"/>
                                            <g stroke="none" stroke-width="0" clip-path="url(#scene)">
                                                <rect x="0" y="0" width="250" height="250" fill="#b0d2e5"/>
                                                <g id="head">
                                                    <path fill="none" stroke="#111111" stroke-width="2"
                                                          d="M 68,103 83,103.5"/>
                                                    <path class="hair"
                                                          d="M 67,90 67,169 78,164 89,169 100,164 112,169 125,164 138,169 150,164 161,169 172,164 183,169 183,90 Z"/>
                                                    <circle cx="125" cy="100" r="55" class="skin"/>
                                                    <ellipse cx="102" cy="107" rx="5" ry="5" class="eyes"
                                                             id="eye-left"/>
                                                    <ellipse cx="148" cy="107" rx="5" ry="5" class="eyes"
                                                             id="eye-right"/>
                                                    <rect x="119" y="140" width="12" height="40" class="skin"/>
                                                    <path class="line eyebrow" d="M 90,98 C 93,90 103,89 110,94"
                                                          id="eyebrow-left"/>
                                                    <path class="line eyebrow" d="M 160,98 C 157,90 147,89 140,94"
                                                          id="eyebrow-right"/>
                                                    <path stroke="#111111" stroke-width="4" d="M 68,103 83,102.5"/>
                                                    <path stroke="#111111" stroke-width="4"
                                                          d="M 182,103 167,102.5"/>
                                                    <path stroke="#050505" stroke-width="3" fill="none"
                                                          d="M 119,102 C 123,99 127,99 131,102"/>
                                                    <path fill="#050505"
                                                          d="M 92,97 C 85,97 79,98 80,101 81,104 84,104 85,102"/>
                                                    <path fill="#050505"
                                                          d="M 158,97 C 165,97 171,98 170,101 169,104 166,104 165,102"/>
                                                    <path stroke="#050505" stroke-width="3"
                                                          fill="rgba(240,240,255,0.4)"
                                                          d="M 119,102 C 118,111 115,119 98,117 85,115 84,108 84,104 84,97 94,96 105,97 112,98 117,98 119,102 Z"/>
                                                    <path stroke="#050505" stroke-width="3"
                                                          fill="rgba(240,240,255,0.4)"
                                                          d="M 131,102 C 132,111 135,119 152,117 165,115 166,108 166,104 166,97 156,96 145,97 138,98 133,98 131,102 Z"/>
                                                    <path class="hair"
                                                          d="M 60,109 C 59,39 118,40 129,40 139,40 187,43 189,99 135,98 115,67 115,67 115,67 108,90 80,109 86,101 91,92 92,87 85,99 65,108 60,109"/>
                                                    <path id="mouth" fill="#d73e3e"
                                                          d="M 106,132 C 113,127 125,128 125,132 125,128 137,127 144,132 141,142  134,146  125,146  116,146 109,142 106,132 Z"/>
                                                    <path id="smile" fill="white"
                                                          d="M125,141 C 140,141 143,132 143,132 143,132 125,133 125,133 125,133 106.5,132 106.5,132 106.5,132 110,141 125,141 Z"
                                                          clip-path="url(#lips)"/>
                                                </g>
                                                <g id="shirt">
                                                    <path fill="#8665c2"
                                                          d="M 132,170 C 146,170 154,200 154,200 154,200 158,250 158,250 158,250 92,250 92,250 92,250 96,200 96,200 96,200 104,170 118,170 118,170 125,172 125,172 125,172 132,170 132,170 Z"/>
                                                    <path id="arm-left" class="arm" stroke="#8665c2" fill="none"
                                                          stroke-width="14" d="M 118,178 C 94,179 66,220 65,254"/>
                                                    <path id="arm-right" class="arm" stroke="#8665c2" fill="none"
                                                          stroke-width="14"
                                                          d="M 132,178 C 156,179 184,220 185,254"/>
                                                    <path fill="white"
                                                          d="M 117,166 C 117,166 125,172 125,172 125,182 115,182 109,170 Z"/>
                                                    <path fill="white"
                                                          d="M 133,166 C 133,166 125,172 125,172 125,182 135,182 141,170 Z"/>
                                                    <circle cx="125" cy="188" r="4" fill="#5a487b"/>
                                                    <circle cx="125" cy="202" r="4" fill="#5a487b"/>
                                                    <circle cx="125" cy="216" r="4" fill="#5a487b"/>
                                                    <circle cx="125" cy="230" r="4" fill="#5a487b"/>
                                                    <circle cx="125" cy="244" r="4" fill="#5a487b"/>
                                                    <path stroke="#daa37f" stroke-width="1" class="skin hand"
                                                          id="hand-left"
                                                          d="M 51,270 C 46,263 60,243 63,246 65,247 66,248 61,255 72,243 76,238 79,240 82,243 72,254 69,257 72,254 82,241 86,244 89,247 75,261 73,263 77,258 84,251 86,253 89,256 70,287 59,278"/>
                                                    <path stroke="#daa37f" stroke-width="1" class="skin hand"
                                                          id="hand-right"
                                                          d="M 199,270 C 204,263 190,243 187,246 185,247 184,248 189,255 178,243 174,238 171,240 168,243 178,254 181,257 178,254 168,241 164,244 161,247 175,261 177,263 173,258 166,251 164,253 161,256 180,287 191,278"/>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="more-info">
                                        <h1>{{$user->name}}</h1>
                                        <div class="coords">
                                            <span>Group Name</span>
                                            <span>Joined January 2019</span>
                                        </div>
                                        <div class="coords">
                                            <span>Position/Role</span>
                                            <span>City, Country</span>
                                        </div>
                                        <div class="stats">
                                            <div>
                                                <div class="title">Awards</div>
                                                <i class="fa fa-trophy"></i>
                                                <div class="value">2</div>
                                            </div>
                                            <div>
                                                <div class="title">Matches</div>
                                                <i class="fa fa-gamepad"></i>
                                                <div class="value">27</div>
                                            </div>
                                            <div>
                                                <div class="title">Pals</div>
                                                <i class="fa fa-users"></i>
                                                <div class="value">123</div>
                                            </div>
                                            <div>
                                                <div class="title">Coffee</div>
                                                <i class="fa fa-coffee"></i>
                                                <div class="value infinity">∞</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="general">
                                    <h1>{{$user->name}}</h1>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce a volutpat
                                        mauris, at molestie lacus. Nam vestibulum sodales odio ut pulvinar.</p>
                                    <span class="more">Mouse over the card for more info</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-read-more">
                            <button id="btn_membercard" class="btn btn-link btn-block">
                                <i class="fa fa-download mr-2"></i>MEMBERSHIP CARD
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $("#show_username_settings").on('click', function () {
            $(this).toggle(300);
            $("#hide_username_settings").toggle(300);

            resetterUsername();

            $('html,body').animate({scrollTop: $("#form-ava").offset().top}, 500);
        });

        $("#hide_username_settings").on('click', function () {
            $(this).toggle(300);
            $("#show_username_settings").toggle(300);

            resetterUsername();
        });

        function resetterUsername() {
            $("#username_settings").toggle(300);
            $(".stats_username").toggle(300);

            if ($("#btn_save_username").attr('disabled')) {
                $("#btn_save_username").removeAttr('disabled');
            } else {
                $("#btn_save_username").attr('disabled', 'disabled');
            }
        }

        $("#form-username").on("submit", function (e) {
            $.ajax({
                type: 'POST',
                url: '{{route('user.update.pengaturan')}}',
                data: new FormData($("#form-username")[0]),
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 0) {
                        swal('Pengaturan Akun', 'Username tersebut telah digunakan!', 'error');
                        $("#error_username").addClass('has-error');
                        $(".aj_username").text("Username tersebut telah digunakan!").parent().show();

                    } else {
                        swal('Pengaturan Akun', 'Username Anda berhasil diperbarui!', 'success');
                        $("#error_username").removeClass('has-error');
                        $(".aj_username").text("").parent().hide();
                        $("#show_username_settings").click();
                        $(".show_username").text(data);
                    }
                },
                error: function () {
                    swal('Oops...', 'Terjadi suatu kesalahan! Silahkan segarkan browser Anda.', 'error');
                }
            });
            return false;
        });

        $("#show_password_settings").on('click', function () {
            $(this).text(function (i, v) {
                return v === "PENGATURAN KATA SANDI" ? "Ubah Kata Sandi ?" : "PENGATURAN KATA SANDI";
            });
            if ($(this).text() === 'Ubah Kata Sandi ?') {
                this.style.color = "#f89406";
            } else {
                this.style.color = "#7f7f7f";
            }

            $("#password_settings").toggle(300);
            if ($("#btn_save_password").attr('disabled')) {
                $("#btn_save_password").removeAttr('disabled');
            } else {
                $("#btn_save_password").attr('disabled', 'disabled');
            }
        });

        $('#check_password + .glyphicon').on('click', function () {
            $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#check_password').togglePassword();
        });

        $('#password + .glyphicon').on('click', function () {
            $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#password').togglePassword();
        });

        $('#password-confirm + .glyphicon').on('click', function () {
            $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#password-confirm').togglePassword();
        });

        function checkPassword() {
            var new_pas = $("#password").val(),
                re_pas = $("#password-confirm").val();
            if (new_pas != re_pas) {
                $("#error_new_pass").addClass('has-error');
                $(".aj_new_pass").text("Konfirmasi password harus sama dengan password baru Anda!").parent().show();
                $("#btn_save_password").attr('disabled', 'disabled');
            } else {
                $("#error_new_pass").removeClass('has-error');
                $(".aj_new_pass").text("").parent().hide();
                $("#btn_save_password").removeAttr('disabled');
            }
        }

        $("#form-password").on("submit", function (e) {
            $.ajax({
                type: 'POST',
                url: '{{route('user.update.pengaturan')}}',
                data: new FormData($("#form-password")[0]),
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 0) {
                        swal('Pengaturan Akun', 'Kata sandi lama Anda salah!', 'error');
                        $("#error_curr_pass").addClass('has-error');
                        $("#error_new_pass").removeClass('has-error');
                        $(".aj_pass").text("Password lama Anda salah!").parent().show();
                        $(".aj_new_pass").text("").parent().hide();

                    } else if (data == 1) {
                        swal('Pengaturan Akun', 'Konfirmasi kata sandi Anda tidak cocok!', 'error');
                        $("#error_curr_pass").removeClass('has-error');
                        $("#error_new_pass").addClass('has-error');
                        $(".aj_pass").text("").parent().hide();
                        $(".aj_new_pass").text("Konfirmasi kata sandi Anda tidak cocok!").parent().show();

                    } else {
                        swal('Pengaturan Akun', 'Kata sandi Anda berhasil diperbarui!', 'success');
                        $("#form-password").trigger("reset");
                        $("#error_curr_pass").removeClass('has-error');
                        $("#error_new_pass").removeClass('has-error');
                        $(".aj_pass").text("").parent().hide();
                        $(".aj_new_pass").text("").parent().hide();
                        $("#show_password_settings").click();
                    }
                },
                error: function () {
                    swal('Oops...', 'Terjadi suatu kesalahan! Silahkan segarkan browser Anda.', 'error');
                }
            });
            return false;
        });

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

        function humanFileSize(size) {
            var i = Math.floor(Math.log(size) / Math.log(1024));
            return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
        }

        function goToAnchor() {
            $('html,body').animate({scrollTop: $(".crumb").offset().top}, 500);
        }
    </script>
@endpush
