<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = \App\Post::where('active_status', 1)->where('user_id', Auth::user()->id);
        $post = $post->orderBy('updated_at', 'desc')->get();
        $count =count($post);
        return view('post',compact('post','count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('add_post');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post= new \App\Post;
        $post->title=$request->get('title');
        $image = $request->file('image');
        $input['imagename'] = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/img');
        $image->move($destinationPath, $input['imagename']);
        $post->image = $input['imagename'];
        $post->content=$request->get('content');
        $post->active_status=1;
        if(Auth::user()->type=='A') {
            $post->approve_status=1;
        } else {
            $post->approve_status=0;
        }
        $post->user_id=Auth::user()->id;
        $post->save();
        return redirect('post')->with('success', 'Post added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = \App\Post::find($id);
        return view('edit_post',compact('post','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post= \App\Post::find($id);
        $post->title=$request->get('title');
        if($request->file('image')!='') {
            $image = $request->file('image');
            $input['imagename'] = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/img');
            $image->move($destinationPath, $input['imagename']);
            $post->image = $input['imagename'];
        }
        $post->content=$request->get('content');
        $post->active_status=1;
        if((Auth::user()->type=='A')||(Auth::user()->type=='M')) {
            $post->approve_status=1;
        } else {
            $post->approve_status=0;
        }
        $post->user_id=Auth::user()->id;
        $post->save();
        return redirect('post')->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post= \App\Post::find($id);
        $post->active_status=0;
        $post->save();
        return redirect('post')->with('error', 'Post deleted successfully');
    }
    public function listPost()
    {
        $post = \DB::table("posts")
                ->select("posts.id", "posts.title", "posts.content","users.name")
                ->leftjoin('users', function ($join) {
                    $join->on('posts.user_id', '=', 'users.id');
                })
                ->where("posts.active_status", 1)
                ->where("posts.approve_status", 1)
                ->orderBy("posts.updated_at","desc")
                ->get();
        $count =count($post);
        return view('list_post',compact('post','count'));
    }
    public function viewPost()
    {
        $post = \App\Post::where('active_status', 1)->where('id', Route::input('id'))->first();
        $comment = \DB::table("comments")
                ->select("comments.id", "comments.user_id", "comments.post_id", "comments.comment","users.name")
                ->leftjoin('users', function ($join) {
                    $join->on('comments.user_id', '=', 'users.id');
                })
                ->where("comments.post_id", Route::input('id'))
                ->orderBy("comments.updated_at","desc")
                ->get();
        return view('view_post',compact('post','comment'));
    }
    public function updateStatus(Request $request)
    {
        $post= \App\Post::updateOrCreate(['id'=>$request->get('id')]);
        $post->approve_status=$request->get('status');
        $post->save();
        if($request->get('status')==1) {
            return redirect('otherPost')->with('success', 'Post approved successfully');

        } else {
            return redirect('otherPost')->with('error', 'Post disapproved successfully');
        }
    }
    public function otherPost()
    {
        $post = \App\Post::where('active_status', 1)->where('user_id','!=', Auth::user()->id);
        $post = $post->orderBy('updated_at', 'desc')->get();
        $count =count($post);
        return view('other_post',compact('post','count'));
    }
    public function addComment(Request $request)
    {
        $post= new \App\Comment;
        $post->post_id=$request->get('post_id');
        $post->user_id=$request->get('user_id');
        $post->comment=$request->get('comment');
        $post->save();
        return redirect('viewPost/'.$request->get('post_id'))->with('success', 'Comment added successfully');
    }

}
