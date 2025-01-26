<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
function logged(Request $request){
    $data = $request->user()->load('data');
    $data = [
        'id'=>$data->id,
        'nama_lengkap'=>$data->data->nama_lengkap,
        'alamat'=>$data->data->alamat,
        'domisili'=>$data->data->desa,
        'saldo'=>$data->balance,
    ];
    return response()->json(['data'=>$data],200);
}
function logout(Request $request){
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message'=>'Anda berhasil logout, terima kasih']);
}
}
