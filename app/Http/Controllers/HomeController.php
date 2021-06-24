<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\products;
use App\Models\Slider;
use Illuminate\Http\Request;
use function PHPUnit\Framework\returnValue;

class HomeController extends Controller
{

    public function index(Request $request){
        $meta_decs="Shop hàng hiệu quần áo thời trang nam nữ đẹp giá rẻ - Chất liệu vãi cao cấp, Giao hàng tận nơi, Thanh toán tại nhà.";
        $meta_keywords="thời trang nam nữ, thời trang nam nữ đẹp, quần áo thời trang nam nữ, shop quần áo nam nữ, shop thời trang nữ";
        $meta_title="Shop Quần Áo Thời Trang Nam Nữ Đẹp Giá Rẻ";
        $url_canonical=$request->url();

        $categories=categories::where('parent_id',0)->get();
        $categoriesLimit=categories::where('parent_id',0)->take(3)->get();
        $sliders=Slider::latest()->get();
        $products=products::latest()->take(6)->get();
        $productRecommend=products::latest('views_count','desc')->take(6)->get();
        return view('home.home',compact('sliders','url_canonical','meta_title','meta_keywords','meta_decs','categories','products','productRecommend','categoriesLimit'));
    }

    public function getSearch(Request $request){
        $meta_decs="Shop hàng hiệu quần áo thời trang nam nữ đẹp giá rẻ - Chất liệu vãi cao cấp, Giao hàng tận nơi, Thanh toán tại nhà.";
        $meta_keywords="thời trang nam nữ, thời trang nam nữ đẹp, quần áo thời trang nam nữ, shop quần áo nam nữ, shop thời trang nữ";
        $meta_title="Shop Quần Áo Thời Trang Nam Nữ Đẹp Giá Rẻ";
        $url_canonical=$request->url();

        $categoriesLimit=categories::where('parent_id',0)->take(3)->get();
        $categories=categories::where('parent_id',0)->get();
        $productSearch=products::where('name','like','%'.$request->key.'%')
                                    ->orWhere('price',$request->key)->get();
        return view('components.search',compact('productSearch','url_canonical','meta_title','meta_keywords','meta_decs','categoriesLimit','categories'));
    }
}
