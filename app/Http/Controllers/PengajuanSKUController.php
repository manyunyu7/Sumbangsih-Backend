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
        $obj = BansosEvent::where("status", '=', '1')->first();
        if ($obj == null) {
            return RazkyFeb::responseErrorWithData(
                400, 0, 0, "Kegiatan BLT Tidak Ditemukan",
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
        $rules = [
            "user_id" => "required",
            "event_id" => "required",
            "nama_usaha" => "required",
        ];
        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute terlebih dahulu'
        ];
        $this->validate($request, $rules, $customMessages);

        $object = new PengajuanSKU();
        $object->user_id = $request->user_id;
        $object->event_id = $request->event_id;
        $object->lat_selfie = $request->lat_selfie;
        $object->long_selfie = $request->long_selfie;
        $object->lat_usaha = $request->lat_usaha;
        $object->long_usaha = $request->long_usaha;
        $object->nama_usaha = $request->nama_usaha;
        $object->type = $request->type;
        $object->nib = $request->nib;

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

        if ($request->photo_selfie != null) {
            $image = $request->photo_selfie;  // your base64 encoded
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = "face_" . time() . $object->user_id . '_' . $object->event_id . '.' . 'png';

            $savePathDB = "/web_files/pengajuan/$imageName";
            $path = public_path() . "$savePathDB";
            \File::put($path, base64_decode($image));
            $photoPath = $savePathDB;
            $object->photo_selfie = $photoPath;
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
            return RazkyFeb::responseSuccessWithData(200, 1, 1, "Pengajuan Berhasil Dikirim", "KTP found", $object);
        } else {
            return RazkyFeb::responseErrorWithData(200, 0, 0, "Pengajuan Gagal Dilakukan", "KTP found", $object);
        }
    }

}
