<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RKategoriJenisBentuk extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'r_kategori_jenis_bentuk';
    protected $guarded = [];
}
