<?php

namespace App\Http\Controllers;

use App\Components\Recusive;
use App\Http\Requests\CategoryRequest;
use App\Models\categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use function GuzzleHttp\Psr7\str;

class AdminCategoryController extends Controller
{
    private $category;

    public function __construct(categories $category){
        $this->category=$category;
    }
    public function getCategory($parentId){
        $data=$this->category->all();
        $recusive= new Recusive($data);
        $htmlOption=$recusive->categoryRecusive($parentId);
        return $htmlOption;
    }

    public function index(){
        $listCatgory=$this->category->latest()->paginate(5);

        return view('admin.category.index',compact('listCatgory'));
    }
    public function create(){
        $htmlOption=$this->getCategory($parentId='');
        return view('admin.category.add',compact('htmlOption'));
    }
    public function store(CategoryRequest $request){
        $this->category->create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'slug' =>Str::slug($request->name)
        ]);
        return redirect()-> route('categories.index');
    }
    public function edit($id){
        $categoryItem=$this->category->find($id);
        $htmlOption=$this->getCategory($categoryItem->parent_id);
        return view('admin.category.edit',compact('categoryItem','htmlOption'));
    }
    public function update(Request $request,$id){
        $this->category->find($id)->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'slug' =>Str::slug($request->name)
        ]);
        return redirect()-> route('categories.index');
    }
    public function delete($id){
        try{
            $this->category->find($id)->delete();
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
