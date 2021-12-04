<?php

namespace App\Http\Controllers;

use App\Helper\RazkyFeb;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{

    public function checkIfNumberRegistered(Request $request)
    {
        $number = $request->number;
        $findNumber = User::where('contact', '=', $number)->first();

        if ($findNumber != null) {
            return RazkyFeb::responseErrorWithData(200, 1, 1,
                "Nomor Ditemukan", "Number Found", $findNumber);
        } else {
            return RazkyFeb::responseErrorWithData(200, 0, 0,
                "Nomor Tidak Ditemukan", "Number Not Found", null);
        }
    }

    public function viewAdminManage()
    {
        $datas = User::whereNull('status')->get();
        return view('user.manage')->with(compact('datas'));
    }

    public function viewAdminEdit($id)
    {
        $data = User::findOrFail($id);
        return view('user.edit')->with(compact('data'));
    }

    public function viewDetail($id)
    {
        $data = User::findOrFail($id);
        return view('user.detail')->with(compact('data'));
    }

    public function viewAdminCreate()
    {
        return view('user.create');
    }


    function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->delete()) {
            if (Auth::user()->role == 1) {
                return back()->with(["success" => "Berhasil Menghapus User $user->name"]);
            } else {
                return back()->with(["success" => "Berhasil Menghapus User $user->name"]);
            }
        } else {
            return back()->with(["error" => "Gagal Menghapus User Baru"]);
        }
    }

    function delete($id)
    {
        $user = User::findOrFail($id);
        $user->status = 0;
        if ($user->save()) {
            if (Auth::user()->role == 1) {
                return back()->with(["success" => "Berhasil Menghapus User $user->name"]);
            } else {
                return back()->with(["success" => "Berhasil Menghapus User $user->name"]);
            }
        } else {
            return back()->with(["error" => "Gagal Menghapus User Baru"]);
        }
    }

    function store(Request $request)
    {
        $validateComponent = [
            "user_name" => "required",
            "user_email" => "required",
            "user_password" => "required",
//            "user_role" => "required",
        ];


        $this->validate($request, $validateComponent);

        $role = "";

        if ($request->role == "" || $request->role == null) {
            $role = 3;
        }

        $user = new User();
        $user->name = $request->user_name;
        $user->email = $request->user_email;
        $user->contact = $request->user_contact;
        $user->password = bcrypt($request->user_password);
        $user->role = $role;

        if ($request->hasFile('photo')) {

            $file_path = public_path() . $user->photo;
            RazkyFeb::removeFile($file_path);

            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension(); // you can also use file name
            $fileName = $user->id . '.' . time() . $extension;

            $savePath = "/web_files/user_profile/0/";
            $savePathDB = "$savePath$fileName";
            $path = public_path() . "$savePath";
            $upload = $file->move($path, $fileName);

            $user->photo = $savePathDB;

            if ($user->save()) {
                if ($request->is('api/*'))
                    return RazkyFeb::responseSuccessWithData(
                        200,
                        1,
                        200,
                        "Berhasil Mengupdate Foto Profil",
                        "Success",
                        Auth::user(),
                    );

                return back()->with(["success" => "Berhasil Mengupdate Profil"]);
//                return http_redirect("admin")->with(["success" => "Berhasil Mengupdate Profil"]);
            } else {
                if ($request->is('api/*'))
                    return RazkyFeb::responseErrorWithData(
                        400,
                        3,
                        400,
                        "Gagal Mengupdate Foto Profil",
                        "Error",
                        ""
                    );

                return back()->with(["errors" => "Gagal Mengupdate Foto Profil"]);
            }
        }


        if ($user->save()) {
            $url = url('/login');
            return back()->with(["success" => "Berhasil Mendaftar, Silakan Login Menggunakan Akun Anda  <a href='$url'> Disini</a > "]);
        } else {
            return back()->with(["failed" => "Gagal Menambahkan User Baru"]);
        }
    }


    function update(Request $request)
    {
        //        return $request;
        $validateComponent = [
            "user_name" => "required",
            "user_email" => "required",
            "user_role" => "required",
        ];

        $this->validate($request, $validateComponent);

        $user = User::find($request->id);
        if ($request->id == null)
            $user = Auth::user();

        $user->name = $request->user_name;
        $user->email = $request->user_email;
        $user->contact = $request->user_contact;
        $user->role = ($request->user_role);


        if ($user->update()) {
            // IF REQUEST IS FROM API
            if ($request->is('api/*'))
                return RazkyFeb::responseSuccessWithData(
                    200,
                    1,
                    200,
                    "Berhasil Mengupdate Profil",
                    "Success",
                    $user,
                );

            // IF REQUEST IS FROM WEB
            if (Auth::user()->role == 1) {
                return back()->with(["success" => "Berhasil Mengupdate Data User"]);
            }
            return back()->with(["success" => "Berhasil Mengupdate Data User"]);
        } else {
            if ($request->is('api/*'))
                return RazkyFeb::responseErrorWithData(
                    400,
                    3,
                    400,
                    "Gagal Mengupdate Profil",
                    "Error",
                    ""
                );

            return back()->with(["failed" => "Gagal Mengupdate Data User"]);
        }
    }


    function updateProfilePhoto(Request $request)
    {
        $response = array();
        $user = Auth::user();
        $id = $user->id;


        if ($request->hasFile('photo')) {

            $file_path = public_path() . $user->photo;
            RazkyFeb::removeFile($file_path);

            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension(); // you can also use file name
            $fileName = $user->id . '.' . $extension;

            $savePath = " / web_files / user_profile / $id / ";
            $savePathDB = "$savePath$fileName";
            $path = public_path() . "$savePath";
            $upload = $file->move($path, $fileName);

            $user->photo = $savePathDB;

            if ($user->save()) {
                if ($request->is('api/*'))
                    return RazkyFeb::responseSuccessWithData(
                        200,
                        1,
                        200,
                        "Berhasil Mengupdate Foto Profil",
                        "Success",
                        Auth::user(),
                    );

                return back()->with(["success" => "Berhasil Mengupdate Profil"]);
//                return http_redirect("admin")->with(["success" => "Berhasil Mengupdate Profil"]);
            } else {
                if ($request->is('api/*'))
                    return RazkyFeb::responseErrorWithData(
                        400,
                        3,
                        400,
                        "Gagal Mengupdate Foto Profil",
                        "Error",
                        ""
                    );

                return back()->with(["errors" => "Gagal Mengupdate Foto Profil"]);
            }
        } else {
            if ($request->is('api/*'))
                return RazkyFeb::responseErrorWithData(
                    400,
                    3,
                    400,
                    "Gagal Mengupdate Foto Profil, Silakan Lengkapi Foto",
                    "Error",
                    $request->all()
                );
            return back()->with(["errors" => "Gagal Mengupdate Profil,Silakan Lengkapi Foto"]);
        }
    }

    function updatePassword(Request $request)
    {
        // IF ID IS NOT NULL (MOST LIKELY FROM WEB)
        $user = User::find($request->id);
        if ($request->id == null) {
            $user = Auth::user(); // IF FROM API -> WITH TOKEN
        }

        $this->validate($request, [
            'new_password' => 'required|min:6',
            'old_password' => 'required|min:6'
        ]);

        $hasher = app('hash');
        //If Password Sesuai
        if (!$hasher->check($request->old_password, $user->password)) {
            if ($request->is('api/*'))
                return RazkyFeb::responseErrorWithData(
                    400,
                    3,
                    400,
                    "Password Lama Tidak Sesuai",
                    "Old Password Didnt Match",
                    ""
                );

            return back()->with(["errors" => "Password Lama Tidak Sesuai"]);
        } else {
            $user->password = Hash::make($request->new_password);
            $user->save();

            if ($user) {
                if ($request->is('api/*'))
                    return RazkyFeb::responseSuccessWithData(
                        200,
                        1,
                        200,
                        "Berhasil Mengupdate Password",
                        "Success",
                        Auth::user(),
                    );

                return back()->with(["success" => "Berhasil Mengupdate Password"]);
            } else {
                if ($request->is('api/*'))
                    return RazkyFeb::responseErrorWithData(
                        400,
                        3,
                        400,
                        "Gagal Mengupdate Password",
                        "Error",
                        ""
                    );
                return back()->with(["errors" => "Gagal Mengupdate Password"]);
            }
        }
    }

    function registerNumber(Request $request)
    {
        $validateComponent = [
            "user_contact" => "required",
            "user_password" => "required",
        ];

        $this->validate($request, $validateComponent);

        $role = "";

        if ($request->user_role == "" || $request->user_role == null) {
            $role = 3;
        }

        $user = new User();
        $user->contact = $request->user_contact;
        $user->password = bcrypt($request->user_password);
        $user->role = $role;

        if ($user->save()) {
            $url = url('/login');
            if (RazkyFeb::isAPI()) {
                return RazkyFeb::success(200, $user->contact, 1, 1);
            } else {
                return back()->with(["success" => "Berhasil Mendaftar, Silakan Login Menggunakan Akun Anda  <a href='$url'> Disini</a > "]);
            }
        } else {
            if (RazkyFeb::isAPI()) {
                return RazkyFeb::error(400, "Gagal Menambahkan User");
            } else {
                return back()->with(["failed" => "Gagal Menambahkan User Baru"]);
            }
        }
    }
}
