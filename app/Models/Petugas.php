<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Petugas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'petugas';
    protected $guarded = [];
}
