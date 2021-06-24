<?php

namespace App\Http\Controllers;

use App\Components\MenuRecusive;
use App\Http\Requests\MenuRequest;
use App\Models\menuses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminMenuController extends Controller
{
    private $menu;
    private $menuRecusive;
    public function __construct(menuses $menu,MenuRecusive $menuRecusive){
        $this->menu=$menu;
        $this->menuRecusive=$menuRecusive;
    }
    public function index(){
        $listmenus=$this->menu->latest()->paginate(5);
        return view('admin.menu.index',compact('listmenus'));
    }
    public function create(){
        $optionSelect=$this->menuRecusive->MenuRecusiveAdd();
        return view('admin.menu.add',compact('optionSelect'));
    }
    public function store(MenuRequest $request){
        $this->menu->create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'slug' => Str::slug($request->name)
        ]);
        return redirect()->route('menus.index');
    }
    public function edit($id){
        $menuItem=$this->menu->find($id);
        $optionSelect=$this->menuRecusive->MenuRecusiveEdit($menuItem->parent_id);
        return view('admin.menu.edit',compact('menuItem','optionSelect'));
    }
    public function update(Request $request,$id){
        $this->menu->find($id)->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'slug' => Str::slug($request->name)
        ]);
        return redirect()->route('menus.index');
    }
    public function delete($id){
        try{
            $this->menu->find($id)->delete();
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
}
