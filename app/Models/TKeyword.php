<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TKeyword extends Model
{
    use HasFactory;

    protected $table = 't_keyword';
    protected $guarded = [];
}
