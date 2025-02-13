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
        $files = collect($this->files);

        return $files->groupBy('purpose')->map(function ($group) {
            // Ambil nilai type dari salah satu file dalam grup (karena semua harus sama)
            $type = $group->first()['collection'];

            // Buat daftar URL
            $urls = $group->map(fn($file) => 'https://' . storage_url(). '/' . $file['file_path'])->toArray();

            // Jika type adalah 'single', kembalikan string, jika 'multiple', kembalikan array
            return $type === 'single' ? $urls[0] : $urls;
        })->toArray();
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
