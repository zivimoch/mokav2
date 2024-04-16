<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DifabelType extends Model
{
    use HasFactory;

    protected $table = 'difabel_type';
    protected $guarded = [];


    public function klien()
    {
        return $this->hasMany(Klien::class);
    }
}