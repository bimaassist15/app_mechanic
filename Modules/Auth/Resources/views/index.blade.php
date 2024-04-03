@extends('layouts.auth.index')

@section('title')
    Halaman Login
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="index.html" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <img src="{{ asset('backend/logojm.jpg') }}" alt="" style="width: 110px;">
                                </span>

                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Welcome to Workshop App</h4>
                        <p class="mb-4">Silahkan Login, masukan email dan password anda</p>

                        <form id="formAuthentication" class="mb-3" action="{{ url('auth/login') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email or Username</label>
                                <input type="text"
                                    class="form-control 
                                    @error('email_or_username')
                                    border border-danger
                                @enderror"
                                    id="email" name="email_or_username" placeholder="Masukan email atau username"
                                    autofocus />
                                @error('email_or_username')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    {{-- <a href="{{ url('auth/forgotPassword') }}">
                                        <small>Forgot Password?</small>
                                    </a> --}}
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control @error('password')
                                        border border-danger
                                    @enderror"
                                        name="password" placeholder="Masukan password..." aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me" />
                                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>

                        {{-- <p class="text-center">
                            <span>Belum punya akun ?</span>
                            <a href="{{ url('auth/register') }}">
                                <span>Register Akun</span>
                            </a>
                        </p> --}}
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>
@endsection
