<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Models\setting;
use App\Traits\DeleteModelTrait;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    use DeleteModelTrait;
    private $setting;
    public function __construct(setting $setting){
        $this->setting=$setting;
    }
    public function index(){
        $listAllSetting=$this->setting->latest()->paginate(5);
        return view('admin.setting.index',compact('listAllSetting'));
    }
    public function create(){
        return view('admin.setting.add');
    }
    public function store(SettingRequest $request){
        $this->setting->create([
            'config_key'=>$request->config_key,
            'config_value'=>$request->config_value,
            'type'=>$request->type
        ]);
        return redirect()->route('setting.index');
    }
    public function edit($id){
        $settingItem=$this->setting->find($id);
        return view('admin.setting.edit',compact('settingItem'));
    }
    public function update(Request $request,$id){
        $this->setting->find($id)->update([
            'config_key'=>$request->config_key,
            'config_value'=>$request->config_value
        ]);
        return redirect()->route('setting.index');
    }
    public function delete($id){
        return $this->deleteModelTrait($id,$this->setting);
    }
}
