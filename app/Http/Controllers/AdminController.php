<?php

namespace App\Http\Controllers;

use App\Models\orders;
use App\Models\products;
use App\Models\statistical;
use App\Models\User;
use App\Models\visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function filter_by_date(Request $request){
        $data=$request->all();
        $from_date=$data['from_date'];
        $to_date=$data['to_date'];
        $get=statistical::whereBetween('order_date',[$from_date,$to_date])->orderBy('order_date','ASC')->get();

        foreach($get as $val){
            $chart_data[]=array(
                'period'=>$val->order_date,
                'order'=>$val->total_order,
                'sales'=>$val->sales,
                'profit'=>$val->profit,
                'quantity'=>$val->quantity,
            );
        }
        echo $data=json_encode($chart_data);
    }

    public function dashboard_filter(Request $request){
        $data=$request->all();
        $dauthangnay=Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dau_thangtruoc=Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoi_thangtruoc=Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();

        $sub7days=Carbon::now('Asia/Ho_Chi_Minh')->subDays(7)->toDateString();
        $sub365days=Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();

        $now=Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if($data['dashboard_value'] == '7ngay'){
            $get=statistical::whereBetween('order_date',[$sub7days,$now])->orderBy('order_date','ASC')->get();
        }elseif($data['dashboard_value'] == 'thangtruoc'){
            $get=statistical::whereBetween('order_date',[$dau_thangtruoc,$cuoi_thangtruoc])->orderBy('order_date','ASC')->get();
        }elseif($data['dashboard_value'] == 'thangnay'){
            $get=statistical::whereBetween('order_date',[$dauthangnay,$now])->orderBy('order_date','ASC')->get();
        }else{
            $get=statistical::whereBetween('order_date',[$sub365days,$now])->orderBy('order_date','ASC')->get();
        }

        foreach($get as $val){
            $chart_data[]=array(
                'period'=>$val->order_date,
                'order'=>$val->total_order,
                'sales'=>$val->sales,
                'profit'=>$val->profit,
                'quantity'=>$val->quantity,
            );
        }
        echo $data=json_encode($chart_data);

    }

    public function days_order(Request $request){
        $sub30days=Carbon::now('Asia/Ho_Chi_Minh')->subDays(30)->toDateString();
        $now=Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $get=statistical::whereBetween('order_date',[$sub30days,$now])->orderBy('order_date','ASC')->get();
        foreach($get as $val){
            $chart_data[]=array(
                'period'=>$val->order_date,
                'order'=>$val->total_order,
                'sales'=>$val->sales,
                'profit'=>$val->profit,
                'quantity'=>$val->quantity,
            );
        }
        echo $data=json_encode($chart_data);
    }

    public function index(Request $request){
        $user_ip_address=$request->ip();
        $early_last_month=Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $end_of_last_month=Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        $early_this_month=Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $oneyears=Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
        $now=Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        $visitor_of_lastmonth=visitor::whereBetween('created_at',[$early_last_month,$end_of_last_month])->get();
        $visitor_last_month_count=$visitor_of_lastmonth->count();

        $visitor_of_thismonth=visitor::whereBetween('created_at',[$early_this_month,$now])->get();
        $visitor_this_month_count=$visitor_of_thismonth->count();

        $visitor_of_year=visitor::whereBetween('created_at',[$oneyears,$now])->get();
        $visitor_year_count=$visitor_of_year->count();

        $visitor_current=visitor::where('ip_address',$user_ip_address)->get();
        $visitor_count=$visitor_current->count();

        if($visitor_count<1){
            $visitor=new visitor();
            $visitor->ip_address=$user_ip_address;
            $visitor->created_at=Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            $visitor->save();
        }
        $visitors=visitor::all();
        $visitor_total=$visitors->count();

        $product=products::all()->count();

        $product_views=products::orderBy('views_count','DESC')->take(20)->get();

        $order=orders::all()->count();

        $users=User::all()->count();

        return view('admin.home',compact('users','order','product_views','visitor_total','visitor_count','visitor_last_month_count','visitor_this_month_count','visitor_year_count','product'));
    }
}
