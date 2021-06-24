<?php

namespace App\Http\Controllers;

use App\Models\order_detail;
use App\Models\orders;
use App\Models\products;
use App\Models\statistical;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminOrderController extends Controller
{
    private $orders;
    private $order_detail;
    public function __construct(orders $orders,order_detail $order_detail){
        $this->order_detail=$order_detail;
        $this->orders=$orders;
    }
    public function index(){
        $listOrder=$this->orders->all();
        return view('admin.order.index',compact('listOrder'));
    }
    public function OrderDetail($id){
        $order=$this->orders->where('id',$id)->get();
        foreach ($order as $key=>$or){
            $order_status=$or->order_status;
        }
        $orderDetail=$this->order_detail->where('order_id',$id)->get();
        $total=0;
        return view('admin.order.detail',compact('orderDetail','total','order','order_status'));
    }
    public function update_order_quantity(Request $request){
        $data=$request->all();
        $order=$this->orders->find($data['order_id']);
        $order->order_status=$data['order_status'];
        $order->save();
        $order_product_id=$data['order_product_id'];
        $quantity=$data['quantity'];

        $order_date=$order->order_date;
        $statistic=statistical::where('order_date',$order_date)->get();
        if($statistic){
            $statistic_count=$statistic->count();
        }else{
            $statistic_count=0;
        }

        if($order->order_status == 2){
            $total_order=0;
            $sales=0;
            $profit=0;
            $total_quantity=0;
            foreach ($order_product_id as $key=>$product_id){
                $product=products::find($product_id);
                $product_qty=$product->product_quantity;
                $product_sold=$product->product_sold;
                $product_price=$product->price;
                $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
                foreach ($quantity as $key2=>$qty){
                    if ($key==$key2){
                        $pro_remain=$product_qty - $qty;
                        $product->product_quantity=$pro_remain;
                        $product->product_sold=$product_sold + $qty;
                        $product->save();

                        $total_quantity+=$qty;
                        $total_order+=1;
                        $sales+=$product_price*$qty;
                        $profit=$sales-1000;
                    }
                }
            }
            if($statistic_count>0){
                $statistic_update=statistical::where('order_date',$order_date)->first();
                $statistic_update->sales=$statistic_update->sales + $sales;
                $statistic_update->profit=$statistic_update->profit + $profit;
                $statistic_update->quantity=$statistic_update->quantity + $total_quantity;
                $statistic_update->total_order=$statistic_update->total_order + $total_order;
                $statistic_update->save();
            }else{
                $statistic_new=new statistical();
                $statistic_new->order_date=$order_date;
                $statistic_new->sales=$sales;
                $statistic_new->profit=$profit;
                $statistic_new->quantity=$total_quantity;
                $statistic_new->total_order=$total_order;
                $statistic_new->save();
            }

        }elseif($order->order_status != 2 && $order->order_status != 3){
            foreach ($order_product_id as $key=>$product_id){
                $product=products::find($product_id);
                $product_qty=$product->product_quantity;
                $product_sold=$product->product_sold;
                foreach ($quantity as $key2=>$qty){
                    if ($key==$key2){
                        $pro_remain=$product_qty + $qty;
                        $product->product_quantity=$pro_remain;
                        $product->product_sold=$product_sold - $qty;
                        $product->save();
                    }
                }
            }
        }


    }

    public function update_quantity(Request $request){
        $data=$request->all();
        $order_detail=$this->order_detail->where('product_id',$data['order_pro_id'])->first();
        $order_detail->product_quantity=$data['order_qty'];
        $order_detail->save();
    }
}
