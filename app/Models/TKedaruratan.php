<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TKedaruratan extends Model
{
    protected $table = 't_kedaruratan';
    protected $guarded = [];

    public function clients()
    {
        return $this->hasMany(Klien::class);
    }
}
