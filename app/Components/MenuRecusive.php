<?php

namespace App\Components;

use App\Models\menuses;

class MenuRecusive{
    private $html='';
    public function __construct(){
        $this->html='';
    }
    public function MenuRecusiveAdd($parent_id=0){
        $data=menuses::where('parent_id',$parent_id)->get();
        foreach ($data as $value){
            $this->html.='<option value="'.$value->id.'">'.$value->name.'</option>';
            $this->MenuRecusiveAdd($value->id);
        }
        return $this->html;
    }
    public function MenuRecusiveEdit($parentIdMenuEdit,$parent_id=0){
        $data=menuses::where('parent_id',$parent_id)->get();
        foreach ($data as $value){
            if($parentIdMenuEdit == $value->id){
                $this->html.='<option selected value="'.$value->id.'">'.$value->name.'</option>';
            }else{
                $this->html.='<option value="'.$value->id.'">'.$value->name.'</option>';
            }

            $this->MenuRecusiveEdit($parentIdMenuEdit,$value->id);
        }
        return $this->html;
    }
}
