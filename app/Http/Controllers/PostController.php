<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function createnewpost(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'category' => 'required',
            'status' => 'required',
            'content' => 'required',
        ]);

        $model = new Post;
        $model->title = $request->title;
        $model->author = $request->author;
        $model->category = $request->category;
        $model->status = $request->status;
        $model->content = $request->content;
        $model->save();
        return response()->json(['status' => 200, ' msg' => 'Data saved successful']);

    }

    public function getallpost()
    {
        $data = Post::orderBy('id', 'desc')->get();
        return response()->json(['allpost' => $data]);
    }

    public function deletepost(Request $request)
    {
        Post::where(['id' => $request->deleteid])->delete();
        return response()->json(['status' => 200, 'msg' => 'Post deleted successfully']);
    }

    public function postbyid($id)
    {
        $data = Post::find($id);
        return $data;
    }

    public function editpost(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'category' => 'required',
            'status' => 'required',
            'content' => 'required',
        ]);

        $model = Post::find($request->id);
        $model->title = $request->title;
        $model->author = $request->author;
        $model->category = $request->category;
        $model->status = $request->status;
        $model->content = $request->content;
        $model->update();
        return response()->json(['status' => 200, ' msg' => 'Data updated successful']);

    }
}
