<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\products;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index($slug,$categoryId,Request $request){
        $categoriesLimit=categories::where('parent_id',0)->take(3)->get();
        $categories=categories::where('parent_id',0)->get();
        $products=products::where('category_id',$categoryId)->paginate(9);
        foreach($products as $item){
            $nameCategory=$item->category->name;
            $proName=$item->name;
        }
        $url_canonical=$request->url();
        return view('category.product.list',compact('nameCategory','categoriesLimit','url_canonical','products','categories'));
    }
}
