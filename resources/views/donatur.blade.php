@extends('layouts.landing')
@section('css')
    <!-- CSS only -->

    <style>
        body {
            padding-top: 90px;
        }

        .card-img-top {
            width: 100%;
            height: 15vw;
            object-fit: cover;
        }

        /*   color variables */
        $clr-primary: #81d4fa;
        $clr-primary-light: #e1f5fe;
        $clr-primary-dark: #4fc3f7;
        $clr-gray100: #f9fbff;
        $clr-gray150: #f4f6fb;
        $clr-gray200: #eef1f6;
        $clr-gray300: #e1e5ee;
        $clr-gray400: #767b91;
        $clr-gray500: #4f546c;
        $clr-gray600: #2a324b;
        $clr-gray700: #161d34;
        $clr-pending: #fff0c2;
        $clr-pending-font: #a68b00;
        $clr-unpaid: #ffcdd2;
        $clr-unpaid-font: #c62828;
        $clr-paid: #c8e6c9;
        $clr-paid-font: #388e3c;
        $clr-link: #2962ff;

        /*   border radius */
        $radius: 0.2rem;

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Mukta, sans-serif;
            height: 100vh;
            display: grid;
            justify-content: center;
            align-items: center;
            color: $clr-gray500;
            font-size: 0.9rem;
            background-color: $clr-gray100;
        }

        table {
            border-collapse: collapse;
            box-shadow: 0 5px 10px $clr-gray300;
            background-color: white;
            text-align: left;
            overflow: hidden;

        thead {
            box-shadow: 0 5px 10px $clr-gray300;
        }

        th {
            padding: 1rem 2rem;
            text-transform: uppercase;
            letter-spacing: 0.1rem;
            font-size: 0.7rem;
            font-weight: 900;
        }

        td {
            padding: 1rem 2rem;
        }

        a {
            text-decoration: none;
            color: $clr-link;
        }

        .status {
            border-radius: $radius;
            background-color: red;
            padding: 0.2rem 1rem;
            text-align: center;

        &-pending {
             background-color: $clr-pending;
             color: $clr-pending-font;
         }

        &-paid {
             background-color: $clr-paid;
             color: $clr-paid-font;
         }

        &-unpaid {
             background-color: $clr-unpaid;
             color: $clr-unpaid-font;
         }
        }

        .amount {
            text-align: right;
        }

        //Color alternating rows
          tr:nth-child(even) {
              background-color: $clr-gray150;
          }
        }


    </style>
@endsection
@section ('content')
    <div class="container">

        <!--========== CONTACT US ==========-->
        <section class="contact section bd-container">
            <div class="contact__container bd-grid">
                <div class="contact__data">
                    <span class="section-subtitle contact__initial">Laporan Donasi dan Pengeluaran</span>
                    <h2 class="section-title contact__initial">MakanGratis.com</h2>
                    <p class="contact__description">Jika ingin mengikuti kegiatan berbagi secara langsung bersama,
                        silahkan kontak kami</p>
                </div>

                <div class="contact__button">
                    <a href="#" class="button">Contact us now</a>
                </div>
            </div>
        </section>

        <hr>
        <h4><span class="section-subtitle contact__initial">Laporan Donasi dan Pengeluaran</span></h4>

        <div class="table-responsive" style="margin-top: 20px">
            <table id="table_data" class="table table-hover table-bordered display no-wrap" style="width:100%">
                <thead class="">
                <tr>
                    <th data-sortable="">No</th>
                    <th data-sortable="">Jumlah</th>
                    <th data-sortable="">Kategori</th>
                    <th data-sortable="">Kegiatan</th>
                    <th data-sortable="">Bukti Pengeluaran</th>
                    <th data-sortable="">Diinput Pada</th>
                </tr>
                </thead>
                <tbody>

                @forelse ($datas as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{$data->amount}}</td>
                        <td>{{$data->category}}</td>
                        <td>
                            @if($data->event!=null)
                                <a href='{{url("makan-gratis/$data->id/detail")}}'>
                                    {{$data->event->name}} ({{$data->event->time_start}})
                                </a>
                            @endif
                        </td>
                        <td>
                            <img height="200px" width="200px" style="border-radius: 20px; object-fit: cover"
                                 src='{{asset("$data->photo")}}' alt="">
                        </td>
                        <td>{{ $data->created_at }}</td>
                    </tr>
                @empty

                @endforelse


                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>

    </div>


@endsection
