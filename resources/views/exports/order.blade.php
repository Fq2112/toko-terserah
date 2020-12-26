<style>
    html, body {
        font-family: sans-serif;
        font-size: 12pt;
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

    table, th, td {
        border: 1px solid black;
    }

</style>
<h2>Laporan Pesanan Toko Terserah </h2>
<table>
    <thead>
    <tr>
        <th>No.</th>
        <th>Customer</th>
        <th>Tgl Transaksi</th>
        <th width="300px">Detail Pesanan</th>

        <th width="300px">Detail Kurir</th>

        <th>Status</th>
        <th>Total</th>
    </tr>

    </thead>
    <tbody>
    @foreach($data as $item)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$item->getUser->name}} <br> ( {{$item->getUser->getBio->phone}} )</td>
            <td>{{$item->updated_at}}</td>
            <td width="300px">
                <strong> {{$item->uni_code}}</strong>
                <?php
                $carts = \App\Models\Keranjang::query()->whereIn('id', $item->keranjang_ids)->get()
                ?>
                <table style=" font-size: 11pt !important;">
                    @foreach($carts as $cart)
                        <tr>
                            <td>{{$cart->getProduk->nama}}</td>
                            <td> {{$cart->qty}} pcs</td>
                            <td> Rp {{number_format($cart->total)}}</td>
                        </tr>
                    @endforeach
                </table>

            </td>
            <td width="300px">
                tujuan : {{$item->getPengiriman->alamat}} <br>
                Penagihan : {{$item->getPenagihan->alamat}} <br>

                Kode kurir : {{$item->kode_kurir ?? ' - '}}<br>
                Layanan    : {{$item->layanan_kurir ?? ' - '}}<br>
                Resi       : {{$item->resi ?? ' - '}}<br>
                Berat      : {{$item->berat_barang ?? ' - '}} gr<br>
                Ongkir     : {{number_format($item->ongkir)}}<br>
            </td>
            <td>
                @if($item->isLunas == 1)
                   Telah Dibayarkan
                @else
                    Belum Dibaayarkan
                @endif
            </td>
            <td align="center">Rp{{number_format($item->total_harga)}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
