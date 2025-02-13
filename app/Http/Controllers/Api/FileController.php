<?php

namespace App\Http\Controllers\Api;
use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function destroy(Request $request){
        abort_if(!$request->user() || !$request->isMethod('post'),404);
        if($request->file){
            $media = $request->file;
            $data = File::whereFileName(basename($media))->first();
            if($data){
                Storage::delete($data->file_path);
                $data->forceDelete();
                return response()->json(['success'=>'Berhasil Dihapus'],200);
            }
            return response()->json(['error'=>'File tidak ditemukan'],404);

        }
        }
}
