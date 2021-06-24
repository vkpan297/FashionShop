<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class feeship extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function city(){
        return $this->belongsTo(devvn_tinhthanhpho::class, 'fee_matp','matp');
    }
    public function province(){
        return $this->belongsTo(devvn_quanhuyen::class, 'fee_maqh','maqh');
    }
    public function wards(){
        return $this->belongsTo(devvn_xaphuongthitran::class, 'fee_xaid','xaid');
    }
}
