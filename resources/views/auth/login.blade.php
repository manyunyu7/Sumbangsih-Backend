@extends('auth.auth_container')

@section('content')

    <div class="container">
        <form method="POST" action="{{ url('proceedLogin') }}">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="wrap">
                        <div class="img" style="background-image: url(https://cdn-2.tstatic.net/kaltim/foto/bank/images/azislamcom-ilustrasi-sedekah.jpg);"></div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Login</h3>
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


                            <div class="form-group mt-3 mb-3" >
                                @if ($errors->any())
                                    <div class="alert">
                                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                                        {!! implode('', $errors->all('<div>:message</div>')) !!}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mt-3" style="margin-top: 20px">
                                <input id="username" aria-labelledby="label_uname" name="contact" value="{{old('contact')}}" type="text" class="form-control" required>
                                <label id="label_uname" class="form-control-placeholder" for="username">No Telepon</label>
                            </div>

                            <div class="form-group">
                                <input id="password-field" name="password" type="password" class="form-control"
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
                            <div class="form-group d-md-flex">
                                <div class="w-50 text-left">
                                    <label class="checkbox-wrap checkbox-primary mb-0">Remember Me
                                        <input type="checkbox" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-50 text-md-right">
                                    <a href="#">Forgot Password</a>
                                </div>
                            </div>
                            <p class="text-center">Belum punya akun ? <a data-toggle="tab" href="{{url('/register')}}">Daftar Sekarang</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
