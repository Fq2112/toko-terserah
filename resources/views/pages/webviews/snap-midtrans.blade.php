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
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('vendor/sweetalert/sweetalert.min.js')}}"></script>
<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{env('MIDTRANS_CLIENT_KEY')}}"></script>
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
                    success: function (data) {
                        swal({
                            title: "SUKSES!",
                            text: data,
                            icon: 'success',
                            buttons: false,
                            closeOnEsc: false,
                            closeOnClickOutside: false,
                        });
                        setTimeout(function () {
                            //location.href = '{{route('user.dashboard')}}'
                        }, 7000);
                    },
                    error: function () {
                        swal('Oops..', 'Terjadi kesalahan! Silahkan, segarkan browser Anda.', 'error');
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
