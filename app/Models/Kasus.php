<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kasus extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;

    protected $table = 'kasus';
    protected $guarded = [];

    public function klien()
    {
        return $this->hasOne(Klien::class);
    }
}
