<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenKeyword extends Model
{
    use HasFactory;
    
    protected $table = 'dokumen_keyword';
    protected $guarded = [];
}
