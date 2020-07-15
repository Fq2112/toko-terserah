<script>
    $(function () {
        window.mobilecheck() ? $("body").removeClass('use-nicescroll') : '';

        window.FontAwesomeConfig = {
            searchPseudoElements: true
        };

        Scrollbar.initAll();

        $('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});

        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();

        $(".use-select2").select2({
            placeholder: "-- Pilih --",
            allowClear: true,
            width: '100%',
        });

        $(".rupiah").maskMoney({thousands: '.', decimal: ',', precision: 0});

        function reposition() {
            var modal = $(this),
                dialog = modal.find('.modal-dialog');
            modal.css('display', 'block');
            dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
        }

        $('.modal').on('show.bs.modal', reposition);
        $(window).on('resize', function () {
            $('.modal:visible').each(reposition);
        });

        @if(session('register') || session('error') || session('logout') || session('expire') || session('inactive') ||
            session('unknown') || session('recovered'))
        openLoginModal();
        @elseif($errors->has('email') || $errors->has('password') || $errors->has('name'))
        openRegisterModal();
        @elseif(session('resetLink') || session('resetLink_failed'))
        openEmailModal();
        @elseif(session('reset') || session('recover_failed'))
        openPasswordModal();
        @endif
    });

    function cariKategori(nama, permalink) {
        $("#search_concept").text(nama);
        $("#form-cari input[name=kat]").val(permalink);
        $("#form-cari button[type=reset]").show();
    }

    $("#form-cari input[name=q]").on("keyup", function () {
        if (!$(this).val() && $("#form-cari input[name=kat]").val() == 'semua') {
            $("#form-cari")[0].reset();
        } else {
            $("#form-cari button[type=reset]").show();
        }
    });

    $("#form-cari").on("reset", function () {
        $("#search_concept").text('Semua Kategori');
        $("#form-cari input[name=kat]").val('semua');
        $("#form-cari button[type=reset]").hide();
    });

    var recaptcha_register, recaptchaCallback = function () {
        recaptcha_register = grecaptcha.render(document.getElementById('recaptcha-register'), {
            'sitekey': '{{env('reCAPTCHA_v2_SITEKEY')}}',
            'callback': 'enable_btnRegister',
            'expired-callback': 'disabled_btnRegister'
        });
    };

    function enable_btnRegister() {
        $("#btn_register").removeAttr('disabled');
    }

    function disabled_btnRegister() {
        $("#btn_register").attr('disabled', 'disabled');
    }

    $("#reg_username").on('blur', function () {
        $.get('{{route('cek.username')}}?username=' + $("#reg_username").val(), function (data) {
            if (data == 1) {
                $("#reg_errorAlert").html(
                    '<div class="alert alert-danger alert-dismissible">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                    '<h4><i class="icon fa fa-times"></i> Error!</h4>Username tersebut telah digunakan!</div>'
                );
                $(".btn-register").attr('disabled', 'disabled');

            } else {
                $("#reg_errorAlert").html('');
                $(".btn-register").removeAttr('disabled');
            }
        });
    });

    $("#form-register").on("submit", function (e) {
        if (grecaptcha.getResponse(recaptcha_register).length === 0) {
            e.preventDefault();
            swal('PERHATIAN!', 'Mohon klik kotak dialog reCAPTCHA berikut.', 'warning');
        }

        if ($.trim($("#reg_email,#reg_name,#reg_username,#reg_password,#reg_password_confirm").val()) === "") {
            return false;

        } else {
            if ($("#reg_password_confirm").val() != $("#reg_password").val()) {
                return false;

            } else {
                $("#reg_errorAlert").html('');
                return true;
            }
        }
    });

    $("#reg_password_confirm").on("keyup", function () {
        if ($(this).val() != $("#reg_password").val()) {
            $("#reg_errorAlert").html(
                '<div class="alert alert-danger alert-dismissible">' +
                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                '<h4><i class="icon fa fa-times"></i> Error!</h4>Konfirmasi password Anda tidak cocok!</div>'
            );
        } else {
            $("#reg_errorAlert").html('');
        }
    });

    function checkForgotPassword() {
        var new_pas = $("#forg_password").val(),
            re_pas = $("#forg_password_confirm").val();
        if (new_pas != re_pas) {
            $("#forg_errorAlert").html(
                '<div class="alert alert-danger alert-dismissible">' +
                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                '<h4><i class="icon fa fa-times"></i> Error!</h4>Konfirmasi password Anda tidak cocok!</div>'
            );
            $(".btn-password").attr('disabled', 'disabled');

        } else {
            $("#forg_errorAlert").html('');
            $(".btn-password").removeAttr('disabled');
        }
    }

    $("#form-recovery").on("submit", function (e) {
        if ($("#forg_password_confirm").val() != $("#forg_password").val()) {
            $(".btn-password").attr('disabled', 'disabled');
            return false;

        } else {
            $("#forg_errorAlert").html('');
            $(".btn-password").removeAttr('disabled');
            return true;
        }
    });

    $('#log_password + .glyphicon').on('click', function () {
        $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
        $('#log_password').togglePassword();
    });

    $('#reg_password + .glyphicon').on('click', function () {
        $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
        $('#reg_password').togglePassword();
    });

    $('#reg_password_confirm + .glyphicon').on('click', function () {
        $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
        $('#reg_password_confirm').togglePassword();
    });

    $('#forg_password + .glyphicon').on('click', function () {
        $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
        $('#forg_password').togglePassword();
    });

    $('#forg_password_confirm + .glyphicon').on('click', function () {
        $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
        $('#forg_password_confirm').togglePassword();
    });

    function showRegisterForm() {
        $('.loginBox, .emailBox, .passwordBox').fadeOut('fast', function () {
            $('.registerBox').fadeIn('fast');
            $('.login-footer').fadeOut('fast', function () {
                $('.register-footer').fadeIn('fast');
            });
            $('.modal-title').html('Sign Up');
        });
        $('.error').removeClass('alert alert-danger').html('');
    }

    function showLoginForm() {
        $('#loginModal .registerBox, .emailBox, .passwordBox').fadeOut('fast', function () {
            $('.loginBox').fadeIn('fast');
            $('.register-footer').fadeOut('fast', function () {
                $('.login-footer').fadeIn('fast');
            });
            $('.modal-title').html('Sign In');
        });
        $('.error').removeClass('alert alert-danger').html('');
    }

    function showWishlist() {
        @auth
            window.location.href = '{{route('user.wishlist')}}';
        @elseauth('admin')
        swal('PERHATIAN!', 'Fitur ini hanya berfungsi ketika Anda masuk sebagai Pelanggan.', 'warning');
        @else
        openLoginModal();
        @endauth
    }

    function thousandSeparator(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    }

    function numberOnly(e, decimal) {
        var key;
        var keychar;
        if (window.event) {
            key = window.event.keyCode;
        } else if (e) {
            key = e.which;
        } else return true;
        keychar = String.fromCharCode(key);
        if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13) || (key == 27) || (key == 188)) {
            return true;
        } else if ((("0123456789").indexOf(keychar) > -1)) {
            return true;
        } else if (decimal && (keychar == ".")) {
            return true;
        } else return false;
    }

    var title = document.getElementsByTagName("title")[0].innerHTML;
    (function titleScroller(text) {
        document.title = text;
        setTimeout(function () {
            titleScroller(text.substr(1) + text.substr(0, 1));
        }, 500);
    }(title + " ~ "));

    <!--Scroll to top button-->
    var $goToTopEl = $('#gotoTop');
    window.onscroll = function () {
        scrollFunction()
    };

    function scrollFunction() {
        var elementMobile = $goToTopEl.attr('data-mobile'),
            elementOffset = $goToTopEl.attr('data-offset');

        if (!elementOffset) {
            elementOffset = 100;
        }

        if ($(window).scrollTop() > Number(elementOffset)) {
            $goToTopEl.fadeIn();
            $('body').addClass('gototop-active');
        } else {
            $goToTopEl.fadeOut();
            $('body').removeClass('gototop-active');
        }
    }

    function scrollToTop() {
        var elementScrollSpeed = $goToTopEl.attr('data-speed'),
            elementScrollEasing = $goToTopEl.attr('data-easing');

        if (!elementScrollSpeed) {
            elementScrollSpeed = 700;
        }
        if (!elementScrollEasing) {
            elementScrollEasing = 'easeOutQuad';
        }

        $goToTopEl.off('click').on('click', function () {
            $('body,html').stop(true).animate({
                'scrollTop': 0
            }, Number(elementScrollSpeed), elementScrollEasing);
            return false;
        });
    }

    <!--end:Scroll to top button-->

    <!--Scroll Progress Bar-->
    function progress() {

        var windowScrollTop = $(window).scrollTop();
        var docHeight = $(document).height();
        var windowHeight = $(window).height();
        var progress = (windowScrollTop / (docHeight - windowHeight)) * 100;
        var $bgColor = progress > 99 ? '#5bb300' : '#488f00';
        var $textColor = progress > 99 ? '#fff' : '#333';

        $('.myProgress .bar').width(progress + '%').css({backgroundColor: $bgColor});
        // $('h1').text(Math.round(progress) + '%').css({color: $textColor});
        $('.fill').height(progress + '%').css({backgroundColor: $bgColor});
    }

    progress();

    $(document).on('scroll', progress);

    window.onload = function () {
        scrollToTop();

        $('.images-preloader').fadeOut();

        $(".use-nicescroll").niceScroll({
            cursorcolor: "rgb(91,179,0)",
            cursorwidth: "8px",
            background: "rgba(222, 222, 222, .75)",
            cursorborder: 'none',
            horizrailenabled: false,
            autohidemode: 'leave',
            zindex: 9999999,
        });

        var options = {
            whatsapp: "+628113051081",
            email: "{{env('MAIL_USERNAME')}}",
            call_to_action: "Hubungi Kami",
            button_color: "#5bb300",
            position: "left",
            order: "email,whatsapp",
        };
        var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () {
            WhWidgetSendButton.init(host, proto, options);
        };
        var x = document.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(s, x);
    };

    $(document).on('mouseover', '.use-nicescroll', function () {
        $(this).getNiceScroll().resize();
    });
</script>
