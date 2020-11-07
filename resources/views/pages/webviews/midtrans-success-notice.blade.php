<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Snap Midtrans Webview | Toko Terserah (Terlengkap Serba Murah)</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('favicon.ico')}}">
    <link rel="stylesheet" href="{{asset('css/ajax-loader.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/sweetalert/sweetalert2.css')}}">
    <link rel="stylesheet" href="{{asset('css/additional.css')}}">
    <style>
        body {
            margin: 0 1em;
        }

        .img-empty {
            display: none;
            width: 100%;
            position: absolute;
        }

        .text-empty {
            display: none;
            text-align: center;
            position: absolute;
            font-size: 6vw;
            margin-bottom: 0;
        }

        .swal-overlay {
            z-index: 9999999 !important;
        }

        .ajax-loader {
            width: unset;
            height: unset;
            background-color: unset;
            z-index: 1;
            position: absolute;
            left: 0;
            right: 0;
        }

        #snap-midtrans {
            z-index: 9999999 !important;
        }
    </style>
</head>

<body>
    <img class="img-empty" alt="empty" src="#">
    <h2 class="text-empty"></h2>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/sweetalert/sweetalert.min.js')}}"></script>
    <script>
        $("body").css("background", "#fff");
        $(".img-empty").css("top", "15%").attr("src", "{{asset('images/success-page.gif')}}");
        $(".text-empty").css("top", "57%").css("color", "#1b6286").text('Pesanan Anda berhasil di checkout! Silahkan klik icon "History" di pojok kanan atas untuk melihat status pesanan Anda, terimakasih :)');
        $(".img-empty, .text-empty").show();
    </script>
</body>

</html>
