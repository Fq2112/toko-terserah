<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scaleable=no">
    <title>FAKTUR #{{$code}}</title>
    <style type="text/css">
        .alert {
            padding: 15px;
            margin: 0 1.5em 1em 1.5em;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert h4 {
            margin-top: 0;
            color: inherit;
        }

        .alert .alert-link {
            font-weight: bold;
        }

        .alert > p,
        .alert > ul {
            margin-bottom: 0;
        }

        .alert > p + p {
            margin-top: 5px;
        }

        .alert-dismissable,
        .alert-dismissible {
            padding-right: 35px;
        }

        .alert-dismissable .close,
        .alert-dismissible .close {
            position: relative;
            top: -2px;
            right: -21px;
            color: inherit;
        }

        .alert-success {
            background-color: #dff0d8;
            border-color: #d6e9c6;
            color: #3c763d;
        }

        .alert-success hr {
            border-top-color: #c9e2b3;
        }

        .alert-success .alert-link {
            color: #2b542c;
        }

        .alert-info {
            background-color: #d9edf7;
            border-color: #bce8f1;
            color: #31708f;
        }

        .alert-info hr {
            border-top-color: #a6e1ec;
        }

        .alert-info .alert-link {
            color: #245269;
        }

        .alert-warning {
            background-color: #fcf8e3;
            border-color: #faebcc;
            color: #8a6d3b;
        }

        .alert-warning hr {
            border-top-color: #f7e1b5;
        }

        .alert-warning .alert-link {
            color: #66512c;
        }

        .alert-danger {
            background-color: #f2dede;
            border-color: #ebccd1;
            color: #a94442;
        }

        .alert-danger hr {
            border-top-color: #e4b9c0;
        }

        .alert-danger .alert-link {
            color: #843534;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        blockquote {
            padding: 10px 20px;
            margin: 0 0 20px;
            font-size: 17.5px;
            border-left: 5px solid #eeeeee;
        }

        blockquote p:last-child,
        blockquote ul:last-child,
        blockquote ol:last-child {
            margin-bottom: 0;
        }

        blockquote footer,
        blockquote small,
        blockquote .small {
            display: block;
            font-size: 80%;
            line-height: 1.42857;
            color: #777777;
        }

        blockquote footer:before,
        blockquote small:before,
        blockquote .small:before {
            content: '\2014 \00A0';
        }

        .blockquote-reverse,
        blockquote.pull-right {
            padding-right: 15px;
            padding-left: 0;
            border-right: 5px solid #eeeeee;
            border-left: 0;
            text-align: right;
        }

        .blockquote-reverse footer:before,
        .blockquote-reverse small:before,
        .blockquote-reverse .small:before,
        blockquote.pull-right footer:before,
        blockquote.pull-right small:before,
        blockquote.pull-right .small:before {
            content: '';
        }

        .blockquote-reverse footer:after,
        .blockquote-reverse small:after,
        .blockquote-reverse .small:after,
        blockquote.pull-right footer:after,
        blockquote.pull-right small:after,
        blockquote.pull-right .small:after {
            content: '\00A0 \2014';
        }

        .list-inline {
            padding-left: 0;
            list-style: none;
            margin-left: -5px;
        }

        .list-inline > li {
            display: inline-block;
            padding-left: 5px;
            padding-right: 5px;
        }

        .hr-divider {
            margin: 0 0 .5em 0;
            border: 0;
            height: 1px;
            background-image: linear-gradient(to right, rgba(0, 0, 0, .4), rgba(0, 0, 0, .1), rgba(0, 0, 0, 0));
        }

        #activate {
            color: #FFFFFF;
            background: #5bb300;
            -moz-border-radius: 9px;
            -webkit-border-radius: 9px;
            border-radius: 9px;
            padding-left: 20px;
            padding-right: 20px;
            width: 320px;
            display: block;
            font-size: 18px;
            font-weight: bold;
            line-height: 50px;
            text-align: center;
            text-decoration: none;
            font-family: helvetica, arial;
            text-transform: uppercase;
        }

        .zoom {
            transition: transform .3s;
        }

        .zoom:hover {
            -ms-transform: scale(1.3); /* IE 9 */
            -webkit-transform: scale(1.3); /* Safari 3-8 */
            transform: scale(1.3);
        }

        div, p, a, li, td {
            -webkit-text-size-adjust: none;
        }

        .ExternalClass * {
            line-height: 100%
        }

        .ReadMsgBody {
            width: 100%
        }

        .ExternalClass {
            width: 100%
        }

        .appleLinks a {
            color: #646464;
            text-decoration: none;
        }

        table {
            border-collapse: collapse;
        }

        body {
            margin-left: 0px;
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
        }

        .appleLinksWhite a {
            color: #949494;
            text-decoration: none;
        }

        table.custom td div {
            margin-bottom: 1.3em;
        }

        @media screen and (max-width: 480px) {
            /* Width Control */
            table[class=full-width], img[class=full-width], a[class=full-width], div[class=full-width] {
                width: 100% !important;
                height: auto !important;
            }

            div[class=line40] {
                line-height: 40px !important;
            }

            /* Hiding Elements */
            table[id=hide], td[class="hide"], img[id=hide] {
                display: none !important;
            }

            img[class=logo] {
                width: 240px !important;
                height: 75px !important;
            }
        }

        /* Medium Screen Tablets */
        @media screen and (max-width: 650px) {
            img[class=logo] {
                width: 240px !important;
                height: 75px !important;
            }

            a[class=footerlinks] {
                display: block !important;
                font-size: 16px !important;
                padding: 0px 4px 2px 4px !important;
                line-height: 14px !important;
                width: 70% !important;
                text-align: center !important;
                color: #F9F9F9 !important;
                text-decoration: none !important;
            }

            table[class=full-width], img[class=full-width], a[class=full-width], div[class=full-width] {
                width: 100% !important;
                height: auto !important;
            }

            table[class=hide], img[class=hide], td[class=hide], span[class=hide] {
                display: none !important;
            }

            div[class=line40] {
                line-height: 40px !important;
            }

            td[class=headline] {
                padding-left: 10px !important;
            }

            span[class=content2] {
                font-size: 18px !important;
            }

            span[class=appleLinksWhite] {
                color: #949494 !important;
            }

            td[class=body], span[class=body] {
                padding-right: 25px !important;
                padding-left: 25px !important;
                font-size: 20px !important;
            }

            td[class=footer-padding] {
                padding-right: 15px !important;
                padding-left: 15px !important;
            }

            img[class=social-icons] {
                height: 90px !important;
                width: auto !important;
            }
        }
    </style>
</head>
<body>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="#FAFAFA" class="full-width">
    <tbody>
    <tr>
        <td>
            <div style="font-size:10px;line-height:10px;">&nbsp;</div>
        </td>
    </tr>
    </tbody>
</table>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FAFAFA">
    <tbody>
    <tr>
        <td align="center">
            <table width="700" border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF"
                   class="full-width" style="margin:0 auto;">
                <tbody>
                <tr>
                    <td width="700" align="center">
                        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF"
                               class="full-width" style="margin:0 auto;">
                            <tbody>
                            <tr>
                                <td width="14" bgcolor="#fafafa"></td>
                                <td width="2" bgcolor="#f9f9f9"></td>
                                <td width="2" bgcolor="#f7f7f7"></td>
                                <td width="2" bgcolor="#f3f3f3"></td>
                                <td width="660" valign="top" bgcolor="#FFFFFF">
                                    <table width="660" border="0" cellspacing="0" cellpadding="0" class="full-width"
                                           bgcolor="#FFFFFF" style="border-top: 2px solid #f3f3f3">
                                        <tbody>
                                        <tr>
                                            <td align="center" width="660">
                                                <a name="Logo" style="display:block" href="{{route('beranda')}}"
                                                   target="_blank">
                                                    <img src="{{asset('images/logo-TT.png')}}" border="0"
                                                         style="display:block;width: 25%;margin: 1em" class="logo"></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="border-top: 1px solid #e0e0e0; width: 660px; height: 2px"
                                                     class="full-width"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table border="0" cellpadding="10" cellspacing="0"
                                                       style="margin: .5em 1em">
                                                    <tr>
                                                        <td>
                                                            <small style="line-height: 2em">
                                                                @if($status == 'expired')
                                                                    <b style="font-size: 22px">Pesanan Anda telah
                                                                        dibatalkan oleh {{env('APP_NAME')}}</b><br>
                                                                    Mohon untuk tidak melakukan pembayaran apapun.
                                                                    Silakan hubungi {{env('APP_NAME')}} jika memiliki
                                                                    pertanyaan terkait pesanan Anda.
                                                                @else
                                                                    @if($data->isLunas == false)
                                                                        <b style="font-size: 22px">Mohon untuk segera
                                                                            menyeleseaikan pembayaran Anda</b><br>
                                                                        Checkout berhasil
                                                                        pada {{now()->formatLocalized('%d %B %Y – %H:%M')}}
                                                                    @else
                                                                        <b style="font-size: 22px">Kami akan mengirimkan
                                                                            produk yang Anda pesan sesegera mungkin</b><br>
                                                                        Terima kasih telah menyelesaikan transaksi
                                                                        di {{env('APP_TITLE')}}
                                                                    @endif
                                                                @endif
                                                            </small>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="font-size:30px;line-height:30px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    @php
                                        $subtotal = 0;
                                        foreach(\App\Models\Keranjang::whereIn('id', $data->keranjang_ids)->get() as $cart) {
                                            $subtotal += $cart->total;
                                        }

                                        $discount_price = $data->is_discount == true ? ceil($data->discount) : 0;
                                    @endphp
                                    <table bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="660"
                                           align="center">
                                        <tr>
                                            <td valign="top" width="60%">
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%"
                                                       style="margin-left: 1em">
                                                    <tr>
                                                        <td>
                                                            <small>
                                                                <a style="text-decoration: none;color: #5bb300;"
                                                                   href="{{route('user.download.file', ['code' => $code])}}">#<b>{{$code}}</b></a>
                                                            </small>
                                                            <hr class="hr-divider">
                                                            <table class="custom">
                                                                <tr>
                                                                    <td>
                                                                        <div><b>Subtotal
                                                                                ({{count($data->keranjang_ids)}}
                                                                                produk)</b></div>
                                                                    </td>
                                                                    <td>
                                                                        <div>&emsp;</div>
                                                                    </td>
                                                                    <td align="right">
                                                                        <div>
                                                                            <b>Rp{{number_format($subtotal,2,',','.')}}</b>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div><b>Biaya Packing</b></div>
                                                                    </td>
                                                                    <td>
                                                                        <div>&emsp;</div>
                                                                    </td>
                                                                    <td align="right">
                                                                        <div>
                                                                            <b>-Rp{{number_format($data->packing_price,2,',','.')}}</b>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div><b>Diskon</b></div>
                                                                    </td>
                                                                    <td>
                                                                        <div>&emsp;</div>
                                                                    </td>
                                                                    <td align="right">
                                                                        <div>
                                                                            <b>-Rp{{number_format($discount_price,2,',','.')}}</b>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div><b>Ongkir</b></div>
                                                                    </td>
                                                                    <td>
                                                                        <div>&emsp;</div>
                                                                    </td>
                                                                    <td align="right">
                                                                        <div>
                                                                            <b>Rp{{number_format($data->ongkir,2,',','.')}}</b>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr style="border-top: 1px solid #ccc">
                                                                    <td><b>TOTAL</b></td>
                                                                    <td>&emsp;</td>
                                                                    <td align="right" style="font-size: large">
                                                                        <b>Rp{{number_format($subtotal - $discount_price + $data->ongkir,2,',','.')}}</b>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td valign="top" width="40%">
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%"
                                                       style="margin-left: 1em">
                                                    <tr>
                                                        <td>
                                                            <small><b>P.O.</b></small>
                                                            <hr class="hr-divider">
                                                            <span>#{{str_pad($data->id,14,0,STR_PAD_LEFT)}}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <small><b>Due Date</b></small>
                                                            <hr class="hr-divider">
                                                            <span>{{$status == 'expired' ? now()->formatLocalized('%d %B %Y – %H:%M') : now()->addDay()->formatLocalized('%d %B %Y – %H:%M')}}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <small><b>Status Pembayaran</b></small>
                                                            <hr class="hr-divider">
                                                            <span>{{$status == 'expired' ? 'Pembayaran Dibatalkan' : ($data->isLunas == false ? 'Menunggu Pembayaran' : 'Pembayaran Diterima')}}</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="50%">
                                                <table border="0" cellpadding="10" cellspacing="0"
                                                       style="margin-left: 1em" width="100%">
                                                    <tr>
                                                        <td>
                                                            <small><b>Metode Pembayaran</b>
                                                                <sub>{{strtoupper(str_replace('_',' ',$payment['type']))}}</sub>
                                                            </small>
                                                            <hr class="hr-divider">
                                                            <table>
                                                                <tr>
                                                                    <td width="50%">
                                                                        <img alt="{{$payment['bank']}}"
                                                                             style="width: 90%;"
                                                                             src="{{asset('images/paymentMethod/'.$payment['bank'].'.png')}}">
                                                                    </td>
                                                                    @if($payment['type'] == 'credit_card' || $payment['type'] == 'bank_transfer' || $payment['type'] == 'cstore')
                                                                        <td>
                                                                            <small
                                                                                style="line-height: 1.5em;font-size: 14px">
                                                                                <b style="font-size: 16px">{{$payment['account']}}</b>
                                                                                @if($payment['type'] == 'bank_transfer')
                                                                                    <br>a/n PT.  Penta Surya Pratama
                                                                                @endif
                                                                            </small>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td valign="top" width="50%">
                                                <table border="0" cellpadding="10" cellspacing="0"
                                                       style="margin-left: 1em" width="100%">
                                                    <tr>
                                                        <td>
                                                            <small><b>Opsi Pengiriman</b></small>
                                                            <hr class="hr-divider">
                                                            <table>
                                                                <tr>
                                                                    @if($data->isAmbil == false && $data->is_kurir_terserah == false)
                                                                        <td width="50%">
                                                                            <img alt="Logo"
                                                                                 src="{{asset('images/kurir/'.$data->kode_kurir.'.png')}}">
                                                                        </td>
                                                                        <td>
                                                                            <small
                                                                                style="line-height: 1.5em;font-size: 14px">
                                                                                <b style="font-size: 16px">
                                                                                    {{$data->nama_kurir}}<br>
                                                                                    {{$data->layanan_kurir}}</b>
                                                                            </small>
                                                                        </td>
                                                                    @else
                                                                        <td width="50%">
                                                                            <img alt="Logo" style="width: 85%"
                                                                                 src="{{asset('images/logo-TT.png')}}">
                                                                        </td>
                                                                        <td>
                                                                            <small
                                                                                style="line-height: 1.5em;font-size: 14px">
                                                                                <b style="font-size: 16px">
                                                                                    {{$data->isAmbil == true ? 'Ambil di '.env('APP_NAME') : 'Kurir '.env('APP_NAME')}}
                                                                                </b>
                                                                            </small>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <table bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="660"
                                           align="center">
                                        <tr>
                                            <td>
                                                <div style="font-size:20px;line-height:20px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="alert alert-info text-center">
                                                    Silahkan unduh file pdf faktur yang <b>terlampir</b> untuk melihat
                                                    detail pesanan Anda.
                                                </div>
                                            </td>
                                        </tr>
                                        @if($data->isLunas == false)
                                            <tr>
                                                <td>
                                                    <div class="alert alert-warning text-center">
                                                        Pastikan untuk tidak menginformasikan detail pembayaran dan
                                                        bukti kepada pihak manapun <b>kecuali</b> {{env('APP_NAME')}}.
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                        @if($total_voucher > 0)
                                            <tr>
                                                <td>
                                                    <div class="alert alert-success text-center">
                                                        Selamat Anda mendapatkan <b>{{$total_voucher}}</b> voucher
                                                        belanja di {{env('APP_NAME')}}! Silahkan gunakan voucher
                                                        tersebut ketika Anda melakukan checkout.
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>
                                                <div style="font-size:20px;line-height:20px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                    </table>
                                    <table bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="660"
                                           align="center" style="border-top: 2px solid #f3f3f3">
                                        <tr>
                                            <td>
                                                <table border="0" cellpadding="10" cellspacing="0"
                                                       style="margin: .5em 1em">
                                                    <tr>
                                                        <td>
                                                            <small style="line-height: 2em">
                                                                <b style="font-size: 20px">Tetap awasi pesanan Anda di
                                                                    halaman Dashboard [Riwayat Pemesanan]</b><br>
                                                                Untuk mengalihkan Anda ke halaman tersebut, klik tombol
                                                                Dashboard di bawah ini</small>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" width="600" class="full-width"
                                                            style="padding-left: 20px; padding-right:20px" valign="top">
                                                            <a class="zoom" id="activate" target="_blank"
                                                               href="{{route('user.dashboard')}}">DASHBOARD</a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="2" bgcolor="#f3f3f3"></td>
                                <td width="2" bgcolor="#f7f7f7"></td>
                                <td width="2" bgcolor="#f9f9f9"></td>
                                <td width="14" bgcolor="#fafafa"></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
    <tbody>
    <tr>
        <td valign="top" align="center">
            <table width="700" border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="#ffffff"
                   class="full-width" style="margin:0 auto;">
                <tbody>
                <tr>
                    <td valign="top" width="20" class="hide" bgcolor="#1a1c21">
                        <div style="font-size:44px;line-height:44px;">&nbsp;</div>
                    </td>
                    <td valign="top" width="660" bgcolor="#FFFFFF" class="hide" height="40" alt="" border="0"></td>
                    <td valign="top" width="20" class="hide" bgcolor="#1a1c21">
                        <div style="font-size:44px;line-height:44px;">&nbsp;</div>
                    </td>
                </tr>
                </tbody>
            </table>
            <table width="700" border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="#1a1c21"
                   class="full-width" style="margin:0 auto;">
                <tbody>
                <tr>
                    <td valign="top" align="center">
                        <table width="700" border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="#1a1c21"
                               class="full-width">
                            <tbody>
                            <tr>
                                <td valign="top" align="center">
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td valign="top" width="660" bgcolor="#1a1c21">
                                                <div style="font-size:39px;line-height:39px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td valign="top" width="20" class="hide">&nbsp;</td>
                                            <td align="center" valign="top" width="660" bgcolor="#1a1c21">
                                                <a name="Logo_1" style="display:block;" href="{{route('beranda')}}"
                                                   target="_blank">
                                                    <img src="{{asset('images/logo-TT.png')}}" alt="logo"
                                                         border="0" style="display:block;width: 15%;"></a>
                                            </td>
                                            <td valign="top" width="20" class="hide">&nbsp;</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td valign="top" width="20" class="hide">&nbsp;</td>
                                            <td align="center" valign="top" width="660" bgcolor="#1a1c21">
                                                <div style="font-size:5px;line-height:5px;">&nbsp;</div>
                                            </td>
                                            <td valign="top" width="20" class="hide">&nbsp;</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                                   bgcolor="#1a1c21" class="full-width">
                                                <tbody>
                                                <tr>
                                                    <td valign="top" width="20" class="hide">&nbsp;</td>
                                                    <td align="center" valign="top" width="660" bgcolor="#1a1c21">
                                                        <div
                                                            style="font-family:Helvetica, arial,helv,sans-serif;font-size:12px;color:#F9F9F9;">
                                                            Unduh aplikasi kami di sini, GRATIS!
                                                        </div>
                                                    </td>
                                                    <td valign="top" width="20" class="hide">&nbsp;</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="700">
                                                <table width="700" border="0" align="center" cellpadding="0"
                                                       cellspacing="0" bgcolor="#1a1c21" class="full-width">
                                                    <tbody>
                                                    <tr>
                                                        <td align="center">
                                                            <table border="0" align="center" cellpadding="0"
                                                                   cellspacing="0" bgcolor="#1a1c21">
                                                                <tbody>
                                                                <tr>
                                                                    <td align="center" bgcolor="#1a1c21">
                                                                        <a href="https://play.google.com/store/apps/details?id=com.tokoterserah.mobile"><img
                                                                                class="zoom"
                                                                                src="{{asset('images/GooglePlay.png')}}"
                                                                                style="width: 15%"></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <a href="https://itunes.apple.com/id/app/tokoterserah.com/id1143444473?mt=8"><img
                                                                                class="zoom"
                                                                                src="{{asset('images/AppStore.png')}}"
                                                                                style="width: 15%"></a>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td align="center" valign="top" width="660" bgcolor="#1a1c21">
                                                <div style="font-size:25px;line-height:25px;">&nbsp;</div>
                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td align="center" valign="top" width="660" bgcolor="#1a1c21"
                                                style="font-family:Helvetica, arial,helv,sans-serif;font-size:12px;color:#F9F9F9;">
                                                Hubungi kami :)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="700">
                                                <table width="700" border="0" align="center" cellpadding="0"
                                                       cellspacing="0" bgcolor="#1a1c21" class="full-width">
                                                    <tbody>
                                                    <tr>
                                                        <td align="center">
                                                            <table border="0" align="center" cellpadding="0"
                                                                   cellspacing="0" bgcolor="#1a1c21">
                                                                <tbody>
                                                                <tr>
                                                                    <td align="center">
                                                                        <a href="https://fb.com/pages/PT-Penta-Surya-Pratama/102397424580976"
                                                                           name="Facebook" target="_blank">
                                                                            <img class="social-icons"
                                                                                 src="https://cdn.shazam.com/shazamauth/facebook.jpg"
                                                                                 width="34" height="50" alt="Facebook"
                                                                                 style="display:block" border="0"></a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#"
                                                                           name="Instagram" target="_blank"><img
                                                                                class="social-icons"
                                                                                src="https://cdn.shazam.com/shazamauth/instagram.jpg"
                                                                                width="39" height="50"
                                                                                style="display:block" border="0"
                                                                                alt="Instagram"></a>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td align="center" valign="top" width="660" bgcolor="#1a1c21">
                                                <div style="font-size:25px;line-height:25px;">&nbsp;</div>
                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td valign="top" width="700">
                                                <table width="700" border="0" align="center" cellpadding="0"
                                                       cellspacing="0" bgcolor="#1a1c21" class="full-width">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <table border="0" cellspacing="0" cellpadding="0"
                                                                   width="700" class="full-width" bgcolor="#1a1c21">
                                                                <tbody>
                                                                <tr>
                                                                    <td align="center"
                                                                        style="font-family:Helvetica, arial,helv,sans-serif;font-size:16px;color:#F9F9F9; font-weight:bold;"
                                                                        bgcolor="#1a1c21">
                                                                        <a class="footerlinks" target="_blank"
                                                                           style="color:#F9F9F9; text-decoration:none;"
                                                                           href="{{route('syarat-ketentuan')}}">Syarat &
                                                                            Ketentuan</a>
                                                                        <a class="footerlinks" target="_blank"
                                                                           style="color:#F9F9F9; text-decoration:none;"
                                                                           href="{{route('kebijakan-privasi')}}">Kebijakan
                                                                            Privasi</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td align="center" valign="top" width="660" bgcolor="#1a1c21">
                                                <div style="font-size:25px;line-height:25px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td align="center" valign="top" width="620" bgcolor="#1a1c21">
                                                <table width="93%" border="0" align="center" cellspacing="0"
                                                       cellpadding="0">
                                                    <tbody>
                                                    <tr>
                                                        <td align="center" height="1">
                                                            <table width="660" border="0" align="center" cellspacing="0"
                                                                   cellpadding="0" class="full-width">
                                                                <tbody>
                                                                <tr>
                                                                    <td align="center" height="1" bgcolor="#646464">
                                                                        <div style="font-size:1px;line-height:1px;">
                                                                            &nbsp;
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td align="center" valign="top" width="660" bgcolor="#1a1c21">
                                                <div style="font-size:25px;line-height:25px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td valign="top" width="700">
                                                <table width="700" border="0" align="center" cellpadding="0"
                                                       cellspacing="0" bgcolor="#1a1c21" class="full-width">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <table border="0" cellspacing="0" cellpadding="0"
                                                                   width="700" class="full-width" bgcolor="#1a1c21">
                                                                <tbody>
                                                                <tr>
                                                                    <td align="center" class="footer-padding"
                                                                        style="font-family:Helvetica, arial,helv,sans-serif;font-size:10px; color:#949494; font-weight:bold; padding-left:20px; padding-right:20px"
                                                                        bgcolor="#1a1c21">
                                                                        <span class="appleLinksWhite">© {{now()->format('Y').' '.env('APP_COMPANY')}}. All rights reserved. Jalan Raya Lontar No. 46 Surabaya – 60216.</span>
                                                                        <br>
                                                                        <div id="stat-div"
                                                                             style="visibility:hidden !important;"
                                                                             height="0px">
                                                                            <img id="stat-link"
                                                                                 src="https://www.shazam.com/validate-email/email-view?email=matt@reallygoodemails.com"
                                                                                 alt="" border="0" width="0px"
                                                                                 height="0px"
                                                                                 style="visibility:hidden !important;">
                                                                        </div>
                                                                        <br>
                                                                        <br>
                                                                        <br></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
