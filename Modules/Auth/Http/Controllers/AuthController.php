<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Requests\LoginValidation;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('auth::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function register()
    {
        return view('auth::register');
    }

    public function forgotPassword()
    {
        return view('auth::forgotPassword');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(LoginValidation $request)
    {
        $credentials = $request->only('email_or_username', 'password');

        if (
            Auth::attempt(['email' => $credentials['email_or_username'], 'password' => $credentials['password']]) ||
            Auth::attempt(['username' => $credentials['email_or_username'], 'password' => $credentials['password']])
        ) {
            $user = Auth::user();
            $request->session()->put('user', $user);
            $request->session()->put('cabang_id', $user->cabang_id);
            return redirect()->intended('/dashboard');
        } else {
            return redirect()->back()->withInput()->withErrors(['email_or_username' => 'Email atau password anda salah']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('auth::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('auth::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
