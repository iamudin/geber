<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\OtpController;

class ApiBaseController extends Controller
{
    public function register(Request $request)
    {
        if ($request->isMethod('get')) {
            abort(403);
        }

        if ($request->isMethod('post')) {
        if(!$request->verify_otp){
            $validator = Validator::make($request->all(), [
                'phonenumber' => ['required', 'regex:/^08[0-9]{9,11}$/'],
                'fullname' => 'required|string|max:255',
            ], [
                'phonenumber.required' => 'Nomor HP wajib diisi.',
                'phonenumber.regex' => 'Format nomor HP tidak valid. Nomor harus diawali dengan 08 dan memiliki panjang 11-13 digit.',
                'fullname.required' => 'Nama lengkap wajib diisi.',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }

            $phonenumber = $request->phonenumber;
            $fullname = $request->fullname;
            try {
            $userExists = User::whereHas('data', fn($q) => $q->whereNoHp($phonenumber))->exists();
            if ($userExists) {
                return response()->json(['status' => false, 'message' => 'Nomor telah terdaftar']);
            }
            (new OtpService)->generate($phonenumber);
            Cache::put('register_data_'.$phonenumber,['phonenumber'=>$phonenumber,'fullname'=>$fullname]);
                return response()->json(['status' => true, 'message' => 'Lanjutkan Verifikasi OTP']);
        }catch (\Exception $error) {
            return response()->json(['status' => false, 'message' => $error->getMessage()]);
        }

        }else{

            if($session = Cache::get('register_data_'.$request->phonenumber)){
                $cekotp = (new OtpService)->validate($session['phonenumber'],$request->verify_otp);
                if($cekotp->status === false){
                    return $cekotp;
                }

            try {
                $user = User::create(['name' => $session['fullname']])
                    ->data()
                    ->create(['nama_lengkap' => $session['fullname'], 'no_hp' => $session['phonenumber']]);
                        $token = $user->user->createToken('auth_token')->plainTextToken;
                        Cache::forget('register_data_'.$request->phonenumber);
                        return response()->json([
                            'status' => true,
                            'message' => 'Login berhasil',
                            'user' => $user->user,
                            'token' => $token,
                        ], 201);

            } catch (\Exception $error) {
                return response()->json(['status' => false, 'message' => $error->getMessage()]);
            }
        }else{
        return response()->json(['status' => false, 'message' => 'Isi formulir registrasi terlebih dahulu']);

        }
    }

        }

    }

    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            abort(403);
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'phonenumber' => ['required', 'regex:/^08[0-9]{9,11}$/'],
                'verify_otp' => 'nullable|numeric',
            ], [
                'phonenumber.required' => 'Nomor HP wajib diisi.',
                'phonenumber.regex' => 'Format nomor HP tidak valid. Nomor harus diawali dengan 08 dan memiliki panjang 11-13 digit.',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }

            $phonenumber = $request->phonenumber;

            try {
                $user = User::whereHas('data', fn($q) => $q->whereNoHp($phonenumber))->first();

                if ($user) {
                    if ($request->verify_otp) {
                        $login = (new OtpService)->validate($phonenumber,$request->verify_otp);
                        if ($login->status === true) {
                            $token = $user->createToken('auth_token')->plainTextToken;
                            return response()->json([
                                'status' => true,
                                'message' => 'Login berhasil',
                                'user' => $user,
                                'token' => $token,
                            ], 201);
                        }

                        return $login;
                    }

                    $cacheKey = 'otp_' . $phonenumber;

                    if (Cache::has($cacheKey)) {
                        return response()->json(['status' => false, 'message' => 'OTP telah dikirim, silakan coba lagi setelah 30 detik.']);
                    }
                    (new OtpService)->generate($phonenumber);
                    Cache::put($cacheKey, true, 30);
                    return response()->json(['status' => true, 'message' => 'Nomor Terdaftar, Masukkan Kode OTP']);
                }

                return response()->json(['status' => false, 'message' => 'User Tidak Valid']);
            } catch (\Exception $error) {
                return response()->json(['status' => false, 'message' => $error->getMessage()]);
            }
        }
    }
}
