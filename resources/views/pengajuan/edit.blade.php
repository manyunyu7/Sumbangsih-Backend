@extends('main.app')

@section('page-breadcrumb')
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Pengajuan BLT</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item text-muted active" aria-current="page">Pengajuan BLT</li>
                        <li class="breadcrumb-item text-muted" aria-current="page">Proses Pengajuan</li>
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

    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Proses Pengajuan</h3>
            <div class="row">
                <div class="col-12">
                    <form action='{{ url("pengajuan-warga/$data->id/update") }}' enctype="multipart/form-data" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="">Status</label>
                            <select class="form-control" name="status" id="">
                                <option value="1">Diterima</option>
                                <option value="0">Ditolak</option>
                            </select>
                        </div>

                        @if(Auth::user()->role==1)
                            <div class="form-group">
                                <label for="basicInput">Judul</label>
                                <input type="text" name="title" required class="form-control" placeholder="Judul">
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="basicInput">Pesan</label>
                            <input type="text" name="message" required class="form-control"
                                   placeholder="Pesan"
                                   @if(Auth::user()->role=="4")
                                   value="Dokumen Permohonan SKU sudah divalidasi, Dokumen akan diteruskan ke kecamatan"
                                   @endif
                                   @if(Auth::user()->role=="5")
                                   value="Dokumen Permohonan SKU sudah divalidasi, Permohonan blt akan dikirim ke panitia penyeleksian"
                                @endif
                            >
                        </div>

                        <button type="submit" class="btn btn-outline-primary">SIMPAN</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Tracking</h3>
            <div class="row">
                <div class="col-12">
                    @forelse ($trackings as $items)
                        <ul>
                            <li>{{$items->title}}</li>
                            <li>{{$items->message}}</li>
                        </ul>
                    @empty

                    @endforelse
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Data KTP</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="basicInput">Nama Pada KTP</label><br>
                                <h4>{{$data->ktp_data->name}}</h4>
                            </div>

                            <div class="form-group">
                                <label for="basicInput">Tempat Lahir</label>
                                <h4>{{$data->ktp_data->birth_place}}</h4>

                            </div>

                            <div class="form-group">
                                <label for="basicInput">Tanggal Lahir</label>
                                <h4>{{$data->ktp_data->birth_date}}</h4>
                            </div>

                            <div class="form-group">
                                <label for="">Alamat Tinggal</label>
                                <h4>{{$data->ktp_data->alamat}}</h4>
                            </div>

                            <div class="form-group">
                                <label for="">FOTO KTP</label>
                                <img src='{{asset($data->ktp_data->photo_requested)}}'
                                     style="border-radius: 20px"
                                     id="imgPreview"
                                     class="img-fluid" alt="Responsive image">
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="basicInput">NIK</label>
                                <h4>{{$data->ktp_data->nik}}</h4>
                            </div>

                            <div class="form-group">
                                <label for="basicInput">No Kartu Keluarga</label>
                                <h4>{{$data->ktp_data->no_kk}}</h4>
                            </div>

                            <div class="form-group">
                                <label for="">Jenis Kelamin</label>
                                <select class="form-control" disabled name="jk" id="">
                                    <option @if($data->jk==1) selected @endif value="1">Laki-Laki</option>
                                    <option @if($data->jk==0) selected @endif value="0">Perempuan</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Foto Verifikasi NIK</label>
                                <img src='{{asset($data->ktp_data->photo_face)}}' style="border-radius: 20px"
                                     id="imgPreview"
                                     class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Data Pengajuan</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <h5 class="text-dark">Tipe Pengajuan :
                                    @if($data->type=="sku")
                                        Dengan SKU
                                    @endif

                                    @if($data->type=="nosku")
                                        Tanpa SKU
                                    @endif
                                </h5>
                            </div>

                            <div class="form-group">
                                <label for="">FOTO USAHA</label>
                                <img src='{{asset($data->photo_usaha)}}' style="border-radius: 20px"
                                     id="imgPreview"
                                     class="img-fluid" alt="Responsive image">
                            </div>

                            <div class="form-group">
                                <label for="">Nama Usaha : </label>
                                <h3 class="text-dark">{{$data->nama_usaha}}</h3>
                            </div>


                            @if($data->type=="sku")
                                <div class="form-group">
                                    <label for="">NIB Usaha</label>
                                    <h4>{{$data->nib}}</h4>
                                </div>
                            @endif


                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="">Koordinat Foto Usaha : </label>
                                <h3 class="text-dark">{{$data->lat_usaha.",".$data->long_usaha}}</h3>
                            </div>

                            <div class="form-group">
                                <label for="">Koordinat Foto Selfie : </label>
                                <h3 class="text-dark">{{$data->lat_selfie.",".$data->long_selfie}}</h3>
                            </div>


                            <div class="form-group">
                                <label for="">FOTO SELFIE ( SKU )</label>
                                <div style="border-radius: 20px; overflow: hidden;">
                                    <img src='{{asset($data->photo_selfie)}}'
                                         class="img-fluid">
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-danger">SIMPAN DATA</button>
                </div>


            </div>
        </div>
    </div>






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
