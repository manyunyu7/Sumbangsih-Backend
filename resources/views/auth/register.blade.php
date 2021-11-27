@extends('auth.auth_container')

@section('content')

    <div class="container">
        <form method="POST" action="{{ url('/register') }}">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="wrap">
                        <div class="img" style="background-image: url(https://cdn-2.tstatic.net/kaltim/foto/bank/images/azislamcom-ilustrasi-sedekah.jpg);"></div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Registrasi</h3>
                                </div>
                                <div class="w-100">
                                    <p class="social-media d-flex justify-content-end">
                                        <a href="#"
                                           class="social-icon d-flex align-items-center justify-content-center"><span
                                                class="fa fa-facebook"></span></a>
                                        <a href="#"
                                           class="social-icon d-flex align-items-center justify-content-center"><span
                                                class="fa fa-twitter"></span></a>
                                    </p>
                                </div>
                            </div>

                            <div class="form-group mt-3">

                                @if ($errors->any())

                                    <div class="alert">
                                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                                        {!! implode('', $errors->all('<div>:message</div>')) !!}
                                    </div>

                                @endif

                                @if (session()->has('success'))

                                        <div class="alert-success">
                                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                                            {!!  session()->get('success') !!}
                                        </div>

                                @endif

                            </div>

                            <div class="form-group mt-3">
                                <input id="name" aria-labelledby="label_uname" name="user_name" type="text"
                                       class="form-control" required>
                                <label id="label_uname" class="form-control-placeholder" for="name">Nama Lengkap</label>
                            </div>

                            <div class="form-group mt-3">
                                <input id="username" aria-labelledby="label_uname" name="user_email" type="text"
                                       class="form-control" required>
                                <label id="label_uname" class="form-control-placeholder" for="username">Email</label>
                            </div>

                            <div class="form-group mt-3">
                                <input id="username" aria-labelledby="label_uname" name="user_contact" type="text"
                                       class="form-control" required>
                                <label id="label_uname" class="form-control-placeholder" for="username">No Hp</label>
                                <small>Tanpa Spasi atau - misal : 6288223738709</small>
                            </div>

                            <div class="form-group">
                                <input id="password-field" name="user_password" type="password" class="form-control"
                                       required>
                                <label class="form-control-placeholder" for="password-field">Password</label>
                                <span toggle="#password-field"
                                      class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign
                                    In
                                </button>
                            </div>

                            <p class="text-center">Sudah punya akun ? <a data-toggle="tab" href="{{url('/login')}}">Login
                                    Disini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
