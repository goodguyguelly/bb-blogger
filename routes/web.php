<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $allBlogs = \App\BlogPost::orderBy('post_date', 'desc')->get();
    $allComments = \App\Comments::whereIn('blogpost_id', $allBlogs->pluck('id')->toArray())->get();

    $blogposts = App\BlogPost::orderBy('post_date', 'desc')->simplePaginate(5);
    $users = \App\User::whereIn('id', $blogposts->pluck('user_id')->toArray())->get();
    $comments = \App\Comments::whereIn('blogpost_id', $blogposts->pluck('id')->toArray())->get();

    $blogs = \App\BlogPost::getBlogsForTopComments();
    $blogsOnTop = $blogs['blogs'];
    $allComments = $blogs['comments'];
    if(Auth::check()){
        $userBlogs = $blogs['userBlogs'];
        $userComments = $blogs['userComments'];
    }

    return view('home', compact('blogposts', 'users', 'comments', 'blogsOnTop', 'allComments', 'userBlogs', 'userComments'));
})->name('homepage');

Route::post('/blogpost', function (\Illuminate\Http\Request $request) {
    $validatedData = $request->validate([
        'title' => 'required|unique:blog_posts|max:255',
        'content' => 'required',
    ]);

    if(Auth::check()){
        $post = new \App\BlogPost();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->post_date = \Carbon\Carbon::now();
        $post->user_id = Auth::user()->id;
        if($post->save()){
            return redirect(route('homepage'))->with(['success' => 'Blogpost posted successfully.']);
        }
        else{
            return redirect(route('homepage'))->with(['error' => 'Something\'s wrong, please try again later.']);
        }
    }
    else{
        return redirect(route('homepage'))->with(['error' => 'You must be logged in to continue']);
    }
})->name('blogpost.submit');

Route::post('/blogpost/comment', function (\Illuminate\Http\Request $request) {
    $validatedData = $request->validate([
        'slug' => 'required',
        'comment' => 'required'
    ]);
    $slug = $request->input('slug');
    if(Auth::check()){
        foreach(\App\BlogPost::all() as $item){
            if(\Illuminate\Support\Str::slug($item->title, '-') == $slug){
                $blog = $item;
                $comments = \App\Comments::where('blogpost_id', $blog->id)->get();
                $user = \App\User::where('id', $blog->user_id)->first();
                break;
            }
        }

        $comment = new \App\Comments();
        $comment->user_id = Auth::user()->id;
        $comment->blogpost_id = $blog->id;
        $comment->content = $request->input('comment');
        if($comment->save()){
            return redirect(route('blog.view', $slug))->with(['success' => 'Comment saved successfully.']);
        }
        else{
            return redirect(route('blog.view', $slug))->with(['error' => 'Something\'s wrong, please try again later.']);
        }
    }
    else{
        return redirect(route('blog.view', $slug))->with(['error' => 'You must be logged in to continue']);
    }
})->name('blog.comment');

Route::get('/blog/view/{slug}', function ($slug){
    $blog = null;
    foreach(\App\BlogPost::all() as $item){
        if(\Illuminate\Support\Str::slug($item->title, '-') == $slug){
            $blog = $item;
            $comments = \App\Comments::where('blogpost_id', $blog->id)->get();
            $user = \App\User::where('id', $blog->user_id)->first();
            break;
        }
    }
    $blogs = \App\BlogPost::getBlogsForTopComments();
    $blogsOnTop = $blogs['blogs'];
    $allComments = $blogs['comments']->where('blogpost_id', $blog->id);
    $userBlogs = $blogs['userBlogs'];
    $userComments = $blogs['userComments'];
    return view('view', compact('blog','comments', 'user', 'blogsOnTop', 'allComments', 'userBlogs', 'userComments'));
})->name('blog.view');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
