<?php

namespace App\Http\Controllers;

use App\Helper\RazkyFeb;
use App\Models\BansosEvent;
use App\Models\News;
use App\Models\PengajuanSKU;
use App\Models\Tracking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanTrackingController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewCreate()
    {
        return view('pengajuan.create_new');
    }

    public function viewManage()
    {
        $datas = BansosEvent::all();
        $message = "";
        return view('bansos_event.manage_new')->with(compact('datas', 'message'));
    }

    public function tesfilter()
    {
        return $datas = BansosEvent::all();
    }

    public function viewAll()
    {
        $datas = PengajuanSKU::all();
        $message = "";
        return view('pengajuan.manage_new')->with(compact('datas', 'message'));
    }

    public function viewKelurahan()
    {
        $datas = PengajuanSKU::whereNull("approved_kelurahan")->get();
        $message = "Tingkat Kelurahan";
        return view('pengajuan.manage_new')->with(compact('datas', 'message'));
    }

    public function viewKecamatan()
    {
        $matchThese = ['approved_kecamatan' => null, 'approved_kelurahan' => '1'];
        $datas = PengajuanSKU::where($matchThese)->get();
        $message = "Tingkat Kecamatan";
        return view('pengajuan.manage_new')->with(compact('datas', 'message'));
    }

    public function viewPanitia()
    {
        $matchThese = ['approved_kelurahan' => '1', 'approved_kecamatan' => '1'];
        $datas = PengajuanSKU::where($matchThese)->get();
        $message = "Tingkat Panitia Nasional";
        return view('pengajuan.manage_new')->with(compact('datas', 'message'));
    }

    /**
     * Show the edit form for editing armada
     *
     * @return \Illuminate\Http\Response
     */
    public function viewUpdate($id)
    {
        $data = PengajuanSKU::find($id);
        $trackings = Tracking::where("pengajuan_id", '=', $id)->get();
        return view('pengajuan.edit')->with(compact('data', 'trackings'));
    }

    /**
     * Show the edit form for editing armada
     *
     */
    public function getHistory(Request $request)
    {
        $userId = $request->user_id;

        $findPengajuan = PengajuanSKU::where("user_id", '=', $userId)->first();
        if ($findPengajuan == null) {
            return RazkyFeb::responseSuccessWithData(200, 1, 3, "Success", "Success", null);
        } else {
            $id = $findPengajuan->id;
            $data = Tracking::where("pengajuan_id", '=', $id)->orderBy('id', 'DESC')->get();
            return RazkyFeb::responseSuccessWithData(200, 1, 1, "Success", "Success", $data);
        }
        return RazkyFeb::error3(0, 0);
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
    }


    /**
     * update created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function update(Request $request, $id)
    {
        $userId = Auth::id();
        $role = Auth::user()->role;

        $objPengajuan = PengajuanSKU::find($id);

        $data = new Tracking();
        $data->role = $role;

        $data->date = Carbon::now()->format('d F Y');
        $data->user_id = $userId;
        $data->pengajuan_id = $id;

        $savedStatus = $request->status;

        $data->status = $savedStatus;
        $data->message = $request->message;
//        $data->updated_by = Auth::id();

        $date = RazkyFeb::IndonesianDateTimeline();
        $title = "";
        switch (Auth::user()->role) {
            case 4 : // Kelurahan
                $data->title = "Kelurahan - $date ";
                if ($data->status == 1) {
                    $objPengajuan->approved_kelurahan = 1;
                } else {
                    $objPengajuan->approved_kelurahan = 0;
                }
                break;
            case 5 :
                $data->title = "Kecamatan - $date ";
                if ($data->status == 1) {
                    $objPengajuan->approved_kecamatan = 1;
                } else {
                    $objPengajuan->approved_kecamatan = 0;
                }
                break;
            case 1 :
                $title = "Panitia Penyeleksi - $date ";
                $message = "";
                if ($data->status == 10) {
                    $objPengajuan->isDisbursed = 1;
                    $objPengajuan->isFinish = 1;
                    $title = "Dana sudah masuk ke rekening";
                    $message = "Permohonan selesai,\nPeriksa halaman pengajuan";
                }

                if ($data->status == 3) {
                    $objPengajuan->isFinish = 2;
                    $message = "Dokumen Permohonan BLT anda telah di seleksi. Periksa halaman pengajuan";
                }

                if ($data->status == 2) {
                    $message = "Dokumen Permohonan BLT anda sedang dalam proses seleksi";
                }

                $stat = $data->status;
                if ($data->status == 0) {
                    $data->status = 199;
                    $objPengajuan->isDisbursed = 0;
                    $objPengajuan->isFinish = 3;
                    $title = "Panitia Penyeleksi - $date";
                    $message = "Pengajuan BLT Anda Tidak Disetujui";
                }

                $data->title = $title;
                $data->message = $message;
                break;
        }

        if ($data->save()) {
            $objPengajuan->save();

            RazkyFeb::insertNotification(
                $userId,
                "Pengajuan BLT",
                "Update Tracking",
                "Permintaanmu telah diproses ke tahap ($title), silakan cek di menu riwayat",
                76
            );

            if ($request->is('api/*')) {
                return RazkyFeb::responseSuccessWithData(
                    200, 1, 200,
                    "Berhasil Mengupdate Data",
                    "Success",
                    $data,
                );
            }

            return back()->with(["success" => "Berhasil Mengupdate Data"]);
        } else {
            if ($request->is('api/*'))
                return RazkyFeb::responseErrorWithData(
                    400, 3, 400,
                    "Gagal Mengupdate Konten",
                    "Success",
                    ""
                );
            return back()->with(["errors" => "Gagal Mengupdate Data"]);
        }

    }

    /**
     * return json or view
     */
    public function delete(Request $request, $id)
    {
        $data = BansosEvent::findOrFail($id);

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


    public function get(Request $request)
    {
        $datas = News::all();
        if ($request->type != "") {
            $datas = News::where('type', '=', $request->type)->get();
        }
        return $datas;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function SaveData(BansosEvent $data, Request $request)
    {
        if ($data->save()) {
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
                    "Berhasil Menginput Data",
                    "Success",
                    ""
                );
            return back()->with(["errors" => "Gagal Menyimpan Data"]);
        }
    }
}
