<?php

namespace App\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Http\Requests\FormMyProfileRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class MyProfileController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $myProfile = UtilsHelper::myProfile();
            return view('myProfile.output', compact('myProfile'));
        }
        return view('myProfile.index');
    }
    public function edit($id)
    {
        $action = url('myProfile/' . $id . '?_method=put');
        $row = User::with('roles', 'profile')->find($id);
        return view('myProfile.form', compact('action', 'row'));
    }

    public function update(FormMyProfileRequest $request, $id)
    {
        // users
        $password_old = $request->input('password_old');
        $password = $request->input('password');
        $password_db = $password_old;
        if ($password != null && $password != '') {
            $password_db = Hash::make($password);
        }
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => $password_db,
            'status_users' => $request->input('status_users') !== null ? true : false,
        ];
        $users = User::find($id)->update($data);

        // profile
        $dataProfile = [
            'nama_profile' => $request->input('name'),
            'nohp_profile' => $request->input('nohp_profile'),
            'alamat_profile' => $request->input('alamat_profile'),
            'jeniskelamin_profile' => $request->input('jeniskelamin_profile'),
            'users_id' => $id,
        ];
        Profile::dataTable()->where('users_id', $id)->update($dataProfile);

        return response()->json('Berhasil update data', 200);
    }
}
