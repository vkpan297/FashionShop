<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class products extends Model
{
    protected $guarded=[];
    use SoftDeletes;
    use HasFactory;
    public function imageDetail(){
        return $this->hasMany(product_images::class,'product_id');
    }

    public function category(){
        return $this->belongsTo(categories::class,'category_id');
    }


    public function images(){
        return $this->hasMany(product_images::class,'product_id');
    }

    public function tags(){
        return $this
            ->belongsToMany(tag::class,'product_tags','product_id','tag_id')
            ->withTimestamps();
    }


}
