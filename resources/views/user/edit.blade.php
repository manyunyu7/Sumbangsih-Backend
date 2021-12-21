@extends('main.app')

@section('page-breadcrumb')
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">User</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item text-muted active" aria-current="page">User</li>
                        <li class="breadcrumb-item text-muted" aria-current="page">Edit Data</li>
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

    <div class="row">
{{--        <div class="col-12 mt-4">--}}
{{--            <h4 class="mb-0">Size Using grid markup</h4>--}}
{{--            <p class="text-muted mt-0 font-12">Using the grid, wrap cards in columns and rows as--}}
{{--                needed.<code>.col-1 to .col-12</code></p>--}}
{{--        </div>--}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ url('user/update') }}" method="post">
                        @csrf
                        <h3 class="card-title">Hallo {{$data->name}}</h3>
                        <p class="card-text">Gunakan Menu Ini Untuk Mengubah Data Diri Kamu</p>
                        <div class="form-group">
                            <label for="basicInput">Nama User</label>
                            <input type="text" name="user_name" required class="form-control"
                                   value="{{ old('user_name', $data->name) }}" required id="basicInput"
                                   placeholder="Nama Lengkap User">
                            <small class="form-text text-muted">Nama Pengguna</small>
                        </div>

                        <div class="form-group">
                            <label for="basicInput">Email</label>
                            <input type="email" name="user_email" required class="form-control"
                                   value="{{ old('user_email', $data->email) }}" id=" basicInput"
                                   placeholder="Email User">
                            <small class="form-text text-muted">Email Yang Digunakan Untuk Login</small>
                        </div>

                        <div class="form-group">
                            <label for="basicInput">Kontak User</label>
                            <input type="text" name="user_contact" class="form-control"
                                   value="{{ old('user_contact', $data->contact) }}" placeholder="Kontak User">
                        </div>

                        <div class="form-group">
                            <label for="">Role User</label>
                            <select class="form-control form-select" required name="user_role" id="">
                                <option>Pilih User Role</option>
                                <option {{($data->role==1) ? 'selected' : ''}}  value="1">Admin</option>
                                <option {{($data->role==2) ? 'selected' : ''}} value="2">Volunteer</option>
                                <option {{($data->role==3) ? 'selected' : ''}} value="3">User</option>
                                <option {{($data->role==4) ? 'selected' : ''}} value="4">Kelurahan</option>
                                <option {{($data->role==5) ? 'selected' : ''}} value="5">Kecamatan</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Ganti Foto Profil</h3>

                    <form action='{{url("/user/$data->id/change-photo")}}' method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="redirect_dest" value='{{"admin/user/$data->id/edit"}}'>
                        <img src="{{asset($data->photo)}}" class="rounded-circle" width="145" height="145">
                        <div class="form-group mt-3">
                            <input type="file" class="form-control-file" name="photo"
                                   aria-describedby="fileHelpId">
                        </div>
                        <button type="submit" class="btn btn-primary">Ganti Foto</button>
                    </form>

                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ url('user/change-password') }}" method="post">
                        @csrf
                        <input type="hidden" name="redirectTo" value="">
                        <input type="hidden" name="id" value="{{$data->id}}">

                        <h3 class="card-title">Ganti Password</h3>
                        <p class="card-text">Gunakan Menu Ini Untuk Mengubah Data Diri Kamu</p>
                        <div class="form-group">
                            <label for="basicInput">Password Lama</label>
                            <input type="password" name="old_password" class="form-control" id="basicInput"
                                   placeholder="Password">
                            <small class="form-text text-muted">Password Lama</small>
                        </div>

                        <div class="form-group">
                            <label for="basicInput">Password Baru</label>
                            <input type="password" name="new_password" class="form-control" id="basicInput"
                                   placeholder="Password">
                            <small class="form-text text-muted">Password Baru</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>

                    </form>
                </div>
            </div>
        </div>

    </div>





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




    <script type="text/javascript">
        $(function () {
            var table = $('#table_santri').DataTable({
                processing: true,
                serverSide: true,
                columnDefs: [{
                    orderable: true,
                    targets: 0
                }],
                dom: 'T<"clear">lfrtip<"bottom"B>',
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                buttons: [
                    'copyHtml5',
                    {
                        extend: 'excelHtml5',
                        title: 'Data Santri Export {{ \Carbon\Carbon::now()->year }}'
                    },
                    'csvHtml5',
                ],
                ajax: {
                    type: "get",
                    url: "{{ url('admin/data/santri/manage') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    async: true,
                    error: function (xhr, error, code) {
                        var err = eval("(" + xhr.responseText + ")");
                        console.log(err);
                    }
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                    {
                        data: 'nis',
                        name: 'nis'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'kelas',
                        name: 'kelas'
                    },
                    {
                        data: 'asrama',
                        name: 'asrama'
                    },
                    {
                        data: 'jenjang',
                        name: 'jenjang'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },

                ]
            });


            $('body').on("click", ".btn-add-new", function () {
                var id = $(this).attr("id")
                $(".btn-destroy").attr("id", id)
                $("#insert-modal").modal("show")
            });


            // Edit & Update
            $('body').on("click", ".btn-edit", function () {
                var id = $(this).attr("id")
                $.ajax({
                    url: "{{ URL::to('/') }}/mutabaah/" + id + "/fetch",
                    method: "GET",
                    success: function (response) {
                        $("#edit-modal").modal("show")
                        console.log(response)
                        $("#id").val(response.id)
                        $("#name").val(response.judul)
                        $("#edit_date").val(response.tanggal)
                        $("#role").val(response.role)
                    }
                })
            });

            // Reset Password
            $('body').on("click", ".btn-res-pass", function () {
                var id = $(this).attr("id")
                $(".btn-reset").attr("id", id)
                $("#reset-password-modal").modal("show")
            });

        });
    </script>




@endsection
