@extends('layouts.auth')
@section('content')
<div class="login-wrapper d-flex align-items-center justify-content-center text-center">
    <div class="container">
        <center>
        <img  src="{{ asset('logo.png') }}" class="mb-5" style="width:100px;" alt="">

        </center>
      <div class="row justify-content-center">
        <div class="col-10 col-lg-8">

            @if(Session::has('message'))

            @if(!is_array(Session::get('message')))
            <div class="alert alert-danger">{{ Session::get('message') }}</div>
            @else
            <div class="text-start rtl-text-right">
                <h5 class="mb-1 text-white">Login via Whatsapp</h5>
                <p class="mb-4 text-white">Verifikasi kode OTP</p>
              </div>
           @isset(Session::get('message')['message']) <div class="alert alert-danger">{{ Session::get('message')['message'] ?? null }}</div> @endisset

            @endif
            @else
          <div class="text-start rtl-text-right">
            <h5 class="mb-1 text-white">Login via Whatsapp</h5>
            <p class="mb-4 text-white">Kode akan dikirim ke nomor whatsapp kamu.</p>
          </div>
          @endif
          <!-- OTP Send Form-->
          <div class="otp-form mt-5">

            <style>
                input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
            </style>
            <form action="{{URL::current()}}" method="POST">
                @csrf
              <div class="mb-4 d-flex rtl-flex-d-row-r">
                <input class="form-control ps-0" style="border-radius:10px !important;padding-left:20px !important;font-size:30px" id="phone_number" name="phonenumber" value="{{ Session::get('message')['phonenumber'] ?? null }}" type="number" placeholder="089123456789" >
              </div>
              @if(Session::has('message') && is_array(Session::get('message')))
              <div class="otp-verify-form mt-5">
              <div class="d-flex justify-content-between mb-5 rtl-flex-d-row-r">
                <input class="single-otp-input form-control" style="border-radius:10px !important" type="number" value="" placeholder="-" maxlength="1" name="verify_otp[]">
                <input class="single-otp-input form-control" style="border-radius:10px !important" type="number" value="" placeholder="-" maxlength="1" name="verify_otp[]">
                <input class="single-otp-input form-control" style="border-radius:10px !important" type="number" value="" placeholder="-" maxlength="1" name="verify_otp[]">
                <input class="single-otp-input form-control" style="border-radius:10px !important" type="number" value="" placeholder="-" maxlength="1" name="verify_otp[]">

              </div>
            </div>
            @endif
              <button class="btn btn-warning btn-lg w-100" type="submit">Lanjut</button>

            </form>
          </div>
          <!-- Term & Privacy Info-->
          <div class="login-meta-data">
            <p class="mt-3 mb-0"><a class="mx-1" href="#">Term of Services</a>and<a class="mx-1" href="#">Privacy Policy.</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
