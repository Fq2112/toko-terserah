<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Membercard Webview | Toko Terserah (Terlengkap Serba Murah)</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('favicon.ico')}}">
    <link rel="stylesheet" href="{{asset('css/membercard.css')}}">
</head>

<body>
<div id="capture" class="memberCard">
    <div class="additional">
        <div class="user-card">
            <div class="level center">
                ID&ensp;#&nbsp;{{str_pad($user->id,6,0,STR_PAD_LEFT)}}
            </div>
            <div class="points center">
                {{$bio->phone != "" ? $bio->phone : 'Phone (–)'}}
            </div>
            <img class="show_ava center" alt="Avatar"
                 src="{{$bio->ava == "" ? asset('images/faces/'.rand(1,6).'.jpg') : asset('storage/users/ava/'.$bio->ava)}}"
                 style="border: 5px solid #ddd; border-radius: 100%; max-width: 100%; width: 110px; height: 110px">
        </div>
        <div class="more-info">
            <h1>{{$user->name}}</h1>
            <div class="coords" style="color: #fff">
                <span>{{$bio->gender != "" ? ucfirst($bio->gender) : 'Gender (–)'}}</span>
                <span>Customer</span>
            </div>
            <div class="coords" style="color: #fff">
                <span>{{$bio->dob != "" ? \Carbon\Carbon::parse($bio->dob)->formatLocalized('%d %b %Y') : 'Birthday (–)'}}</span>
                <span>{{\Carbon\Carbon::parse($user->created_at)->formatLocalized('%d %b %Y')}}</span>
            </div>
            <div class="stats">
                <div>
                    <div class="title">Pesanan</div>
                    <i class="fa fa-box-open"></i>
                    <div class="value">{{count($user->getPesanan)}}</div>
                </div>
                <div>
                    <div class="title">Wishlist</div>
                    <i class="fa fa-heart"></i>
                    <div class="value">{{count($user->getWishlist)}}</div>
                </div>
                <div>
                    <div class="title">Ulasan</div>
                    <i class="fa fa-comment-alt"></i>
                    <div class="value">{{count($user->getUlasan)}}</div>
                </div>
                <div>
                    <div class="title">Pertanyaan</div>
                    <i class="fa fa-comments"></i>
                    <div class="value">{{count($user->getQnA)}}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="general">
        <h1>{{$user->name}}</h1>
        <div class="coords">
            <span>{{$bio->gender != "" ? ucfirst($bio->gender) : 'Gender (–)'}}</span>
            <span>Customer</span>
        </div>
        <div class="coords">
            <span>{{$bio->dob != "" ? \Carbon\Carbon::parse($bio->dob)->formatLocalized('%d %b %Y') : 'Birthday (–)'}}</span>
            <span>{{\Carbon\Carbon::parse($user->created_at)->formatLocalized('%d %b %Y')}}</span>
        </div>
        <img class="center img-responsive" alt="Logo" style="width:30%;opacity: .5" src="{{asset('images/logo-TT.png')}}">
        <span class="more">{!! DNS1D::getBarcodeHTML(str_pad($user->id,6,0,STR_PAD_LEFT), 'C39') !!}</span>
    </div>
</div>
</body>
</html>
