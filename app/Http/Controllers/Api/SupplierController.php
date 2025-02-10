<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;

class SupplierController extends Controller
{
    function detail(){
        $data = Supplier::find(2);
        $gambar = $data->getFirstMediaUrl('foto_depan_tempat_usaha', 'thumfgb');
        $template = '<img src="{{$gambar}}">';
        $html = Blade::render($template, ['gambar' => $gambar]);

        return response($html);
    }
function store(Request $request){
    $data = $request->user();
    $validator = $request->validate([
        'name'=> ['required','string'],
        'description'=>['required','string'],
        'address'=>['required','string'],
        'nib'=>['required','string'],
        'type'=>['required','in:distributor,produsen'],
    ]);
    $supplier = $data->load('supplier.files');
    // return $supplier;
    // $supplier = $data->supplier;
    return $supplier->supplier->foto_display_produk;
    if(!$data->isSupplier()){
        $supplier = $data->supplier()->create($validator);
    }
    if($request->foto_depan_tempat_usaha){
       $supplier->addFile([
        'file'=>$request->file('foto_depan_tempat_usaha'),
        'purpose'=>'foto_depan_tempat_usaha',
        'mime_type'=>['image/png','image/jpeg']
       ]);
    }
    if($request->foto_lokasi_produksi){
        $supplier->addMediaFromRequest('foto_lokasi_produksi')->toMediaCollection('foto_lokasi_produksi');
    }
    if($request->foto_gudang){
        $supplier->addMediaFromRequest('foto_gudang')->toMediaCollection('foto_gudang');
    }
    if($request->foto_display_produk){
        foreach($request->foto_display_produk as $key=>$foto){
            $supplier->addFile([
                'file'=>$foto,
                'purpose'=>'foto_display_produk-'.$key,
                'mime_type'=>['image/png','image/jpeg']
               ]);
        }


    }
    return response()->json(['success'=>'Supplier berhasil dibuat.'],200);
}
function logout(Request $request){
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message'=>'Anda berhasil logout, terima kasih']);
}
}
