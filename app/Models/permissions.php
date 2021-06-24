<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permissions extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function permissionChildren(){
        return $this->hasMany(permissions::class,'parent_id');
    }
}
