<?php
namespace App\Models;

use App\Traits\Fileable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory,Fileable;
    protected $fillable = ['name','description','address','type','nib','status'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function getPhotoAttribute()
    {
        return json_decode(json_encode(collect($this->files)->mapWithKeys(function ($file) {
            return [$file['purpose'] => 'https://'.$file['host'] .'/'. $file['file_path']];
        })));
    }
    public function getFotoDisplayProdukAttribute()
    {
        return $this->files
            ->filter(fn($file) => str_starts_with($file->purpose, 'foto-display-produk'))
            ->map(fn($file) => [
                'photo' => 'https://'.storage_url(''.$file->file_path), // Misalnya ada kolom URL
            ]);
    }


}
