<?php

namespace App\Http\Controllers;

use App\Helper\RazkyFeb;
use App\Models\KTPIdentification;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KTPController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewCreate()
    {
        return view('ktp.create');
    }

    /**
     * Show the form for managing existing resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewManage()
    {
        $datas = KTPIdentification::all();
        return view('ktp.manage')->with(compact('datas'));
    }

    /**
     * Show the edit form for editing armada
     *
     * @return \Illuminate\Http\Response
     */
    public function viewUpdate($id)
    {
        $data = KTPIdentification::findOrFail($id);
        return view('ktp.edit')->with(compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $data = new KTPIdentification();
        $data->user_id = $request->user_id;
        $data->name = $request->name;
        $data->birth_place = $request->birth_place;
        $data->birth_date = $request->birth_date;
        $data->nik = $request->nik;
        $data->no_kk = $request->no_kk;
        $data->jk = $request->jk;
        $data->alamat = $request->alamat;

        if ($request->hasFile('photo_db')) {
            $file = $request->file('photo_db');
            $extension = $file->getClientOriginalExtension(); // you can also use file name
            $fileName = time() . '.' . $extension;

            $savePath = "/web_files/ktp/db/";
            $savePathDB = "$savePath$fileName";
            $path = public_path() . "$savePath";
            $file->move($path, $fileName);

            $photoPath = $savePathDB;
            $data->photo_stored = $photoPath;
        }

        if ($request->hasFile('photo_user')) {
            $file = $request->file('photo_user');
            $extension = $file->getClientOriginalExtension(); // you can also use file name
            $fileName = time() . '.' . $extension;

            $savePath = "/web_files/ktp/user/";
            $savePathDB = "$savePath$fileName";
            $path = public_path() . "$savePath";
            $file->move($path, $fileName);

            $photoPath = $savePathDB;
            $data->photo_requested = $photoPath;
        }

        return $this->SaveData($data, $request);
    }


    /**
     * update created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function update(Request $request, $id)
    {
//        dd($request->all());
        $data = KTPIdentification::findOrFail($id);
        $data->user_id = $request->user_id;
        $data->name = $request->name;
        $data->birth_place = $request->birth_place;
        $data->birth_date = $request->birth_date;
        $data->nik = $request->nik;
        $data->no_kk = $request->no_kk;
        $data->jk = $request->jk;
        $data->alamat = $request->alamat;

        if ($request->hasFile('photo_db')) {
            $file = $request->file('photo_db');
            $extension = $file->getClientOriginalExtension(); // you can also use file name
            $fileName = time() . '.' . $extension;

            $savePath = "/web_files/ktp/db/";
            $savePathDB = "$savePath$fileName";
            $path = public_path() . "$savePath";
            $file->move($path, $fileName);

            $photoPath = $savePathDB;
            $data->photo_stored = $photoPath;
        }

        if ($request->hasFile('photo_user')) {
            $file = $request->file('photo_user');
            $extension = $file->getClientOriginalExtension(); // you can also use file name
            $fileName = time() . '.' . $extension;

            $savePath = "/web_files/ktp/user/";
            $savePathDB = "$savePath$fileName";
            $path = public_path() . "$savePath";
            $file->move($path, $fileName);

            $photoPath = $savePathDB;
            $data->photo_requested = $photoPath;
        }

        return $this->SaveData($data, $request);
    }

    public function delete(Request $request, $id)
    {
        $data = KTPIdentification::findOrFail($id);
        $file_path1 = public_path() . $data->photo_requested;
        $file_path2 = public_path() . $data->photo_stored;

        RazkyFeb::removeFile($file_path1);
        RazkyFeb::removeFile($file_path2);

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
     * @param KTPIdentification $data
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function SaveData(KTPIdentification $data, Request $request)
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
