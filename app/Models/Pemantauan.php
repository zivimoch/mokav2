<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemantauan extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;

    protected $table = 'pemantauan';
    protected $guarded = [];
}
