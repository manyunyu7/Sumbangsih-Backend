@extends('main.app')

@section('page-breadcrumb')
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">User</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item text-muted active" aria-current="page">User</li>
                        <li class="breadcrumb-item text-muted" aria-current="page">Tambah User</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-5 align-self-center">
            <div class="customize-input float-right">

            </div>
        </div>
    </div>
@endsection

@section('page-wrapper')
    @include('main.components.message')

    <form action="{{ url('user/store') }}" method="post" enctype="multipart/form-data">


        <div class="row">
            {{--        <div class="col-12 mt-4">--}}
            {{--            <h4 class="mb-0">Size Using grid markup</h4>--}}
            {{--            <p class="text-muted mt-0 font-12">Using the grid, wrap cards in columns and rows as--}}
            {{--                needed.<code>.col-1 to .col-12</code></p>--}}
            {{--        </div>--}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Tambah Data User</h3>
                        @csrf
                        <p class="card-text">Gunakan Menu Ini Untuk Menginput Data User</p>
                        <div class="form-group">
                            <label for="basicInput">Nama User</label>
                            <input type="text" name="user_name" required class="form-control"
                                   value="{{ old('user_name') }}" required id="basicInput"
                                   placeholder="Nama Lengkap User">
                        </div>

                        <div class="form-group">
                            <label for="basicInput">Email</label>
                            <input type="email" name="user_email" required class="form-control"
                                   value="{{ old('user_email') }}" id=" basicInput" placeholder="Email User">
                        </div>

                        <div class="form-group">
                            <label for="basicInput">Password</label>
                            <input type="password" name="user_password" required class="form-control" id="basicInput"
                                   placeholder="Password">
                        </div>

                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    </div>
                </div>
            </div>


            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">

                        <img src="{{asset('/web_files/errors/')}}/error_image_generic.png" class="rounded-circle"
                             width="145" height="145">
                        <div class="form-group mt-3">
                            <input type="file" class="form-control-file" name="photo"
                                   aria-describedby="fileHelpId">
                        </div>

                        <div class="form-group">
                            <label for="basicInput">Kontak User</label>
                            <input type="text" name="user_contact" class="form-control"
                                   value="{{ old('user_contact') }}" placeholder="Kontak User">
                        </div>

                        <div class="form-group">
                            <label for="">Role User</label>
                            <select class="form-control form-select" required name="user_role" id="">
                                <option value="">Pilih User Role</option>
                                <option value="1">Admin</option>
                                <option value="2">Volunteer</option>
                                <option value="3">User</option>
                                <option value="4">Kelurahan</option>
                                <option value="5">Kecamatan</option>
                            </select>
                        </div>

                        {{--                    <form action='{{url("/user/$data->id/change-photo")}}' method="post"--}}
                        {{--                          enctype="multipart/form-data">--}}
                        {{--                        @csrf--}}
                        {{--                        <input type="hidden" id="redirect_dest" value='{{"admin/user/$data->id/edit"}}'>--}}
                        {{--                        <img src="{{asset($data->photo)}}" class="rounded-circle" width="145" height="145">--}}
                        {{--                        <div class="form-group mt-3">--}}
                        {{--                            <input type="file" class="form-control-file" name="photo"--}}
                        {{--                                   aria-describedby="fileHelpId">--}}
                        {{--                        </div>--}}
                        {{--                        <button type="submit" class="btn btn-primary">Ganti Foto</button>--}}
                        {{--                    </form>--}}

                    </div>
                </div>
            </div>

        </div>
    </form>





@endsection


@section('app-script')
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/bs4-4.1.1/jszip-2.5.0/dt-1.10.23/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/r-2.2.7/sb-1.0.1/sp-1.2.2/datatables.min.js">
    </script>
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js">
    </script>
    <script type="text/javascript" charset="utf8"
            src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js">
    </script>
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js">
    </script>






@endsection
