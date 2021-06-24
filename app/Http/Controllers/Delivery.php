<?php

namespace App\Http\Controllers;

use App\Models\devvn_quanhuyen;
use App\Models\devvn_tinhthanhpho;
use App\Models\devvn_xaphuongthitran;
use App\Models\feeship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Delivery extends Controller
{
    private $devvn_quanhuyen;
    private $devvn_tinhthanhpho;
    private $devvn_xaphuongthitran;
    private $feeship;
    public function __construct(devvn_quanhuyen $devvn_quanhuyen,devvn_tinhthanhpho $devvn_tinhthanhpho,devvn_xaphuongthitran $devvn_xaphuongthitran,feeship $feeship){
        $this->devvn_quanhuyen=$devvn_quanhuyen;
        $this->devvn_tinhthanhpho=$devvn_tinhthanhpho;
        $this->devvn_xaphuongthitran=$devvn_xaphuongthitran;
        $this->feeship=$feeship;
    }
    public function select_feeship(){
        $feeship = $this->feeship->orderby('id','DESC')->get();
        $output = '';
        $output .= '<table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên Tỉnh/Thành Phố</th>
                                <th scope="col">Tên Quận Huyện</th>
                                <th scope="col">Tên Xã/Phường</th>
                                <th scope="col">Phí vận chuyển</th>
                            </tr>
                            </thead>
                            <tbody>
				';

        foreach( $feeship as $item ){
            $output.='
					            <tr>
                                    <th scope="row">'.$item->id.'</th>
                                    <td>'.$item->city->name_tp.'</td>
                                    <td>'.$item->province->name_qh.'</td>
                                    <td>'.$item->wards->name_xp.'</td>
                                    <td class="fee_feeship_edit" contenteditable data-feeship_id="'.$item->id.'">'.number_format($item->fee_feeship) .'</td>
                                </tr>
					';
        }
        $output.='
				</tbody>
                </table>
				';
        echo $output;
    }
    public function index(){
        $tp=$this->devvn_tinhthanhpho->orderby('matp','ASC')->get();

        return view('admin.fee.index',compact('tp'));
    }
    public function select_delivery(Request $request){
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

    public function insert_delivery(Request $request){
        $data = $request->all();
        $fee_ship = new feeship();
        $fee_ship->fee_matp = $data['tp'];
        $fee_ship->fee_maqh = $data['qh'];
        $fee_ship->fee_xaid = $data['xp'];
        $fee_ship->fee_feeship = $data['fee_ship'];
        $fee_ship->save();
    }
    public function update_delivery(Request $request){
        $data = $request->all();
        $fee_ship = $this->feeship->find($data['feeship_id']);
        $fee_value=rtrim($data['fee_value'],'.');
        $fee_ship->fee_feeship = $fee_value;
        $fee_ship->save();
    }
}
