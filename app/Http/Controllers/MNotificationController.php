<?php

namespace App\Http\Controllers;

use App\Helper\RazkyFeb;
use App\Models\UserMNotification;
use Illuminate\Http\Request;

class MNotificationController extends Controller
{
    public function getByUser($id)
    {
        $data = UserMNotification::where('user_id', '=', $id)->orderBy('id', 'desc')->get();
        return RazkyFeb::responseSuccessWithData(200, 1, 1, "OK", "OK", $data);
    }

    public function setRead($id)
    {
        $data = UserMNotification::findOrFail($id);
        $data->is_read = 1;
        if ($data->save()) {
            return RazkyFeb::success(200, "Berhasil");
        } else {
            return RazkyFeb::error(400, "Gagal");
        }

    }

}
