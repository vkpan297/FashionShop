<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\devvn_quanhuyen;
use App\Models\devvn_tinhthanhpho;
use App\Models\devvn_xaphuongthitran;
use App\Models\feeship;
use App\Models\order_detail;
use App\Models\order_item;
use App\Models\orders;
use App\Models\payment;
use App\Models\products;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Carbon;

class CheckoutController extends Controller
{
    private $orders;
    private $products;
    private $order_detail;
    private $devvn_tinhthanhpho;
    private $devvn_quanhuyen;
    private $devvn_xaphuongthitran;
    private $feeship;
    public function __construct(feeship $feeship,orders $orders,products $products,order_detail $order_detail,devvn_tinhthanhpho $devvn_tinhthanhpho,devvn_quanhuyen $devvn_quanhuyen,devvn_xaphuongthitran $devvn_xaphuongthitran){
        $this->orders=$orders;
        $this->products=$products;
        $this->order_detail=$order_detail;
        $this->devvn_tinhthanhpho=$devvn_tinhthanhpho;
        $this->devvn_quanhuyen=$devvn_quanhuyen;
        $this->devvn_xaphuongthitran=$devvn_xaphuongthitran;
        $this->feeship=$feeship;
    }
    public function select_delivery_home(Request $request){
        $data=$request->all();
        if($data['action']){
            $output='';
            if($data['action']=="tp"){
                $select_qh=$this->devvn_quanhuyen->where('matp',$data['ma_id'])->orderby('maqh','ASC')->get();
                $output.='<option>--Chọn quận huyện--</option>';
                foreach($select_qh as $key=>$qh){
                    $output.='<option value="' .$qh->maqh. '">' .$qh->name_qh. '</option>';
                }

            }else{
                $select_xp=$this->devvn_xaphuongthitran->where('ma_qh',$data['ma_id'])->orderby('xaid','ASC')->get();
                $output.='<option>--Chọn xã phường--</option>';
                foreach($select_xp as $key=>$xp){
                    $output.='<option value="' .$xp->xaid. '">' .$xp->name_xp. '</option>';
                }
            }
            echo $output;
        }
    }

    public function calculate_fee(Request $request){
        $data=$request->all();
        if($data['matp']){
            $feeship=$this->feeship->where('fee_matp',$data['matp'])
                                    ->where('fee_maqh',$data['maqh'])
                                    ->where('fee_xaid',$data['xaid'])->get();
            foreach ($feeship as $key=>$value){
                session()->put('fee',$value->fee_feeship);
                session()->save();
            }
        }
    }

    public function checkout(Request $request){
        if(auth()->check()){
            $carts=session()->get('cart');
            $categoriesLimit=categories::where('parent_id',0)->take(3)->get();
            $total=0;
            $url_canonical=$request->url();
            $tp=$this->devvn_tinhthanhpho->orderby('matp','ASC')->get();
            return view('category.product.checkout',compact('url_canonical','tp','categoriesLimit','carts','total'));
        }else{
            return view('auth.login');
        }
    }

    public function save_checkout(Request $request){
        $carts=session()->get('cart');
        $order_date=Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $dataOrder=[
            'user_id'=>auth()->id(),
            'name'=>$request->name,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'email'=>$request->email,
            'order_status'=>1,
            'order_date'=>$order_date,
            'order_notes'=>$request->order_notes
        ];
        $order=$this->orders->create($dataOrder);
        foreach ($carts as $cartItem) {
            $dataOrderDetail = [
                'order_id' => $order['id'],
                'product_id' => $cartItem['id'],
                'product_name' => $cartItem['name'],
                'product_price' => $cartItem['price'],
                'product_quantity' => $cartItem['quantity']
            ];
            $orderdetail = $this->order_detail->create($dataOrderDetail);
        }
        session()->flush();
        return redirect('/');
    }
}
