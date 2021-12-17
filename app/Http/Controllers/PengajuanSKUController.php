<?php

namespace App\Http\Controllers;

use App\Helper\RazkyFeb;
use App\Models\BansosEvent;
use App\Models\KTPIdentification;
use App\Models\PengajuanSKU;
use App\Models\User;
use Illuminate\Http\Request;

class PengajuanSKUController extends Controller
{
    public function getActiveEvent()
    {
        $obj = BansosEvent::where("status", '=', 'active')->first();
        if ($obj == null) {
            return RazkyFeb::responseErrorWithData(
                400, 1, 1, "Kegiatan BLT Tidak Ditemukan",
                "Failed", $obj
            );
        } else {
            return RazkyFeb::responseSuccessWithData(
                200, 1, 1, "Kegiatan BLT Ditemukan",
                "Success", $obj
            );
        }
    }

    public function upload(Request $request)
    {
        $object = new PengajuanSKU();
        $object->user_id = $request->user_id;
        $object->event_id = $request->event_id;
        $object->lat_selfie = $request->lat_selfie;
        $object->long_selfie = $request->long_selfie;
        $object->lat_usaha = $request->lat_usaha;
        $object->long_usaha = $request->long_usaha;
        $object->nama_usaha = $request->nama_usaha;

        if ($request->photo_ktp != null) {

            $image = $request->photo_ktp;  // your base64 encoded
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = "ktp_" . time() . $object->user_id . '_' . $object->event_id . '.' . 'png';

            $savePathDB = "/web_files/pengajuan/$imageName";
            $path = public_path() . $savePathDB;
            \File::put($path, base64_decode($image));
            $photoPath = $savePathDB;
            $object->photo_ktp = $photoPath;
        }

        if ($request->photo_face != null) {
            $image = $request->photo_face;  // your base64 encoded
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = "face_" . time() . $object->user_id . '_' . $object->event_id . '.' . 'png';

            $savePathDB = "/web_files/pengajuan/$imageName";
            $path = public_path() . "$savePathDB";
            \File::put($path, base64_decode($image));
            $photoPath = $savePathDB;
            $object->photo_face = $photoPath;
        }

        if ($request->photo_usaha != null) {
            $image = $request->photo_usaha;  // your base64 encoded
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = "usaha_" . time() . $object->user_id . '_' . $object->event_id . '.' . 'png';

            $savePathDB = "/web_files/pengajuan/$imageName";
            $path = public_path() . "$savePathDB";
            \File::put($path, base64_decode($image));
            $photoPath = $savePathDB;
            $object->photo_usaha = $photoPath;
        }

        if ($object->save()) {
            return RazkyFeb::responseSuccessWithData(200, 1, 1, "Verifikasi Berhasil Dikirim", "KTP found", $ktp);
        } else {
            return RazkyFeb::responseErrorWithData(200, 0, 0, "Verifikasi Gagal Dilakukan", "KTP found", $ktp);
        }
    }

}
