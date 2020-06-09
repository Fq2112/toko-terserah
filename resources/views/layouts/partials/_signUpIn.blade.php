<div class="modal fade login" id="loginModal">
    <div class="modal-dialog login animated">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" data-toc-skip>Masuk</h4>
            </div>
            <div class="modal-body">
                <!-- Sign in form -->
                <div class="box">
                    <div class="">
                        <div class="error"></div>
                        <div class="form loginBox">
                            @if(session('success') || session('recovered'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                    </button>
                                    <h4><i class="icon fa fa-check"></i> Alert!</h4>
                                    {{session('success') ? session('success') : session('recovered')}}
                                </div>
                            @elseif(session('error'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                    </button>
                                    <h4><i class="icon fa fa-times"></i> Alert!</h4>
                                    {{session('error')}}
                                </div>
                            @endif
                            <form method="post" accept-charset="UTF-8" class="form-horizontal"
                                  action="{{ route('login') }}" id="form-login">
                                @csrf
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input id="useremail" type="text" class="form-control" name="useremail"
                                               placeholder="Username atau email" value="{{old('useremail')}}"
                                               required autofocus>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input id="log_password" class="form-control" type="password"
                                               placeholder="Kata sandi" name="password" minlength="6" required>
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                                        <span class="help-block">
                                            @if(session('error'))
                                                <strong>{{ $errors->first('password') }}</strong>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="row form-group" style="font-size: 15px">
                                    <div class="col-lg-6 checkbox" style="margin: -10px 0">
                                        <label>
                                            <input type="checkbox" name="remember" {{old('remember') ? 'checked' : ''}}
                                            style="position: relative"> Ingat saya
                                        </label>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <a href="javascript:openEmailModal()" style="text-decoration: none">Lupa kata sandi?</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input id="btn_login" class="btn btn-dark-red btn-login" type="submit"
                                               value="MASUK">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sign up form -->
                <div class="box">
                    <div class="registerBox" style="display:none;">
                        <div class="form">
                            @if ($errors->has('email'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                    </button>
                                    <h4><i class="icon fa fa-times"></i> Alert!</h4>
                                    {{ $errors->first('email') }}
                                </div>
                            @elseif($errors->has('password') || $errors->has('name'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                    </button>
                                    <h4><i class="icon fa fa-times"></i> Alert!</h4>
                                    {{ $errors->has('password') ? $errors->first('password') : $errors->first('name') }}
                                </div>
                            @endif
                            <div id="reg_errorAlert"></div>
                            <form method="post" accept-charset="UTF-8" class="form-horizontal"
                                  action="{{ route('register') }}" id="form-register">
                                @csrf
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input id="reg_name" type="text" placeholder="Nama lengkap"
                                               class="form-control" name="name" required>
                                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input id="reg_username" type="text" placeholder="Username"
                                               class="form-control" name="username" minlength="4" required>
                                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input id="reg_email" class="form-control" type="email"
                                               placeholder="Email" name="email" required>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="password" placeholder="Kata sandi"
                                               id="reg_password" name="password" minlength="6" required>
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="password" placeholder="Ulangi kata sandi"
                                               id="reg_password_confirm" name="password_confirmation"
                                               minlength="6" required>
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12" style="font-size: 14px;text-align: justify">
                                        <small>
                                            Dengan melanjutkan ini, Anda mengakui bahwa Anda menerima
                                            <a href="{{route('ketentuan-layanan')}}" target="_blank"
                                               style="text-decoration: none">Ketentuan Layanan</a> dan
                                            <a href="{{route('kebijakan-privasi')}}" target="_blank"
                                               style="text-decoration: none">Kebijakan Privasi</a> {{env('APP_NAME')}}.
                                        </small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12" id="recaptcha-register"></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input id="btn_register" class="btn btn-dark-red btn-register" type="submit"
                                               value="BUAT AKUN" disabled>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Reset password form -->
                <div class="box">
                    <div class="emailBox" style="display:none;">
                        <div class="form">
                            @if(session('resetLink') || session('resetLink_failed'))
                                <div class="alert alert-{{session('resetLink') ? 'success' : 'danger'}} alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                    </button>
                                    <h4><i class="icon fa fa-{{session('resetLink') ? 'check' : 'times'}}"></i> Alert!
                                    </h4>
                                    {{session('resetLink') ? session('resetLink') : session('resetLink_failed')}}
                                </div>
                            @endif
                            <form method="post" accept-charset="UTF-8" class="form-horizontal"
                                  action="{{ route('password.email') }}">
                                @csrf
                                <div class="row {{ $errors->has('Email') ? ' has-error' : '' }} has-feedback">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="email" placeholder="Email" name="email"
                                               value="{{ old('email') }}" required>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input class="btn btn-dark-red btn-login" type="submit"
                                               value="Kirim tautan reset kata sandi">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Recovery password form -->
                <div class="box">
                    @if(session('recover_failed'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                            </button>
                            <h4><i class="icon fa fa-times"></i> Alert!</h4>
                            {{ session('recover_failed') }}
                        </div>
                    @endif
                    <div class="passwordBox" style="display:none;">
                        <div id="forg_errorAlert"></div>
                        <div class="form">
                            <form id="form-recovery" method="post" accept-charset="UTF-8" class="form-horizontal"
                                  action="{{route('password.request',
                                  ['token' => session('reset') ? session('reset')['token'] : old('token')])}}">
                                @csrf
                                <div class="row {{ $errors->has('Email') ? ' has-error' : '' }} has-feedback">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="email" placeholder="Email" name="email"
                                               value="{{ old('email') }}" required>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row {{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
                                    <div class="col-lg-12">
                                        <input id="forg_password" class="form-control" type="password"
                                               placeholder="Kata sandi baru" name="password" minlength="6" required>
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row {{ $errors->has('password_confirmation') ? ' has-error' : '' }} has-feedback">
                                    <div class="col-lg-12">
                                        <input id="forg_password_confirm" class="form-control" type="password"
                                               placeholder="Ulangi kata sandi baru" name="password_confirmation"
                                               minlength="6" onkeyup="return checkForgotPassword()" required>
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input class="btn btn-dark-red btn-login btn-password" type="submit"
                                               value="reset kata sandi">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="forgot login-footer">
                    <span>Ingin <a href="javascript:showRegisterForm()">membuat akun</a> {{env('APP_NAME')}}?</span>
                </div>
                <div class="forgot register-footer" style="display:none">
                    <span>Sudah memiliki akun {{env('APP_NAME')}}? <a href="javascript:showLoginForm()">Masuk</a></span>
                </div>
            </div>
        </div>
    </div>
</div>
