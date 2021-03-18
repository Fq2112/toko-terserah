<div class="btn-group">
    <button class="btn btn-warning"
            data-toggle="tooltip" title="Barcode Produk"
            onclick="show_barcode_product('{{$item->id}}')">
        <span class="fa fa-barcode"></span></button>
    <a href="javascript:void(0)" class="btn btn-success"
       data-toggle="tooltip" onclick="show_input('{{$item->id}}')"
       title="Tambah Stok Barang"><i class="fa fa-plus-square"></i> </a>
    <a href="{{route('admin.show.produk.edit',['kode_barang'=>encrypt($item->id)])}}"
       class="btn btn-info" data-toggle="tooltip"
       title="Sunting Barang"><i class="fa fa-edit"></i> </a>
    <a href="{{route('delete.produk',['id' => $item->id])}}"
       class="btn btn-danger  delete-data" data-toggle="tooltip"
       title="Hapus Barang"><i class="fa fa-trash"></i> </a>
</div>
