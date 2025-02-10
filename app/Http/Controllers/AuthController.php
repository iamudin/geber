<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function whatsapp($request){
        if($request->phonenumber && $request->isMethod('post')){
           $validator= Validator::make($request->all(), [
                'phonenumber' => ['required', 'regex:/^08[0-9]{9,11}$/'],
            ], [
                'phonenumber.required' => 'Nomor HP wajib diisi.',
                'phonenumber.regex' => 'Format nomor HP tidak valid. Nomor harus diawali dengan 08 dan memiliki panjang 11-13 digit.'
            ]);
            if ($validator->fails()) {
                return back()->with('message',$validator->errors()->first());
            }
            $phonenumber = $request->phonenumber;

            try {
                $user = User::whereHas('data', fn($q) => $q->whereNoHp($phonenumber))->first();
                if ($user) {
                    if ($request->verify_otp && count($request->verify_otp) == 4) {
                        $otp = implode('',$request->verify_otp);
                        $login = (new OtpService)->validate($phonenumber,$otp);
                        if ($login->status === true) {
                            $user = User::find($user->id);
                            Auth::login($user);
                            $user->update([
                                'active_session'=>session()->getId()
                            ]);
                            return to_route('member.login',session()->getId());
                        }else{
                            return back()->with('message',
                            ['phonenumber'=>$phonenumber,'message'=>$login->message]);
                        }
                    }

                    $cacheKey = 'otp_' . $phonenumber;

                    if (Cache::has($cacheKey)) {
                        return back()->with('message','Terlalu banyak permintaan OTP, Tunggu beberpa detik lagi');
                    }
                    (new OtpService)->generate($phonenumber,4,1);
                    Cache::put($cacheKey, true, 59);
                    return back()->with('message',
                    ['phonenumber'=>$phonenumber]);
                }

                return back()->with('message','Nomor Pengguna tidak ditemukan');

            } catch (\Exception $error) {
                $reqId = Str::uuid()->toString();
                $reqPath = URL::current();
                $reqIp = $request->ip();
                Log::warning($reqId.' | '.$reqPath.' | '.$reqIp.' | '.$error->getMessage(), []);

                return response()->json(['error' => 'Something Error, Contact Provider.','requestId' => $reqId],500);
            }

        }
        return view('auth.whatsapp');
    }
    public function login(Request $request,$type=null){

        if($type==null){
            if($request->isMethod('post')){
                $validate = $request->validate([
                    'username' => 'required',
                    'password' => 'password',
                ]);

                if (Auth::attempt($this->validate())) {
                    if(Auth::user()->isAdmin()){
                        return to_route('admin.dashboard');
                    }elseif(Auth::user()->isMember()){
                        return to_route('home');
                    }
                }
                throw ValidationException::withMessages([
                    'email' => 'Email credentials not match',
                ]);
            }
            return view('auth.login');
        }

        if($type=='whatsapp'){

            return $this->whatsapp($request);

        }else{
            abort('404');
        }

    }

    public function register($referal=null){

    }
    public function logout(){
        Auth::logout();
        return to_route('home');
    }
}
