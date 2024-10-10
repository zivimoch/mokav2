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

    public function kasus()
    {
        return $this->belongsTo(Kasus::class, 'kasus_id');
    }

    public function petugas()
    {
        return $this->hasMany(Petugas::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pemantauan()
    {
        return $this->hasMany(Pemantauan::class);
    }

    public function terminasi()
    {
        return $this->hasMany(Terminasi::class);
    }

    public function tindakLanjut()
    {
        return $this->hasManyThrough(TindakLanjut::class, Agenda::class);
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }
    
}
