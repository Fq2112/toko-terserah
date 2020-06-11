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
            window.location.href = '{{route('user.profil', ['check' => 'false'])}}';
        }
    });

    @elseif(session('contact'))
    swal('SUKSES!', '{{session('contact')}}', 'success');

    @elseif(session('activated'))
    swal('SUKSES!', '{{session('activated')}}', 'success');

    @elseif(session('inactive'))
    swal('KESALAHAN!', '{{session('inactive')}}', 'error');

    @elseif(session('signed'))
    swal('SUKSES!', 'Halo, {{Auth::guard('admin')->check() ?
    Auth::guard('admin')->user()->name : Auth::user()->name}}! Anda telah masuk.', 'success');

    @elseif(session('token'))
    swal('KESALAHAN!', '{{session('token')}}', 'error');

    @elseif(session('expire'))
    swal('KESALAHAN!', '{{session('expire')}}', 'error');

    @elseif(session('logout'))
    swal('PERHATIAN!', '{{session('logout')}}', 'warning');

    @elseif(session('warning'))
    swal('PERHATIAN!', '{{session('warning')}}', 'warning');

    @elseif(session('register'))
    swal('SUKSES!', '{{session('register')}}', 'success');

    @elseif(session('unknown'))
    swal('KESALAHAN!', '{{session('unknown')}}', 'error');

    @elseif(session('add'))
    swal('SUKSES!', '{{session('add')}}', 'success');

    @elseif(session('update'))
    swal('SUKSES!', '{{session('update')}}', 'success');

    @elseif(session('delete'))
    swal('SUKSES!', '{{session('delete')}}', 'success');

    @elseif(session('error'))
    swal('KESALAHAN!', '{{session('error')}}', 'error');
    @endif

    @if (count($errors) > 0)
    @foreach ($errors->all() as $error)
    swal('Oops..!', '{{$error}}', 'error');
    @endforeach
    @endif
</script>
