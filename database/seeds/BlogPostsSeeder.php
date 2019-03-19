<?php

use Illuminate\Database\Seeder;
use \App\BlogPost;
use \App\Comments;

class BlogPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post = new BlogPost();
        $post->title = 'My First Blog Post!';
        $post->content = 'NO CONTENT FOR NOW';
        $post->post_date = \Carbon\Carbon::now();
        $post->user_id = 1;
        $post->save();

        $comment = new Comments();
        $comment->user_id = 1;
        $comment->blogpost_id = $post->id;
        $comment->content = 'My First Comment on my own post!';
        $comment->save();
    }
}
