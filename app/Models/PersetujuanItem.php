<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersetujuanItem extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;

    protected $table = 'persetujuan_item';
    protected $guarded = [];

    public function parent() {
        return $this->belongsTo('App\Models\PersetujuanItem', 'parent_id')->where('parent_id', 0)->with('parent');
    }
  
    public function children() {
        return $this->hasMany('App\Models\PersetujuanItem', 'parent_id')->with('children');
    }
}
