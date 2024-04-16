<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Petugas extends Model
{
    use HasFactory;
<<<<<<< HEAD
    // use SoftDeletes;
=======
    use SoftDeletes;
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f

    protected $table = 'petugas';
    protected $guarded = [];
}
