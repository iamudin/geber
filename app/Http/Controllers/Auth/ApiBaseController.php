<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Jobs\OtpSender;
use Illuminate\Support\Str;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
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
                'fullname' => ['required','regex:/^[a-zA-Z\s]+$/','max:255'],
            ], [
                'phonenumber.required' => 'Nomor HP wajib diisi.',
                'phonenumber.regex' => 'Format nomor HP tidak valid. Nomor harus diawali dengan 08 dan memiliki panjang 11-13 digit.',
                'fullname.required' => 'Nama lengkap wajib diisi.',
                'fullname.regex' => 'Nama lengkap hanya boleh huruf dan spasi',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()],400);
            }

            $phonenumber = $request->phonenumber;
            $fullname = $request->fullname;
            try {
            $userExists = User::whereHas('data', fn($q) => $q->whereNoHp($phonenumber))->exists();
            if ($userExists) {
                return response()->json([ 'error' => 'Nomor '.$phonenumber.' telah terdaftar di sistem'],409);
            }
            (new OtpService)->generate($phonenumber);
            Cache::put('register_data_'.$phonenumber,['phonenumber'=>$phonenumber,'fullname'=>$fullname]);
                return response()->json(['success' => 'Nama dan Nomor HP valid, Lanjutkan Verifikasi OTP'],202);
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
                $user = User::create(['name' => $session['fullname'],'role'=>'member'])
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
                return response()->json(['error' => $error->getMessage()]);
            }
        }else{
        return response()->json(['error' => 'Isi formulir registrasi terlebih dahulu'],400);

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
                'verify_otp' => 'nullable|numeric|digits:6',
            ], [
                'phonenumber.required' => 'Nomor HP wajib diisi.',
                'phonenumber.regex' => 'Format nomor HP tidak valid. Nomor harus diawali dengan 08 dan memiliki panjang 11-13 digit.',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()],400);
            }

            $phonenumber = $request->phonenumber;

            try {
                $user = User::whereHas('data', fn($q) => $q->whereNoHp($phonenumber))->first();

                if ($user) {

                    if($active = $user->activeToken()){
                        return response()->json(['error'=>'Akun dengan nomor '.$phonenumber.' sudah aktif di perangkat lain pada '.$active->last_used_at],409);

                    }
                    if ($request->verify_otp) {
                        $login = (new OtpService)->validate($phonenumber,$request->verify_otp);
                        if ($login->status === true) {
                            $user->tokens->each(function ($token) {
                                $token->delete();
                            });

                            $user = User::find($user->id);
                            $token = $user->createToken('auth_token')->plainTextToken;
                            return response()->json([
                                'data' => array_merge($user->toArray(),['token' => $token]),
                            ], 201);
                        }else{
                            return response()->json(['error'=>$login->message],401);
                        }

                        return $login;
                    }

                    $cacheKey = 'otp_' . $phonenumber;

                    if (Cache::has($cacheKey)) {
                        return response()->json(['error' =>'Terlalu banyak permintaan OTP, Tunggu beberpa detik lagi'],429);
                    }
                    (new OtpService)->generate($phonenumber);
                    Cache::put($cacheKey, true, 30);
                    return response()->json(['success' => 'Nomor Valid, silahkan input kode OTP'],202);
                }

                return response()->json(['error' => 'Nomor pengguna tidak ditemukan'],404);
            } catch (\Exception $error) {
                $reqId = Str::uuid()->toString();
                $reqPath = URL::current();
                $reqIp = $request->ip();
                Log::warning($reqId.' | '.$reqPath.' | '.$reqIp.' | '.$error->getMessage(), []);

                return response()->json(['error' => 'Something Error, Contact Provider.','requestId' => $reqId],500);
            }
        }
    }
}
