<script>
    $(".delete-data").on('click', function () {
        var linkURL = $(this).attr("href");
        swal({
            title: "Apakah Anda yakin?",
            text: "Anda tidak dapat mengembalikannya!",
            icon: 'warning',
            dangerMode: true,
            buttons: ["Tidak", "Ya"],
            closeOnEsc: false,
            closeOnClickOutside: false,
        }).then((confirm) => {
            if (confirm) {
                swal({icon: "success", buttons: false});
                window.location.href = linkURL;
            }
        });
        return false;
    });

    $(".btn_signOut").click(function () {
        swal({
            title: "Sign Out",
            text: "Apakah Anda yakin untuk mengakhiri sesi Anda?",
            icon: 'warning',
            dangerMode: true,
            buttons: ["Tidak", "Ya"],
            closeOnEsc: false,
            closeOnClickOutside: false,
        }).then((confirm) => {
            if (confirm) {
                swal({icon: "success", text: 'Anda akan dialihkan ke halaman Beranda.', buttons: false});
                $("#logout-form").submit();
            }
        });
        return false;
    });

    function actionOrder(name, min_qty, stock, qty, cek_uri, edit_uri, delete_uri) {
        swal({
            title: 'Cart',
            text: 'Apakah Anda ingin mengubah kuantitas produk [' + name + '] ini atau menghapusnya dari cart Anda?',
            icon: 'warning',
            dangerMode: true,
            buttons: {
                cancel: 'Batal',
                edit: {
                    text: 'Sunting',
                    value: 'edit',
                },
                delete: {
                    text: 'Hapus',
                    value: 'delete',
                }
            },
            closeOnEsc: false,
            closeOnClickOutside: false,
        }).then((value) => {
            if (value == 'edit') {
                let input = document.createElement("input");
                input.id = 'qty-cart';
                input.value = qty;
                input.type = 'number';
                input.min = min_qty;
                input.max = parseInt(stock) + parseInt(qty);
                input.className = 'swal-content__input';

                swal({
                    text: 'Sunting Kuantitas: ' + name,
                    content: input,
                    dangerMode: true,
                    buttons: ["Batal", "Simpan Perubahan"],
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                }).then(val => {
                    if (!val) throw null;
                    $("#form-cart input[name=_method]").val('PUT');
                    $("#form-cart input[name=qty_lama]").val(qty);
                    $("#form-cart input[name=qty]").val($("#qty-cart").val());
                    $("#form-cart").attr('action', edit_uri).submit();
                });

                if (stock > 0) {
                    $("#qty-cart").parent().append("<p class='text-success'>Tersedia: <b>" + stock + "</b> pcs</p>");
                } else {
                    $("#qty-cart").parent().append("<p class='text-danger'>Tersedia: <b>" + stock + "</b> pcs</p>");
                }

                $("#qty-cart").on('keyup', function () {
                    var el = $(this);
                    if (!el.val() || el.val() == "" || parseInt(el.val()) <= 0) {
                        el.val(qty);
                    }

                    $.get(cek_uri, function (data) {
                        el.attr('max', parseInt(data.stock) + parseInt(qty)).attr('min', data.min_qty);
                        el.parent().find('p').remove();

                        if (parseInt(el.val()) > parseInt(data.stock) + parseInt(qty)) {
                            el.parent().append("<p class='text-success'>Tersedia: <b>" + data.stock + "</b> pcs</p>");
                            el.val(parseInt(data.stock) + parseInt(qty));
                        }
                        if(parseInt(el.val()) < data.min_qty) {
                            el.parent().append("<p class='text-danger'>Pembelian minimal: <b>" + data.min_qty + "</b> pcs</p>");
                            el.val(data.min_qty);
                        }
                    });
                });

            } else if (value == 'delete') {
                swal({
                    title: "Apakah Anda yakin?",
                    text: "Anda tidak dapat mengembalikannya!",
                    icon: 'warning',
                    dangerMode: true,
                    buttons: ["Tidak", "Ya"],
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                }).then((confirm) => {
                    if (confirm) {
                        swal({icon: "success", buttons: false});
                        window.location.href = delete_uri;
                    }
                });
            } else {
                swal.close();
            }
        });
    }

    function checkout(total) {
        swal({
            title: "Checkout Cart",
            text: 'Apakah Anda yakin akan checkout ' + total + ' item tersebut?',
            icon: 'warning',
            dangerMode: true,
            buttons: ["Tidak", "Ya, checkout sekarang!"],
            closeOnEsc: false,
            closeOnClickOutside: false,
        }).then((confirm) => {
            if (confirm) {
                swal({icon: "success", buttons: false});
                $("#form-cart_ids").submit();
            }
        });
    }
</script>
