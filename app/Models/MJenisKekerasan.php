<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MJenisKekerasan extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;

    protected $table = 'm_jenis_kekerasan';
    protected $guarded = [];
}