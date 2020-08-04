<!DOCTYPE html>
@php
    app()->setLocale('id');
    \Carbon\Carbon::setLocale('id');
    setlocale(LC_TIME, config('app.locale'));
   // $cart = $order->getCart;
    //$product = !is_null($cart->subkategori_id) ? $cart->getSubKategori : $cart->getCluster;
    //$specs = !is_null($cart->subkategori_id) ? $cart->getSubKategori->getSubkatSpecs : $cart->getCluster->getClusterSpecs;
@endphp
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LABEL | INVOICE #</title>
    <style>
        html, body {
            font-family: sans-serif;
            font-size: 8pt;
        }

        #invoice {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        #billship, #company {
            margin-bottom: 30px
        }

        #company img {
            max-width: 180px;
            height: auto
        }

        #co-left {
            padding: 10px;
            font-size: 8pt;
            color: #888
        }

        #co-right {
            vertical-align: center
        }

        #co-right div {
            float: right;
            text-align: center;
            font-size: 8pt;
            padding: 10px;
            color: #fff;
            width: 240px;
            background: #5bb300;
        }

        #items td, #items th {
            font-size: 8pt;
            font-weight: 400;
            border-bottom: 3px solid #fff
        }

        #billship td, #items td, #items th, #notes {
            padding: 10px
        }

        #specs {
            font-size: 8pt;
            margin: 1em 0;
        }

        #specs td, #specs th {
            border-bottom: none;
            padding: 0;
        }

        .primary {
            color: #5bb300;
        }

        #billship, #company, #items {
            width: 100%;
            border-collapse: collapse
        }

        #billship td {
            width: 33%
        }

        #items th {
            color: #fff;
            background: #5bb300;
            text-align: left
        }

        #items td {
            background: #fff5e6
        }

        .idesc {
            background: #5bb300;
        }

        .ttl {
            background: #5bb300;
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

        #notes {
            background: #fff5e6;
            margin-top: 30px
        }

    </style>
</head>
<body>
<div id="invoice" style="border:1px solid black;">
    <!-- Header -->
    <table id="company" style="margin-bottom: 0">
        <tr>
            <td>
                <img src="{{public_path('images/logotype.png')}}" alt="logo"
                     style="margin-bottom: 0;width: 80px">
            </td>
            <td style="color: white">asdasdasdasdasdasdasdasdasd</td>
            <td align="left">
                <div class="uppercase" style="
                text-align: center;
                font-size: 8pt;
                padding: 5px;
                color: #fff;
                width: auto !important;
                background: #5bb300;">{{$data->resi}}</div>
            </td>
        </tr>
    </table>
    <!-- Origin -->
    <table id="company" style="margin-bottom: 0" width="100%">
        <tr>
            <td>
                <div id="co-left" style="margin-top: 0">
                    {{env('APP_TITLE')}}<br>Jl. Raya Lontar No. 46 Surabaya – 60216<br>
                    Surabaya, Jawa Timur &ndash; 60216<br>
                    Phone: +62 811-3051-081<br>
                </div>
                <br>
                <div class="uppercase" style="
                text-align: center;
                font-size: 8pt;
                padding: 5px;
                color: #fff;
                width: 240px;
                background: #5bb300;">#{{$data->uni_code}}</div>
            </td>

            <td align="center">
                <div style="background: transparent">

                </div>

            </td>
        </tr>
    </table>
    <hr>
    <!-- Destination -->
    <table id="">
        <tr>
            <td id="co-left" style="font-size: 10px">
                <b class="primary">Penerima</b><br>
                {{$data->getUser->name}} <br>
                {{$data->getPengiriman->alamat}} Kec.{{$data->getPengiriman->getKecamatan->nama}}
                ( {{$data->getPengiriman->kode_pos}}
                ) <br>
                Telepon: {{$data->getUser->getBio->phone}}<br>
                Pembayaran: {{\Carbon\Carbon::parse($data->updated_at)->formatLocalized('%d %B %Y pukul %H:%I')}}

            </td>
            <td style="font-size: 14px">
            </td>
        </tr>
    </table>
    <hr>

    <!-- Item -->
    <table id="items" style="font-size: 14px;margin-top: 0">
        <thead>
        <tr>
            <th><b>Produk </b></th>
            <th class="center"><b>Qty.</b></th>
            <th class="center"><b>Berat (gr)</b></th>
        </tr>
        </thead>
        <tbody>

        @foreach($data->keranjang_ids as $item)
            <?
            $produk = \App\Models\Keranjang::find($item);

            ?>
            <tr>
                <td>{{$produk->getProduk->nama}}</td>
                <td align="center">{{$produk->qty}} pcs</td>
                <td align="center">{{$produk->berat}} </td>
            </tr>
            <?

            ?>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2" align="right"><strong>Total Berat :</strong></td>
            <td align="center">{{$data->berat_barang}}
                <small>gr </small></td>
        </tr>
        <tr>
            <td align="right" colspan="2"><strong>Kurir / Jenis :</strong></td>
            <td align="center">{{$data->nama_kurir}} /{{$data->layanan_kurir}}

            </td>
        </tr>

        <tr>
            <td align="right" colspan="2"><strong>Biaya Kirim :</strong></td>
            <td align="center">Rp {{number_format($data->ongkir)}}</td>
        </tr>
        </tfoot>
    </table>

</div>
</body>
</html>
