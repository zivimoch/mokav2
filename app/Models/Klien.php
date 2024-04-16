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


<<<<<<< HEAD
    public function t_tipe_disabilitas()
=======
    public function difabel_type()
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
    {
        return $this->belongsTo(DifabelType::class);
    }

    public function kondisi_khusus()
    {
<<<<<<< HEAD
        return $this->belongsTo(TKedaruratan::class);
=======
        return $this->belongsTo(KondisiKhusus::class);
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
    }
}
