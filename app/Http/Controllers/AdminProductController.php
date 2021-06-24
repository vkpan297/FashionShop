<?php

namespace App\Http\Controllers;

use App\Components\Recusive;
use App\Http\Requests\ProductRequest;
use App\Models\categories;
use App\Models\product_images;
use App\Models\product_tags;
use App\Models\products;
use App\Models\tag;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use DB;

class AdminProductController extends Controller
{
    use StorageImageTrait;
    private $categories;
    private $products;
    private $productImage;
    private $tag;
    private $productTag;
    public function __construct(products $products,categories $categories,product_images $productImage,product_tags $productTag,tag $tag){
        $this->products=$products;
        $this->categories=$categories;
        $this->tag=$tag;
        $this->productImage=$productImage;
        $this->productTag=$productTag;
    }
    public function getCategory($parentId){
        $data=$this->categories->all();
        $recusive= new Recusive($data);
        $htmlOption=$recusive->categoryRecusive($parentId);
        return $htmlOption;
    }
    public function index(){
        $listProduct=$this->products->latest()->paginate(5);
        return view('admin.product.index',compact('listProduct'));
    }
    public function create(){
        $htmlOption=$this->getCategory($parentId='');
        return view('admin.product.add',compact('htmlOption'));
    }
    public function store(ProductRequest $request){
        try {
            DB::beginTransaction();
            $dataProductCreate=[
                'name'=>$request->name,
                'price'=>$request->price,
                'product_quantity'=>$request->product_quantity,
                'content'=>$request->contents,
                'user_id'=>auth()->id(),
                'category_id'=>$request->category_id,
                'views_count'=>0,
                'product_sold'=>0
            ];
            $dataUploadFeatureImage=$this->storageTraitUpload($request,'feature_image_path','product');
            if(!empty($dataUploadFeatureImage)){
                $dataProductCreate['feature_image_path']=$dataUploadFeatureImage['file_path'];
                $dataProductCreate['feature_image_name']=$dataUploadFeatureImage['file_name'];
            }
            $product=$this->products->create($dataProductCreate);

            //Insert data to product_image
            if($request->hasFile('image_path')){
                foreach ($request->image_path as $fileItem){
                    $dataProductImageDetail=$this->storageTraitUploadMutible($fileItem,'product');
                    $product->images()->create([
                        'image_path'=>$dataProductImageDetail['file_path'],
                        'image_name'=>$dataProductImageDetail['file_name']
                    ]);
                }
            }
            //Insert tags for product
            if(!empty($request->tags)){
                foreach ($request->tags as $tagItem){
                    $tagInstance=$this->tag->firstOrCreate([
                        'name'=>$tagItem
                    ]);
                    $tagIds[]=$tagInstance->id;
                }
                $product->tags()->attach($tagIds);
            }
            DB::commit();
            return redirect()->route('product.index');
        }catch (\Exception $exception){
            DB::rollBack();
            Log::error('Message:'.$exception->getMessage().'line:'.$exception->getLine());
        }
    }

    public function edit($id){
        $productItem=$this->products->find($id);
        $htmlOption=$this->getCategory($productItem->category_id);
        return view('admin.product.edit',compact('htmlOption','productItem'));
    }
    public function update(Request $request,$id){
        try {
            DB::beginTransaction();
            $dataProductUpdate=[
                'name'=>$request->name,
                'price'=>$request->price,
                'product_quantity'=>$request->product_quantity,
                'content'=>$request->contents,
                'user_id'=>auth()->id(),
                'category_id'=>$request->category_id,
                'views_count'=>0
            ];
            $dataUploadFeatureImage=$this->storageTraitUpload($request,'feature_image_path','product');
            if(!empty($dataUploadFeatureImage)){
                $dataProductUpdate['feature_image_path']=$dataUploadFeatureImage['file_path'];
                $dataProductUpdate['feature_image_name']=$dataUploadFeatureImage['file_name'];
            }
            $this->products->find($id)->update($dataProductUpdate);
            $product=$this->products->find($id);

            //Insert data to product_image
            if($request->hasFile('image_path')){
                $this->productImage->where('product_id',$id)->delete();
                foreach ($request->image_path as $fileItem){
                    $dataProductImageDetail=$this->storageTraitUploadMutible($fileItem,'product');
                    $product->images()->create([
                        'image_path'=>$dataProductImageDetail['file_path'],
                        'image_name'=>$dataProductImageDetail['file_name']
                    ]);
                }
            }
            //Insert tags for product
            if(!empty($request->tags)){
                foreach ($request->tags as $tagItem){
                    $tagInstance=$this->tag->firstOrCreate([
                        'name'=>$tagItem
                    ]);
                    $tagIds[]=$tagInstance->id;
                }
                $product->tags()->sync($tagIds);
            }
            DB::commit();
            return redirect()->route('product.index');
        }catch (\Exception $exception){
            DB::rollBack();
            Log::error('Message:'.$exception->getMessage().'line:'.$exception->getLine());
        }
    }
    public function delete($id){
        try{
            $this->products->find($id)->delete();
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
