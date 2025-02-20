<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataUser extends Model
{
    protected $fillable = [
        'nama_lengkap',
        'no_hp',
    ];
    function user(){
        return $this->belongsTo(User::class);
    }
}
