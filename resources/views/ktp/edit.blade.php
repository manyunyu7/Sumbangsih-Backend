@extends('main.app')

@section('page-breadcrumb')
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">KTP</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item text-muted active" aria-current="page">KTP</li>
                        <li class="breadcrumb-item text-muted" aria-current="page">Edit KTP</li>
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

    <form action='{{ url("ktp/$data->id/update") }}' enctype="multipart/form-data" method="post">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Edit Data KTP</h3>

                        <div class="form-group">
                            <label for="basicInput">Nama Pada KTP</label>
                            <input type="text" name="name" required class="form-control"
                                   value="{{ old('name',$data->name) }}"
                                   placeholder="Nama Sesuai KTP">
                        </div>

                        <div class="form-group">
                            <label for="basicInput">Tempat Lahir</label>
                            <input type="text" name="birth_place" required class="form-control"
                                   value="{{ old('birth_place',$data->birth_place) }}"
                                   placeholder="Tempat Lahir">
                        </div>

                        <div class="form-group">
                            <label for="basicInput">Tanggal Lahir</label>
                            <input type="date" name="birth_date" required class="form-control"
                                   value="{{ old('birth_date',$data->birth_date) }}"
                                   placeholder="Tanggal Lahir">
                        </div>
                        <div class="form-group">
                            <label for="">Alamat Tinggal</label>
                            <textarea class="form-control" name="alamat" rows="3">{{old('alamat',$data->alamat)}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="formFile" class="form-label">Foto KTP Dari User</label>
                            <input name="photo_user" class="form-control" type="file" id="formFile">
                        </div>

                        <img src='{{asset("$data->photo_requested")}}' style="border-radius: 20px" id="imgPreview"
                             class="img-fluid" alt="Responsive image">

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="basicInput">NIK</label>
                            <input type="number" maxlength="16" name="nik" required class="form-control"
                                   value="{{ old('nik',$data->nik) }}"
                                   placeholder="Nomor Induk Kependudukan">
                        </div>

                        <div class="form-group">
                            <label for="basicInput">No Kartu Keluarga</label>
                            <input type="number" maxlength="16" name="no_kk" required class="form-control"
                                   value="{{ old('no_kk',$data->no_kk) }}"
                                   placeholder="Nomor Kartu Keluarga">
                        </div>

                        <div class="form-group">
                            <label for="">Jenis Kelamin</label>
                            <select class="form-control" name="jk" id="">
                                <option @if($data->jk==1) selected @endif value="1">Laki-Laki</option>
                                <option @if($data->jk==0) selected @endif value="0">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="formFile" class="form-label">Foto KTP Database</label>
                            <input name="photo_db" class="form-control" type="file" id="formFile">
                        </div>

                        <img src='{{asset("$data->photo_stored")}}' style="border-radius: 20px" id="imgPreview"
                             class="img-fluid" alt="Responsive image">
                    </div>
                </div>

            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-danger">SIMPAN DATA</button>
            </div>



        </div>
    </form>





@endsection


@section('app-script')

    <script src="{{ URL::to('bootstrap_ui') }}/assets/libs/tinymce/tinymce.min.js"></script>
    <script src="{{ URL::to('bootstrap_ui') }}/assets/libs/tinymce/plugins/code/plugin.min.js"></script>
    <script>
        tinymce.init({selector: '#textarea'});
        tinymce.init({
            selector: '#dark',
            toolbar: 'undo redo styleselect bold italic alignleft aligncenter alignright bullist numlist outdent indent code',
            plugins: 'code'
        });
    </script>

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

    <script>
        var el = document.getElementById('formFile');
        el.onchange = function () {
            var fileReader = new FileReader();
            fileReader.readAsDataURL(document.getElementById("formFile").files[0])
            fileReader.onload = function (oFREvent) {
                document.getElementById("imgPreview").src = oFREvent.target.result;
            };
        }


        $(document).ready(function () {
            $.myfunction = function () {
                $("#previewName").text($("#inputTitle").val());
                var title = $.trim($("#inputTitle").val())
                if (title == "") {
                    $("#previewName").text("Judul")
                }
            };

            $("#inputTitle").keyup(function () {
                $.myfunction();
            });

        });
    </script>





@endsection
