<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BlogPost extends Model
{
    public static function getBlogsForTopComments(){
        $allBlogs = \App\BlogPost::orderBy('post_date', 'desc')->get();
        $topCommentedBlogs = \Illuminate\Support\Facades\DB::table('comments')
            ->groupBy('blogpost_id')
            ->orderBy(\DB::raw('count(blogpost_id)'), 'DESC')
            ->take(3)
            ->pluck('blogpost_id');

        $blogsOnTop = $allBlogs->whereIn('id', $topCommentedBlogs->toArray());
        $allComments = \App\Comments::whereIn('blogpost_id', $allBlogs->pluck('id')->toArray())->orderBy('created_at', 'desc')->get();

        if(Auth::check()){
            $userBlogs = $allBlogs->where('user_id', Auth::user()->id)->count();
            $userComments = $allComments->where('user_id', Auth::user()->id)->count();
            return [
                'blogs' => $blogsOnTop,
                'comments' => $allComments,
                'userBlogs' => $userBlogs,
                'userComments' => $userComments
            ];
        }
        return [
            'blogs' => $blogsOnTop,
            'comments' => $allComments,
        ];
    }
}
