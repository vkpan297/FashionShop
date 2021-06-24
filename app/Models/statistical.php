<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class statistical extends Model
{
    use HasFactory;
    protected $table='tbl_statistical';
    protected $guarded=[];
    protected $primaryKey='id_statistical';
}
