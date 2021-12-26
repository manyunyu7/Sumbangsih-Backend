<?php

namespace App\Http\Controllers;

use App\Helper\RazkyFeb;
use App\Models\Komplain;
use App\Models\PengajuanSKU;
use App\Models\ReportDataMistake;
use App\Models\Tracking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KomplainsController extends Controller
{

    public function viewManage()
    {
        $datas = Komplain::all();
        return view('komplain.manage')->with(compact("datas"));
    }

    public function upload(Request $request)
    {
        $object = new Komplain();
        $object->type = $request->type;
        $object->user_id = $request->user_id;
        $object->dana_option = $request->dana_option;
        $object->dana_excess = $request->dana_excess;
        $object->rejected_at = $request->rejected_at;
        $object->feedback = $request->feedback;
        $object->photo = $request->photo;
        $object->notes = $request->notes;

        if ($request->photo != null) {

            $image = $request->photo;  // your base64 encoded
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = "komplain_" . time() . $object->user_id . '_' . $object->event_id . '.' . 'png';

            $savePathDB = "/web_files/komplain/$imageName";
            $path = public_path() . $savePathDB;
            \File::put($path, base64_decode($image));
            $photoPath = $savePathDB;
            $object->photo = $photoPath;
        }

        if ($object->save()) {
            return RazkyFeb::responseSuccessWithData(200, 1, 1, "Sukses", "Success", $object);
        } else {
            return RazkyFeb::responseErrorWithData(200, 0, 0, "Gagal", "Failed", $object);
        }
    }

}
