<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Klien extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;

    protected $table = 'klien';
    protected $guarded = [];


    public function t_tipe_disabilitas()
    {
        return $this->belongsTo(DifabelType::class);
    }

    public function kondisi_khusus()
    {
        return $this->belongsTo(TKedaruratan::class);
    }
}
