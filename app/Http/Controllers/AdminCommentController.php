<?php

namespace App\Http\Controllers;

use App\Models\comment;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    private $comment;
    public function __construct( comment $comment )
    {
        $this->comment=$comment;
    }
    public function index(){
        $comment=$this->comment->all();
        return view('admin.comment.index',compact('comment'));
    }
    public function reply_comment(Request $request){
        $data=$request->all();
        $comment= new comment();
        $comment->comment=$data['comment'];
        $comment->comment_product_id=$data['comment_product_id'];
        $comment->comment_parent=$data['comment_id'];
        $comment->comment_status=0;
        $comment->comment_name='cương(admin)';
        $comment->save();
    }
}
