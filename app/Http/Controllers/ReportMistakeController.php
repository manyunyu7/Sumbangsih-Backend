<?php

namespace App\Http\Controllers;

use App\Helper\RazkyFeb;
use App\Models\KTPIdentification;
use App\Models\News;
use App\Models\ReportDataMistake;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportMistakeController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     */
    public function viewManage()
    {
        $datas = ReportDataMistake::all();
        return view('perbaikan_data.manage')->with(compact("datas"));
    }

    public function viewVerifikasi()
    {
        $datas = KTPIdentification::where('user_id', '<>', null)->get();
        return view('ktp.verifikasi')->with(compact('datas'));
    }

    public function upload(Request $request)
    {
        $data = new ReportDataMistake();
        $data->user_id = $request->user_id;
        $data->name = $request->name;
        $data->birth_place = $request->birth_place;
        $data->birth_date = $request->birth_date;
        $data->nik = $request->nik;
        $data->no_kk = $request->no_kk;
        $data->contact = $request->contact;
        $data->jk = $request->jk;
        $data->alamat = $request->alamat;


        return $this->SaveData($data, $request, $request->user_id);
    }


    public function delete(Request $request, $id)
    {
        $data = ReportDataMistake::findOrFail($id);

        if ($data->delete()) {
            if ($request->is('api/*'))
                return RazkyFeb::responseSuccessWithData(
                    200, 1, 200,
                    "Berhasil Menghapus Data",
                    "Success",
                    Auth::user(),
                );
            return back()->with(["success" => "Berhasil Menghapus Data"]);
        } else {
            if ($request->is('api/*'))
                return RazkyFeb::responseErrorWithData(
                    400, 3, 400,
                    "Berhasil Mengupdate Data",
                    "Success",
                    ""
                );
            return back()->with(["errors" => "Gagal Menghapus Data"]);
        }

    }

    /**
     * @param KTPIdentification $data
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function SaveData(ReportDataMistake $data, Request $request, $userId)
    {
        if ($data->save()) {

            RazkyFeb::insertNotification(
                $userId,
                "Pengajuan Perbaikan Data",
                "Data Diterima",
                "Pengajuan Perbaikan Data Telah Diterima, Silakan menunggu notifikasi selanjutnya",
                99
            );

            if ($request->is('api/*'))
                return RazkyFeb::responseSuccessWithData(
                    200, 1, 200,
                    "Berhasil Menyimpan Data",
                    "Success",
                    $data,
                );

            return back()->with(["success" => "Berhasil Menyimpan Data"]);
        } else {
            if ($request->is('api/*'))
                return RazkyFeb::responseErrorWithData(
                    400, 3, 400,
                    "Gagal Menginput Data",
                    "Success",
                    ""
                );
            return back()->with(["errors" => "Gagal Menyimpan Data"]);
        }
    }
}
