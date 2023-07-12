<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateKeyword extends Model
{
    use HasFactory;
    
    protected $table = 'template_keyword';
    protected $guarded = [];
}
