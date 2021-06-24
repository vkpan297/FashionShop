<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\comment;
use App\Models\products;
use App\Models\Slider;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function send_comment(Request $request){
        $product_id=$request->product_id;
        $comment_name=$request->comment_name;
        $comment_content=$request->comment_content;
        $comment=new comment();
        $comment->comment=$comment_content;
        $comment->comment_name=$comment_name;
        $comment->comment_product_id=$product_id;
        $comment->comment_status=0;
        $comment->save();
    }
    public function load_comment(Request $request){
        $product_id=$request->product_id;
        $comment=comment::where('comment_product_id',$product_id)->where('comment_parent',null)->where('comment_status',0)->get();
        $comment_rep=comment::where('comment_parent','!=',null)->get();
        $output='';
        foreach($comment as $item){
            $output .= '
                <div class="row style_comment">
                    <div class="col-md-2">
                        <img src="'.url('frontend/image/icon1.jpg').'" class="img img-responsive img-thumbnail">
                    </div>
                    <div class="col-md-10">
                        <p style="color: green;">@'.$item->comment_name.'</p>
                        <p style="color: #000;">'.$item->created_at.'</p>
                        <p style="color: #000;">'.$item->comment.'</p>
                    </div>
                </div>
                ';
                foreach($comment_rep as $reply_comment){
                    if($reply_comment->comment_parent==$item->id){
                        $output .= '<div class="row style_comment" style="margin-left: 100px;"  >
                        <div class="col-md-2">
                            <img src="'.url('frontend/image/iconadmin.png').'" class="img img-responsive img-thumbnail">
                        </div>
                        <div class="col-md-10">
                            <p style="color: blue;">@Cương(admin)</p>
                            <p style="color: #000;">'.$reply_comment->comment.'</p>
                            <p style="color: #000;"></p>
                        </div>
                        </div>';
                    }
                }
        }
        echo $output;
    }
    public function save_views(Request $request){
        $data=$request->all();
        $pr=products::find($data['id']);
        $pr->views_count=$data['product_view']+1;
        $pr->save();
    }
    public function detail(Request $request,$id){

        $productDetail=products::where('id',$id)->get();
        foreach($productDetail as $proItem){
            $nameCategory=$proItem->category->name;
            $idCategory=$proItem->category->id;
            $slugCategory=$proItem->category->slug;
            $proName=$proItem->name;
        }
        $categoriesLimit=categories::where('parent_id',0)->take(3)->get();
        $categories=categories::where('parent_id',0)->get();
        $url_canonical=$request->url();
        $productRecommend=products::latest('views_count','desc')->take(6)->get();
        return view('category.product.detail',compact('proName','slugCategory','idCategory','nameCategory','url_canonical','productDetail','categoriesLimit','categories','productRecommend'));
    }
    public function product_tag(Request $request,$product_tag){
        $productTag=products::where('name','LIKE','%'.$product_tag.'%')->get();
        $categoriesLimit=categories::where('parent_id',0)->take(3)->get();
        $categories=categories::where('parent_id',0)->get();
        $url_canonical=$request->url();
        $productRecommend=products::latest('views_count','desc')->take(6)->get();
        $sliders=Slider::latest()->get();
        return view('category.product.tag',compact('url_canonical','sliders','productTag','product_tag','categoriesLimit','categories','productRecommend'));
    }
}
