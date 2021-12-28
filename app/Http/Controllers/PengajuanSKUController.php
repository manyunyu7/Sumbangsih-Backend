<?php

namespace App\Http\Controllers;

use App\Helper\RazkyFeb;
use App\Models\BansosEvent;
use App\Models\KTPIdentification;
use App\Models\PengajuanSKU;
use App\Models\Tracking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengajuanSKUController extends Controller
{

    public function selfCheck(Request $request)
    {
        $pengajuan = PengajuanSKU::where("user_id", '=', $request->id)->first();
        if ($pengajuan != null) {
            if ($pengajuan->isFinish) {
                $status = Tracking::where('status', '=', 0)->get()->count();
                if ($status == 0) {
                    // if finish and not ditolak
                    return RazkyFeb::responseSuccessWithData(
                        200, 1, 1, "", "", $pengajuan
                    );
                } else {
                    // if ada yang ditolak
                    return RazkyFeb::responseSuccessWithData(
                        200, 1, 4, "", "", $pengajuan
                    );
                }

            } else {
                // if not finish / on progress
                return RazkyFeb::responseSuccessWithData(
                    200, 1, 3, "", "", $pengajuan
                );
            }
        } else {
            return RazkyFeb::responseSuccessWithData(
                200, 0, 0, "Tidak Ada Pengajuan", "No Data", $pengajuan
            );
        }
    }


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

    public function getCurrentUser(Request $request)
    {
        $id = $request->user_id;
        $obj = PengajuanSKU::where("user_id", '=', $id)->first();
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
            $date = Carbon::now()->format('Y-m-d');
            $objTracking = new Tracking();
            $objTracking->user_id = $object->user_id;
            $objTracking->pengajuan_id = $object->id;
            $objTracking->date = $date;
            //  $objTracking->updated_by = $object->user_id;
            $objTracking->status = 1;
            $objTracking->role = "100";
            $objTracking->title = "User - " . RazkyFeb::IndonesianDateTimeline();
            $objTracking->message = "User Telah Mengajukan Permohonan BLT, Permohonan akan diteruskan ke kelurahan";
            $objTracking->save();

            RazkyFeb::insertNotification(
                $object->user_id,
                "Pengajuan BLT",
                "Request Pengajuan BLT Sedang Diproses ",
                "Terima Kasih Telah Mengajukan BLT, Permintaan Anda sedang diproses, silakan cek status di menu pengajuan",
                2
            );

            return RazkyFeb::responseSuccessWithData(200, 1, 1, "Pengajuan Berhasil Dikirim", "KTP found", $object);
        } else {
            return RazkyFeb::responseErrorWithData(200, 0, 0, "Pengajuan Gagal Dilakukan", "KTP found", $object);
        }
    }

}
