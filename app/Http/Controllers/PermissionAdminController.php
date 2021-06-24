<?php

namespace App\Http\Controllers;

use App\Models\permissions;
use App\Models\roles;
use App\Traits\DeleteModelTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PermissionAdminController extends Controller
{
    use DeleteModelTrait;
    private $permissions;
    private $roles;
    public function __construct(roles $roles,permissions $permissions){
        $this->permissions=$permissions;
        $this->roles=$roles;
    }
    public function index(){
        $listPermission=$this->permissions->where('parent_id',0)->get();
        return view('admin.permission.index',compact('listPermission'));
    }
    public function create(){
        return view('admin.permission.add');
    }
    public function store(Request $request){
        $permission=permissions::create([
            'name'=>$request->module_parent,
            'display_name'=>$request->module_parent,
            'parent_id'=>0,
            'key_code'=>$request->module_parent
        ]);
        foreach ($request->module_children as $value){
            permissions::create([
                'name'=>$value,
                'display_name'=>$value,
                'parent_id'=>$permission->id,
                'key_code'=>$value.'_'.$request->module_parent
            ]);
        }
        return redirect()->route('permission.index');
    }
    public function delete($id){
        try{
            $this->permissions->find($id)->delete();
            $this->permissions->where('parent_id',$id)->delete();
            return response()->json([
                'code'=>200,
                'message'=>'success'
            ],200);
        }catch (\Exception $exception){
            Log::error('Message:'.$exception->getMessage().'line:'.$exception->getLine());
            return response()->json([
                'code'=>500,
                'message'=>'fail'
            ],500);
        }
    }
    public function edit($id){

        $permissionItem=$this->permissions->find($id);
        $permissionParent=$this->permissions->where('parent_id',0)->get();
        $permissionChild=$permissionItem->permissionChildren;
        return view('admin.permission.edit',compact('permissionItem','permissionChild','permissionParent'));
    }

}
