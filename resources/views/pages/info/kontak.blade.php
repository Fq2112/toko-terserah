@extends('layouts.mst')
@section('title', 'Kontak | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('css/gmaps.css')}}">
    <style>
        body {
            overflow-x: hidden;
        }

        .breadcrumbs {
            background-image: url({{asset('images/page-header/kontak.jpg')}});
        }
    </style>
@endpush
@section('content')
    <div class="breadcrumbs">
        <div class="breadcrumbs-overlay"></div>
        <div class="page-title">
            <h2>Kontak</h2>
            <p>Jangan ragu untuk menghubungi kami!</p>
        </div>
        <ul class="crumb">
            <li><a href="{{route('beranda')}}"><i class="fa fa-home"></i></a></li>
            <li style="text-transform: none"><i class="fa fa-angle-double-right"></i><a
                    href="{{URL::current()}}">Info</a></li>
            <li><a href="#" onclick="goToAnchor()"><i class="fa fa-angle-double-right"></i> Kontak</a></li>
        </ul>
    </div>

    <section class="no-padding">
        <div class="row">
            <div class="col-lg-6">
                <div id="map" style="width: 100%;height: 600px"></div>
            </div>
            <div class="col-lg-6" style="padding: 3em 5em 2em 3em;">
                <form action="{{route('kirim.kontak')}}" method="post">
                    @csrf
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="form-control-label" for="kon_name">
                                Nama Lengkap <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input id="kon_name" type="text" class="form-control" name="name"
                                       placeholder="Nama lengkap" value="{{Auth::check() ? Auth::user()->name : ''}}"
                                       required autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label class="form-control-label" for="kon_email">Email <span
                                    class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input id="kon_email" type="email" class="form-control" name="email"
                                       placeholder="Alamat email" value="{{Auth::check() ? Auth::user()->email : ''}}"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-control-label" for="kon_phone">
                                Telepon <span class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone fa-flip-horizontal"></i></span>
                                <input id="kon_phone" placeholder="Nomor telepon" type="text" class="form-control"
                                       name="phone" required onkeypress="return numberOnly(event, false)"
                                       value="{{Auth::check() ? Auth::user()->getBio->phone : ''}}">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="form-control-label" for="topic">Topik <span
                                    class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tags"></i></span>
                                <select id="topic" name="topic" class="form-control use-select2" required>
                                    <option></option>
                                    <option value="Mengenai Produk">Mengenai Produk</option>
                                    <option value="Laporan Bug">Laporan Bug</option>
                                    <option value="Saran">Saran</option>
                                    <option value="Pembayaran Anda">Pembayaran Anda</option>
                                    <option value="Pesanan Anda">Pesanan Anda</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="form-control-label" for="subject">Subyek <span
                                    class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-text-width"></i></span>
                                <input id="kon_subject" type="text" class="form-control" name="subject"
                                       placeholder="Subyek" minlength="3" required>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="form-control-label" for="message">Pesan <span
                                    class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-text-height"></i></span>
                                <textarea id="kon_message" class="form-control" name="message"
                                          placeholder="Tulis pesan Anda disini&hellip;" rows="5"
                                          style="resize: vertical" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-dark-green btn-block"
                                    style="padding-top: 8px;padding-bottom: 8px"><b>KIRIM</b></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIljHbKjgtTrpZhEiHum734tF1tolxI68&libraries=places"></script>
    <script>
        var google;

        function init() {
            var myLatlng = new google.maps.LatLng(-7.2819551, 112.6569592);

            var mapOptions = {
                zoom: 15,
                center: myLatlng,
            };

            var mapElement = document.getElementById('map');

            var map = new google.maps.Map(mapElement, mapOptions);

            var contentString =
                '<div id="iw-container">' +
                '<div class="iw-title">{{env('APP_COMPANY')}}</div>' +
                '<div class="iw-content">' +
                '<img class="img-responsive" src="{{asset('images/logotype.png')}}">' +
                '<div class="iw-subTitle">Kontak</div>' +
                '<p>Jl. Raya Lontar No. 46 Surabaya – 60216.<br>' +
                '<br>Telepon: <a href="tel:628113051081">+62 811-3051-081</a>' +
                '<br>Email: <a href="mailto:{{env('MAIL_USERNAME')}}">{{env('MAIL_USERNAME')}}</a>' +
                '</p></div><div class="iw-bottom-gradient"></div></div>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString,
                maxWidth: 350
            });

            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                icon: '{{asset('images/pin.png')}}',
                anchorPoint: new google.maps.Point(0, -29)
            });

            infowindow.open(map, marker);

            marker.addListener('click', function () {
                infowindow.open(map, marker);
            });

            google.maps.event.addListener(map, 'click', function () {
                infowindow.close();
            });

            google.maps.event.addListener(infowindow, 'domready', function () {
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
        }

        google.maps.event.addDomListener(window, 'load', init);

        function goToAnchor() {
            $('html,body').animate({scrollTop: $(".crumb").offset().top}, 500);
        }

        @if(session('kontak'))
        swal('Berhasil mengirimkan pesan!', '{{ session('kontak') }}', 'success');
        @endif
    </script>
@endpush
