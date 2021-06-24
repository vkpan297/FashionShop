<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $guarded=[];
    use HasFactory;
//    public function order(){
//        return $this->belongsToMany(products::class,'order_items','order_id','product_id');
//    }
}
