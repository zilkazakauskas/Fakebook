<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        return view('home', ['posts' => Post::all(), 'user' => Auth::user()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:1|max:1000',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $save = new Post;
        if ($request->hasfile('image')) {
            $name = $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('public/images/posts', $name);
            $save->image = $name;
            // $save->image = $path;
        }
        $save->user_id = $request->user()->id;
        $save->content = $request->content;
        $save->save();

        return redirect('/');
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
    public function edit(Post $post)
    {
        return view('editPost', ['post' => $post]);
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
        $request->validate([
            'content' => 'required|string|min:1|max:1000'
        ]);

        Post::where('id', $id)->update(['content' => $request['content']]);

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::where('id', $id)->delete();
        Like::where('post_id', $id)->where('user_id', Auth::id())->delete();
        Comment::where('post_id', $id)->delete();

        return redirect('/');
    }

    public function search(Request $request)
    {
        $request->validate([
            'keyword' => 'bail|required|max:255',
            'searchBy' => 'required',
        ]);

        // name
        if ($request->searchBy === '1') {
            $users = User::where('name', 'LIKE', "%{$request->keyword}%")->get();
            $original = new Collection();
            $posts = new Collection();
            foreach ($users as $user) {
                $posts = $original->merge(Post::where('user_id', $user->id)->get());
                $original = $posts;
            }
            // dd($users, $posts);
            return view('home', ['posts' => $posts]);
        }

        // fragment
        if ($request->searchBy === '2') {
            return view('home', ['posts' => Post::where('content', 'LIKE', "%{$request->keyword}%")->get()]);
        }
    }
}
