<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\OtpController;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class ApiBaseController extends Controller
{
    public function register(Request $request)
    {
        if ($request->isMethod('get')) {
            abort(403);
        }

        if ($request->isMethod('post')) {
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

                $user = User::create(['name' => $fullname])
                    ->data()
                    ->create(['nama_lengkap' => $fullname, 'no_hp' => $phonenumber]);

                (new OtpController)->generateOtp($request);

                return response()->json(['status' => true, 'message' => 'Pendaftaran Berhasil, Masukkan kode OTP untuk lanjutkan login']);
            } catch (\Exception $error) {
                return response()->json(['status' => false, 'message' => $error->getMessage()]);
            }
        }

        return response()->json(['status' => false, 'message' => 'Method not allowed']);
    }

    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            abort(403);
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'phonenumber' => ['required', 'regex:/^08[0-9]{9,11}$/'],
                'token' => 'nullable|string',
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
                    if ($request->token) {
                        $login = (new OtpController)->validate($request);

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

                    $cacheKey = 'otp_api_' . $phonenumber;

                    if (Cache::has($cacheKey)) {
                        return response()->json(['status' => false, 'message' => 'OTP telah dikirim, silakan coba lagi setelah 30 detik.']);
                    }

                    (new OtpController)->generateOtp($request);

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
