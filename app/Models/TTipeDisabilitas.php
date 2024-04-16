<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TTipeDisabilitas extends Model
{
    use HasFactory;

    protected $table = 't_tipe_disabilitas';
    protected $guarded = [];


    public function klien()
    {
        return $this->hasMany(Klien::class);
    }
}