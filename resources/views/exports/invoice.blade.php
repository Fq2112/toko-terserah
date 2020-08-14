<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FAKTUR #{{$code}}</title>
    <style>
        html, body {
            font-family: sans-serif;
        }

        #invoice {
            max-width: 800px;
            margin: 0 auto
        }

        #billship, #company, #msc {
            margin-bottom: 30px
        }

        #company img {
            max-width: 180px;
            height: auto
        }

        #co-left {
            padding: 10px;
            font-size: .95em;
            color: #888
        }

        #co-right {
            vertical-align: center
        }

        #co-right div {
            float: right;
            text-align: center;
            font-size: 28px;
            padding: 10px;
            color: #fff;
            width: 240px;
            background: #5bb300;
        }

        #items td, #items th {
            font-weight: 400;
            border-bottom: 3px solid #fff
        }

        #billship td, #msc td, #items td, #items th {
            padding: 10px
        }

        #specs {
            font-size: 14px;
            margin: 1em 0;
        }

        #specs td, #specs th {
            border-bottom: none;
            padding: 0;
        }

        .primary {
            color: #5bb300;
        }

        #billship, #company, #items, #msc {
            width: 100%;
            border-collapse: collapse
        }

        #billship td, #msc td {
            width: 33%
        }

        #items th {
            color: #fff;
            background: #5bb300;
            text-align: left
        }

        #items td {
            background: #e1fdc6
        }

        .idesc {
            color: #488f00
        }

        .ttl {
            color: #2d5800
        }

        .center {
            text-align: center !important;
        }

        .right {
            text-align: right !important;
        }

        .uppercase {
            text-transform: uppercase !important;
        }
    </style>
</head>
<body>
<div id="invoice">
    <table id="company">
        <tr>
            <td>
                <img src="{{public_path('images/logotype.png')}}" alt="logo">
                <div id="co-left">
                    {{env('APP_NAME')}}<br>Jl. Raya Lontar No. 46<br>
                    Surabaya, Jawa Timur &ndash; 60216<br>
                    Telepon: +62 811-3051-081<br>
                    {{env('APP_URL')}}<br>{{env('MAIL_USERNAME')}}
                </div>
            </td>
            <td id="co-right">
                <div class="uppercase">FAKTUR</div>
                <br><br><br><br><br>
                <div style="background: none">
                    <img src="{{$data->isLunas == true ? public_path('images/stamp_paid.png') :
                    public_path('images/stamp_unpaid.png')}}" alt="logo">
                </div>
            </td>
        </tr>
    </table>

    <table id="billship">
        <tr>
            <td>
                <b class="primary">Kepada Yth.</b><br>
                {{$data->getPenagihan->nama}}<br>
                {{$data->getPenagihan->alamat}}
            </td>
            <td>
                <b class="primary">Dikirim Ke</b><br>
                {{$data->getPengiriman->nama}}<br>
                {{$data->getPengiriman->alamat}}
            </td>
            <td>
                <b class="primary">FAKTUR #:</b> {{$code}}<br>
                <b class="primary">DOP:</b> {{now()->formatLocalized('%d %B %Y')}}<br>
                <b class="primary">P.O. #:</b> {{str_pad($data->id,14,0,STR_PAD_LEFT)}}<br>
                <b class="primary">Due Date:</b> {{now()->addDay()->formatLocalized('%d %B %Y')}}
            </td>
        </tr>
    </table>

    <table id="items">
        <thead>
        <tr>
            <th><b>Produk</b></th>
            <th class="center"><b>Qty.</b></th>
            <th class="center"><b>Harga /pcs</b></th>
            <th class="center"><b>Berat</b></th>
            <th class="center"><b>Total</b></th>
        </tr>
        </thead>
        <tbody>
        @php $subtotal = 0; @endphp
        @foreach(\App\Models\Keranjang::whereIn('id', $data->keranjang_ids)->get() as $cart)
            @php
                $produk = $cart->getProduk;
                $subtotal += $cart->total;
                $weight = ($produk->berat / 1000) * $cart->qty;
            @endphp
            <tr>
                <td><b>{{$produk->nama}}</b></td>
                <td class="center">{{$cart->qty}}</td>
                <td class="center">
                    Rp{{number_format($produk->is_diskon == true ? $produk->harga_diskon : $produk->harga,2,',','.')}}</td>
                <td class="center">{{number_format($weight,2,',','.')}} kg</td>
                <td class="right">Rp{{number_format($cart->total,2,',','.')}}</td>
            </tr>
        @endforeach
        @php $discount_price = $data->is_discount == true ? ceil($data->discount) : 0; @endphp
        <tr class="ttl">
            <td class="right" colspan="4">SUBTOTAL</td>
            <td class="right">Rp{{number_format($subtotal,2,',','.')}}</td>
        </tr>
        <tr class="ttl">
            <td class="right uppercase" colspan="4">Diskon</td>
            <td class="right">{{'-Rp'.number_format($discount_price,2,',','.')}}</td>
        </tr>
        <tr class="ttl">
            <td class="right uppercase" colspan="4">Ongkir</td>
            <td class="right">Rp{{number_format($data->ongkir,2,',','.')}}</td>
        </tr>
        <tr class="ttl">
            <td class="right" colspan="4">GRAND TOTAL</td>
            <td class="right">Rp{{number_format($subtotal - $discount_price + $data->ongkir,2,',','.')}}</td>
        </tr>
        </tbody>
    </table>

    <table id="msc" style="background: #fff5e6;margin-top: 30px">
        <tr>
            <td><b class="primary">METODE PEMBAYARAN</b></td>
            <td><b class="primary">OPSI PENGIRIMAN</b></td>
        </tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td width="50%">
                            <img width="150" alt="{{$payment['bank']}}"
                                 src="{{public_path('images/paymentMethod/'.$payment['bank'].'.png')}}">
                        </td>
                        <td>
                            {{strtoupper(str_replace('_',' ',$payment['type']))}}
                            @if($payment['type'] == 'credit_card' || $payment['type'] == 'bank_transfer' || $payment['type'] == 'cstore')
                                <br>{{$payment['account']}}
                                @if($payment['type'] == 'bank_transfer')
                                    <br>a/n {{env('APP_NAME')}}
                                @endif
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td width="50%"><img alt="Logo" src="{{public_path('images/kurir/'.$data->kode_kurir.'.png')}}">
                        </td>
                        <td>{{$data->nama_kurir}}<br>{{$data->layanan_kurir}}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
