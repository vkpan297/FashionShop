<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\contact;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    use StorageImageTrait;
    private $contact;
    public function __construct(contact $contact)
    {
        $this->contact=$contact;
    }
    public function lien_he(Request $request){
        $contact=$this->contact->all();
        $categoriesLimit=categories::where('parent_id',0)->take(3)->get();
        $url_canonical=$request->url();
        return view('home.contact',compact('contact','url_canonical','categoriesLimit'));
    }
    public function infomation(){
        $contact=$this->contact->where('id',1)->get();
        return view('admin.information.index',compact('contact'));
    }
    public function update(Request $request,$id){
        $dataContactCreate=[
            'contact'=>$request->contact,
            'map'=>$request->map,
            'fanpage'=>$request->fanpage,
        ];
        $dataUploadFeatureImage=$this->storageTraitUpload($request,'image','contact');
        if(!empty($dataUploadFeatureImage)){
            $dataContactCreate['image']=$dataUploadFeatureImage['file_path'];
        }
        $this->contact->find($id)->update($dataContactCreate);
        $contact=$this->contact->find($id);
        return redirect()->route('infomation');
    }
}
