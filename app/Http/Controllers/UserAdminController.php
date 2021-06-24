<?php

namespace App\Http\Controllers;

use App\Models\roles;
use App\Models\User;
use App\Traits\DeleteModelTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;

class UserAdminController extends Controller
{
    use DeleteModelTrait;
    private $user;
    private $roles;
    public function __construct(User $user,roles $roles){
        $this->roles=$roles;
        $this->user=$user;
    }
    public function index(){
        $listUser=$this->user->paginate(5);
        return view('admin.user.index',compact('listUser'));
    }
    public function create(){
        $roles=$this->roles->all();
        return view('admin.user.add',compact('roles'));
    }
    public function store(Request $request){
        try {
            DB::beginTransaction();
            $user=$this->user->create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>$request->password
            ]);
            $roleId=$request->role_id;
            $user->roles()->attach($roleId);
            DB::commit();
            return redirect()->route('user.index');
        }catch (\Exception $exception){
            DB::rollBack();
            Log::error('Message:'.$exception->getMessage().'line:'.$exception->getLine());
        }
    }
    public function edit($id){
        $userItem=$this->user->find($id);
        $roles=$this->roles->all();
        $roleOfUser=$userItem->roles;
        return view('admin.user.edit',compact('userItem','roles','roleOfUser'));
    }
    public function update(Request $request,$id){
        try {
            DB::beginTransaction();
            $this->user->find($id)->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>$request->password
            ]);
            $user=$this->user->find($id);
            $roleId=$request->role_id;
            $user->roles()->sync($roleId);
            DB::commit();
            return redirect()->route('user.index');
        }catch (\Exception $exception){
            DB::rollBack();
            Log::error('Message:'.$exception->getMessage().'line:'.$exception->getLine());
        }
    }
    public function delete($id){
        return $this->deleteModelTrait($id,$this->user);
    }
}
