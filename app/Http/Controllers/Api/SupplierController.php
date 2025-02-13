<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;

class SupplierController extends Controller
{
    function profile(Request $request){
        $user = $request->user();
        if($user->isSupplier()){
            $data = $user->load('supplier.files');
            $supplier = collect($data->supplier)->except('files');
            return response()->json([
                'data' => $supplier->merge(['photo' => $data->supplier->photo])
            ], 200);

        }
        return response()->json(['error'=>'Anda belum menjadi supplier'],404);
    }
function register(Request $request){
    $data = $request->user();
    $validator = $request->validate([
        'name'=> ['required','string'],
        'description'=>['required','string'],
        'address'=>['required','string'],
        'nib'=>['required','string'],
        'type'=>['required','in:distributor,produsen'],
    ]);
    if(!$data->isSupplier()){
        $supplier = $data->supplier()->create($validator);
    }else{
        $supplier = $data->supplier;
    }

    if($request->foto_depan_tempat_usaha){
       $supplier->addFile([
        'file'=>$request->file('foto_depan_tempat_usaha'),
        'purpose'=>'foto_depan_tempat_usaha',
        'mime_type'=>['image/png','image/jpeg']
       ]);
    }
    if($request->file_nib){
        $supplier->addFile([
         'file'=>$request->file('file_nib'),
         'purpose'=>'file_nib',
         'mime_type'=>['image/png','image/jpeg','application/pdf']
        ]);
     }
    if($request->foto_lokasi_produksi){
        $supplier->addFile([
            'file'=>$request->file('foto_lokasi_produksi'),
            'purpose'=>'foto_lokasi_produksi',
            'mime_type'=>['image/png','image/jpeg']
           ]);
    }
    if($request->foto_gudang){
        $supplier->addFile([
            'file'=>$request->file('foto_gudang'),
            'purpose'=>'foto_gudang',
            'mime_type'=>['image/png','image/jpeg']
           ]);
    }
    if($request->foto_display_produk){
        foreach($request->foto_display_produk as $key=>$foto){
            $supplier->addFile([
                'file'=>$foto,
                'purpose'=>'foto_display_produk',
                'collection'=>'multiple',
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
