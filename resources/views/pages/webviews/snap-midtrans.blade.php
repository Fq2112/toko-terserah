<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
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

        .text-empty{
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
{{--<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{env('MIDTRANS_CLIENT_KEY')}}"></script>--}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{env('MIDTRANS_SERVER_KEY')}}"></script>
<script>
    $(function () {
        snap.pay('{{$data['snap_token']}}', {
            onSuccess: function (result) {
                responseMidtrans('{{route('get.midtrans-callback.finish')}}', result);
            },
            onPending: function (result) {
                responseMidtrans('{{route('get.midtrans-callback.unfinish')}}', result);
            },
            onError: function (result) {
                swal('Oops..', result.status_message, 'error');
            },
            onClose: function () {
                $("body").css("background", "#f0f4f7");
                $(".img-empty").css("top", "20%").attr("src", "{{asset('images/empty-page.gif')}}");
                $(".text-empty").css("top", "62%").css("color", "#1f455e").text("Sesi pembayaran Anda berakhir! Silahkan ulangi lagi.");
                $(".img-empty, .text-empty").show();
                swal('PERHATIAN!', 'Sesi pembayaran Anda berakhir! Silahkan ulangi lagi.', 'warning');
            }
        });
    });

    function responseMidtrans(url, result) {
        if (result.payment_type == 'credit_card' || result.payment_type == 'bank_transfer' ||
            result.payment_type == 'echannel' || result.payment_type == 'gopay' || result.payment_type == 'cstore') {

            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: url,
                    type: "GET",
                    data: {
                        transaction_id: result.transaction_id,
                        pdf_url: result.pdf_url,
                        cart_ids: '{{$data['cart_ids']}}',
                        pengiriman_id: '{{$data['pengiriman_id']}}',
                        penagihan_id: '{{$data['penagihan_id']}}',
                        ongkir: '{{$data['ongkir']}}',
                        durasi_pengiriman: '{{$data['durasi_pengiriman']}}',
                        weight: '{{$data['weight']}}',
                        total: '{{$data['total']}}',
                        note: '{{$data['note']}}',
                        promo_code: '{{$data['promo_code']}}',
                        discount_price: '{{$data['discount_price']}}',
                        kode_kurir: '{{$data['kode_kurir']}}',
                        nama_kurir: '{{$data['nama_kurir']}}',
                        layanan_kurir: '{{$data['layanan_kurir']}}',
                        opsi: '{{$data['opsi']}}',
                    },
                    beforeSend: function () {
                        const preloader = document.createElement('div');
                        preloader.innerHTML =
                            '<div class="ajax-loader" style="display: none;top: 20em">' +
                            '<div class="preloader4"></div></div>';

                        swal({
                            title: 'Loading...',
                            text: 'Mohon tunggu, transaksi Anda sedang diproses',
                            content: preloader,
                            icon: 'warning',
                            buttons: false,
                            closeOnEsc: false,
                            closeOnClickOutside: false,
                        });
                    },
                    complete: function () {
                        swal.close();
                    },
                    success: function () {
                        $("body").css("background", "#fff");
                        $(".img-empty").css("top", "15%").attr("src", "{{asset('images/success-page.gif')}}");
                        $(".text-empty").css("top", "57%").css("color", "#1b6286").text('Pesanan Anda berhasil di checkout! Silahkan klik icon "History" di pojok kanan atas untuk melihat status pesanan Anda, terimakasih :)');
                        $(".img-empty, .text-empty").show();

                        swal({
                            title: "SUKSES!",
                            text: 'Pesanan Anda berhasil di checkout! Silahkan klik icon "History" di pojok kanan atas untuk melihat status pesanan Anda, terimakasih :)',
                            icon: 'success',
                            closeOnEsc: false,
                            closeOnClickOutside: false,
                        });
                        window.history.pushState('page2', 'Title', window.location.origin+'/'+window.location.pathname+'#telah-success');
                    },
                    error: function () {
                        swal('Oops..', 'Terjadi kesalahan! Silahkan checkout ulang pesanan Anda.', 'error');
                    }
                });
            }.bind(this), 800);

        } else {
            swal('Oops..', 'Maaf kanal pembayaran yang Anda pilih masih maintenance, silahkan pilih kanal lainnya.', 'error');
        }
    }

    $(window).on('beforeunload', function () {
        return "You have attempted to leave this page. Are you sure?";
    });
</script>
</body>
</html>
