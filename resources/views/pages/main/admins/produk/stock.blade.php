<p id="stock-{{$item->id}}">{{$item->stock}}</p>
<form action="{{route('admin.show.produk.stock')}}" method="post"
      style="display: none"
      id="form_{{$item->id}}">
    {{csrf_field()}}
    <input type="hidden" name="id_produk" id="" value="{{$item->id}}"
           required>
    <div class="input-group">
        <input type="number" name="stock_produk" id=""
               class="form-control"
               min="{{$item->stock == 0 ? 1:$item->stock}}"
               value="{{$item->stock}}" required>
        <div class="input-group-append">
            <button data-placement="right" data-toggle="tooltip"
                    title="Tambah Data"
                    type="submit" class="btn btn-primary"
                    style="height: 2.25rem">
                <i class="fa fa-plus"></i></button>
        </div>
    </div>
</form>
