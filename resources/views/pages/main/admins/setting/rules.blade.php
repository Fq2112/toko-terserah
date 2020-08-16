<form id="setting-form" enctype="multipart/form-data" method="post"
      action="{{route('admin.setting.rules.update')}}">
    {{csrf_field()}}

    <div class="card-body">
        <p class="text-muted">Atur Harga pengiriman dan minimum harga untuk penngiriman di sini.</p>
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
    </div>
    <div class="card-footer bg-whitesmoke text-md-right">
        <button class="btn btn-primary" id="save-btn">Save Changes</button>
    </div>
</form>


