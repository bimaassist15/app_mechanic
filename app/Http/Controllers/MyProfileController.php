<?php

namespace App\Http\Controllers;

use App\Http\Helpers\UtilsHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class MyProfileController extends Controller
{
    public function index(Request $request)
    {
        $myProfile = UtilsHelper::myProfile();
        return view('myProfile.index', compact('myProfile'));
    }

    public function update($id)
    {
    }
}
