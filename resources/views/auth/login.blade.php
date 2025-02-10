@extends('layouts.auth')
@section('content')
    <div class="login-wrapper d-flex align-items-center justify-content-center text-center" style="background: #0360ac">
        <!-- Background Shape-->
        <div class="background-shape"></div>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-10 col-lg-8"><img class="big-logo" src="{{ asset('logo.png') }}" style="height: 90px" alt="">
              <!-- Register Form-->
              <div class="register-form mt-5">
                <form wire:submit="login">
                  <div class="form-group text-start mb-4"><span>Email</span>
                    <label for="username"><i class="ti ti-user"></i></label>
                    <input class="form-control" wire:model="email" id="email" type="text" placeholder="info@example.com">
                    @error('email')
                    <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="form-group text-start mb-4"><span>Password</span>
                    <label for="password"><i class="ti ti-key"></i></label>
                    <input class="form-control" wire:model="password" id="password" type="password" placeholder="Password">
                  </div>
                  <button class="btn btn-warning btn-lg w-100" type="submit">Log In</button>
                </form>
              </div>
              <!-- Login Meta-->
              <div class="login-meta-data"><a class="forgot-password d-block mt-3 mb-1" href="forget-password.html">Lupa Password?</a>
                <p class="mb-0">Belum terdaftar ?<a class="mx-1" href="register.html">Yuk Daftar Sekarang</a></p>
              </div>
              <!-- View As Guest-->
              <div class="view-as-guest mt-3"><a class="btn btn-primary btn-sm" href="{{ route('home') }}"> <i class="pe-2 ti ti-arrow-left"></i> Halaman utama</a></div>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection
