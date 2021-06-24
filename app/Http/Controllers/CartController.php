<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\products;
use Illuminate\Http\Request;


class CartController extends Controller
{
    public function index($id,Request $request){
        $data=$request->all();
        $product=products::find($id);

        $cart=session()->get('cart');
        if(isset($cart[$id])){
            $cart[$id]['quantity']=$cart[$id]['quantity']+1;
            $cart[$id]['max_qty']=$product->product_quantity;
        }else{
            $cart[$id]=[
                'id'=>$product->id,
                'name'=>$product->name,
                'price'=>$product->price,
                'quantity'=>$data['qty'],
                'max_qty'=>$product->product_quantity,
                'image'=>$product->feature_image_path
            ];
        }
        session()->put('cart',$cart);
        return response()->json([
            'code'=>200,
            'message'=>'success',
        ],200);

    }
    public function showCart(Request $request){

        $carts=session()->get('cart');
        $categoriesLimit=categories::where('parent_id',0)->take(3)->get();
        $total=0;
        $url_canonical=$request->url();
        return view('category.product.cart',compact('url_canonical','categoriesLimit','carts'));

    }
    public function updateCart(Request $request){
        $url_canonical=$request->url();
        $categoriesLimit=categories::where('parent_id',0)->take(3)->get();
        if($request->id && $request->quantity){
            $carts=session()->get('cart');
            $carts[$request->id]['quantity']=$request->quantity;
            session()->put('cart',$carts);
            $carts=session()->get('cart');
            $cartComponent=view('category.product.cart',compact('carts','url_canonical','categoriesLimit'))->render();

            return response()->json([
                'carts'=>$cartComponent,
                'code'=>200
            ],200);

        }
    }
    public function deleteCart(Request $request){
        $url_canonical=$request->url();
        $categoriesLimit=categories::where('parent_id',0)->take(3)->get();
        if($request->id){
            $carts=session()->get('cart');
            unset($carts[$request->id]);
            session()->put('cart',$carts);
            $carts=session()->get('cart');
            $cartComponent=view('category.product.cart',compact('carts','url_canonical','categoriesLimit'))->render();
            return response()->json([
                'carts'=>$cartComponent,
                'code'=>200
            ],200);
        }
    }
}
