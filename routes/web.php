<?php
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\FilesMiddleware;
use App\Http\Controllers\FileManagerController;


require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/member.php';
Route::match(['post','get'],'media/destroy', [FileManagerController::class, 'destroy'])->name('media.destroy');
Route::match(['post','get'], 'media/upload', [FileManagerController::class, 'upload'])->name('media.upload');
// Route::middleware(FilesMiddleware::class)->match(['post', 'get'], 'media/{slug}', [FileManagerController::class, 'stream_by_id'])
//     ->where('slug', '(?!' . implode('|', ['destroy', 'upload']) . ')[a-zA-Z0-9-]+(\.('.implode('|', flc_ext()).'))$')->name('stream');
if(app()->environment('production')){
    Route::get('/', [App\Http\Controllers\HomeController::class,'index'])->name('home');
}else{
    Route::get('/', function () {
        return view('cooming');
    })->name('home');
}
Route::get('/supplier', [App\Http\Controllers\Api\SupplierController::class,'detail']);
// Route::get('/dashboard', [App\Http\Controllers\Auth\WebBaseController::class,'dashboard'])->name('dashboard');
