<script>
    $(".delete-data").on('click', function () {
        var linkURL = $(this).attr("href");
        swal({
            title: 'Apakah Anda yakin?',
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

    $(".btn_signOut").on('click', function () {
        swal({
            title: 'Keluar',
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
</script>
