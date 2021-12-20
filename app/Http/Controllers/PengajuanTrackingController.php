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
        $datas = PengajuanSKU::all();
        $message = "Tingkat Kelurahan";
        return view('pengajuan.manage_new')->with(compact('datas', 'message'));
    }

    public function viewKecamatan()
    {
        $datas = PengajuanSKU::where('approved_kelurahan', '=', '1')->get();
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
     * Store a newly created resource in storage.
     *
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
        $data->status = $request->status;
        $data->message = $request->message;
        $data->updated_by = Auth::id();

        $date = Carbon::now()->format('Y-m-d');

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
                $data->title = $request->title;
                break;
        }

        if ($data->save()) {
            $objPengajuan->save();

            if ($request->is('api/*'))
                return RazkyFeb::responseSuccessWithData(
                    200, 1, 200,
                    "Berhasil Mengupdate Data",
                    "Success",
                    $data,
                );

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
