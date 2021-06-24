<?php

namespace App\Http\Controllers;

use App\Models\permissions;
use App\Models\roles;
use App\Traits\DeleteModelTrait;
use Illuminate\Http\Request;

class RoleAdminController extends Controller
{
    use DeleteModelTrait;
    private $roles;
    private $permissions;
    public function __construct(roles $roles,permissions $permissions){
        $this->permissions=$permissions;
        $this->roles=$roles;
    }
    public function index(){
        $listRole=$this->roles->paginate(5);
        return view('admin.role.index',compact('listRole'));
    }
    public function create(){
        $permissionParent=$this->permissions->where('parent_id',0)->get();
        return view('admin.role.add',compact('permissionParent'));
    }
    public function store(Request $request){
        $role=$this->roles->create([
            'name'=>$request->name,
            'display_name'=>$request->display_name
        ]);
        $role->permission()->attach($request->permission_id);
        return redirect()->route('role.index');
    }
    public function edit($id){
        $roleItem=$this->roles->find($id);
        $permissionParent=$this->permissions->where('parent_id',0)->get();
        $permissionsChecked=$roleItem->permission;
        return view('admin.role.edit',compact('roleItem','permissionParent','permissionsChecked'));
    }
    public function update(Request $request,$id){
        $this->roles->find($id)->update([
            'name'=>$request->name,
            'display_name'=>$request->display_name
        ]);
        $role=$this->roles->find($id);
        $role->permission()->sync($request->permission_id);
        return redirect()->route('role.index');
    }
    public function delete($id){
        return $this->deleteModelTrait($id,$this->roles);
    }
}
