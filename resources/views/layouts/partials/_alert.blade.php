<script>
    @if(session('profil'))
    swal({
        title: "PERHATIAN!",
        text: "{{session('profil')}}",
        icon: 'warning',
        closeOnEsc: false,
        closeOnClickOutside: false,
    }).then((confirm) => {
        if (confirm) {
            swal({icon: "success", text: 'Anda akan dialihkan ke halaman Sunting Profil.', buttons: false});
            window.location.href = '{{route('user.profil')}}';
        }
    });

    @elseif(session('signed'))
    swal('Telah Masuk!', 'Halo {{Auth::user()->name}}! Anda telah masuk.', 'success');

    @elseif(session('expire'))
    swal('Autentikasi Dibutuhkan!', '{{ session('expire') }}', 'error');

    @elseif(session('logout'))
    swal('Telah Keluar!', '{{ session('logout') }}', 'warning');

    @elseif(session('status'))
    swal('Sukses!', '{{ session('status') }}', 'success', '3500');

    @elseif(session('create'))
    swal('Sukses!', '{{ session('create') }}', 'success');

    @elseif(session('update'))
    swal('Sukses!', '{{ session('update') }}', 'success');

    @elseif(session('delete'))
    swal('Sukses!', '{{ session('delete') }}', 'success');

    @elseif(session('warning'))
    swal('PERHATIAN!', '{{ session('warning') }}', 'warning');

    @elseif(session('gagal'))
    swal('ERROR!', '{{ session('gagal') }}', 'error');

    @elseif(session('success'))
    swal('Sukses!', '{{ session('success') }}', 'success');

    @elseif(session('hire_me'))
    swal('Sukses!', '{{ session('hire_me') }}', 'success');

    @elseif(session('invite_to_bid'))
    swal('Sukses!', '{{ session('invite_to_bid') }}', 'success');
    @endif

    @if (count($errors) > 0)
    @foreach ($errors->all() as $error)
    swal('Oops..!', '{{ $error }}', 'error');
    @endforeach
    @endif
</script>
