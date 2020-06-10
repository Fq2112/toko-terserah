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

    function actionOrder(name, edit_uri, delete_uri) {
        swal({
            title: 'Cart',
            text: 'Apakah Anda ingin menyunting pesanan produk cetak [' + name + '] ini atau menghapusnya dari cart Anda?',
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
                swal({icon: "success", buttons: false});
                window.location.href = edit_uri;
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
</script>
