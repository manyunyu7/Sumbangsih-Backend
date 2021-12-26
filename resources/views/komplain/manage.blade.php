@extends('main.app')

@section('page-breadcrumb')
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Manage Komplain</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item text-muted active" aria-current="page">Komplain</li>
                        <li class="breadcrumb-item text-muted" aria-current="page">Manage</li>
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


    <div class="card border-primary">
        <div class="card-header">
            <h4 class="mb-0">Manage Komplain</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table_data" class="table table-hover table-bordered display no-wrap" style="width:100%">
                    <thead class="">
                    <tr>
                        <th data-sortable="">No</th>
                        <th data-sortable="">Tipe</th>
                        <th data-sortable="">Nama</th>
                        <th data-sortable="">NIK</th>
                        <th data-sortable="">No Telp</th>
                        <th data-sortable="">Kelebihan Dana</th>
                        <th data-sortable="">Ditolak Oleh</th>
                        <th data-sortable="">Feedback</th>
                        <th data-sortable="">Photo</th>
                        <th data-sortable="">Dikirimkan Pada</th>
{{--                        <th data-sortable="">Edit</th>--}}
{{--                        <th data-sortable="">Hapus</th>--}}
                    </tr>
                    </thead>
                    <tbody>

                    @forelse ($datas as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->type }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{$data->nik}}</td>
                            <td>{{$data->contact}}</td>
                            <td>{{ $data->dana_excess }}</td>
                            <td>{{ $data->rejected_at }}</td>
                            <td>{{ $data->feedback }}</td>
                            <td>
                                <img height="200px" style="border-radius: 20px"
                                     src='{{asset("$data->photo")}}' alt="">
                            </td>
                            <td>{{ $data->created_at }}</td>

                            {{--                            <td>--}}
{{--                                <a href="{{url('/ktp'.'/'.$data->id.'/edit')}}">--}}
{{--                                    <button type="button" class="btn btn-primary">Edit</button>--}}
{{--                                </a>--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                <button id="{{ $data->id }}" type="button"--}}
{{--                                        class="btn btn-danger btn-delete mr-2">Hapus KTP--}}
{{--                                </button>--}}
{{--                            </td>--}}
                        </tr>
                    @empty

                    @endforelse


                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>

        </div>
    </div>


    <!-- Destroy Modal -->
    <div class="modal fade" id="destroy-modal" tabindex="-1" role="dialog" aria-labelledby="destroy-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="destroy-modalLabel">Apakah Anda Yakin Menghapus Konten Ini ?</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <a class="btn-destroy" href="">
                        <button type="button" class="btn btn-danger">Hapus</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Destroy Modal -->


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
            var table = $('#table_data').DataTable({
                processing: true,
                serverSide: false,
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
                        title: 'Data {{ \Carbon\Carbon::now()->year }}'
                    },
                    'csvHtml5',
                ],

            });

            $('body').on("click", ".btn-delete", function () {
                var id = $(this).attr("id")
                $(".btn-destroy").attr("href", window.location.origin + "/ktp/" + id + "/delete")
                $("#destroy-modal").modal("show")
            });

            $('body').on("click", ".btn-add-new", function () {
                var id = $(this).attr("id")
                $(".btn-destroy").attr("id", id)
                $("#insert-modal").modal("show")
            });

        });
    </script>




@endsection
