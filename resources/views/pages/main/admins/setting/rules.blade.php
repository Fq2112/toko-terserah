<form id="setting-form" enctype="multipart/form-data" method="post"
      action="{{route('admin.setting.rules.update')}}">
    {{csrf_field()}}

    <div class="card-body">
        <p class="text-muted">Atur Harga pengiriman, minimum harga ,harga packing untuk penngiriman di sini.</p>
        <div class="form-group row align-items-center">
            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Harga Pengiriman</label>
            <div class="col-sm-6 col-md-9">
                <input type="number" name="harga_pengiriman" class="form-control" id="site-title" required placeholder="in percent" value="{{$data->harga_pengiriman}}"
                       >

            </div>
        </div>
        <div class="form-group row align-items-center">
            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Minim Pembelian</label>
            <div class="col-sm-6 col-md-9">
                <input type="number" name="min_pembelian" class="form-control" id="site-title" required placeholder="in percent" value="{{$data->min_pembelian}}"
                       >
                <input type="hidden" name="id" value="{{$data->id}}">
            </div>
        </div>

        <div class="form-group row align-items-center">
            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Minim Transaksi Packing</label>
            <div class="col-sm-6 col-md-9">
                <input type="number" name="min_transaction" class="form-control" id="site-title" required placeholder="in percent" value="{{$data->min_transaction}}"
                >
            </div>
        </div>

        <div class="form-group row align-items-center">
            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Harga Packing</label>
            <div class="col-sm-6 col-md-9">
                <input type="number" name="packing" class="form-control" id="site-title" required placeholder="in percent" value="{{$data->packing}}"
                >
            </div>
        </div>

        <div class="form-group row align-items-center">
            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Deskripsi Packing</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" name="packing_desc" class="form-control" id="site-title" required placeholder="in percent" value="{{$data->packing_desc}}"
                >
            </div>
        </div>

        <div class="form-group row align-items-center">
            <label for="site-title" class="form-control-label col-sm-3 text-md-right">Presentase Penambahan Berat (%)</label>
            <div class="col-sm-6 col-md-9">
                <input type="number" name="percent_weight" class="form-control" id="site-title" min="1" max="99" required placeholder="in percent" value="{{$data->percent_weight}}"
                >
            </div>
        </div>

    </div>
    <div class="card-footer bg-whitesmoke text-md-right">
        <button class="btn btn-primary" id="save-btn">Save Changes</button>
    </div>
</form>


