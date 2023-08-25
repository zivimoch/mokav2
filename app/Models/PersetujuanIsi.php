<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersetujuanIsi extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;

    protected $table = 'persetujuan_isi';
    protected $guarded = [];
}
