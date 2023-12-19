<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KondisiKhusus extends Model
{
    protected $table = 'kondisi_khusus';
    protected $guarded = [];

    public function clients()
    {
        return $this->hasMany(Klien::class);
    }
}
