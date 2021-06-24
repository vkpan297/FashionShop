<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class categories extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable=['name','parent_id','slug'];
    public function category(){
        return $this->hasMany(categories::class,'parent_id');
    }
    public function products(){
        return $this->hasMany(products::class,'category_id');
    }
}
