@extends('layouts.master')

@section('title', $blog->title)

@section('content')
    <div class="row">
        <section class="col-12 col-lg-9">
            <section class="col-12 mb-4">
                <h4 class="pt-4"><i class="fa fa-rss-square"></i> {{ $blog->title }}</h4>
            </section>
                <section class="col-12 mb-5">
                    <div class="row">
                        @if(session('error'))
                            <section class="col-12 mb-5">
                                <div class="card bg-danger text-light shadow-item">
                                    <div class="card-body">
                                        {{ session('error') }}
                                    </div>
                                </div>
                            </section>
                        @endif
                        @if(session('success'))
                            <section class="col-12 mb-5">
                                <div class="card bg-success text-light shadow-item">
                                    <div class="card-body">
                                        {{ session('success') }}
                                    </div>
                                </div>
                            </section>
                        @endif
                        <section class="col-12 col-lg-2">
                            <div class="row">
                                <article class="col text-center">
                                    <span class="my-auto">
                                        <span class="date-text my-auto">{{ date('d', strtotime($blog->post_date)) }}<span class="w-100">&nbsp;</span><small class="month-text my-auto">{{ date('M', strtotime($blog->post_date)) }}</small><hr class="w-75 my-auto"/></span>
                                        <span class="time-text my-auto">{{ date('H:i', strtotime($blog->post_date)) }}</span>
                                    </span>
                                </article>
                            </div>
                        </section>
                        <section class="col-12 col-lg-10">
                            <div class="row">
                                <article class="col-12">
                                    <div class="card shadow-item">
                                        <div class="card-header">
                                            <p class="card-text float-left">
                                                <img class="img-responsive rounded" src="{{ Avatar::create($user->name)->setShape('square')->toBase64() }}" width="40" height="40"/>
                                                <span class="ml-2">{{ $user->name }}</span>
                                            </p>
                                        </div>
                                        @isset($blog->image_header)
                                            <img class="card-img-top" src="https://via.placeholder.com/1280x320.png?text=Blog+Title"
                                                 alt="Card image cap">
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                {{ $blog->title }}<br/>
                                            </h5>
                                            <p class="card-text text-truncate">{!! $blog->content !!}</p>
                                            <hr class="w-100"/>
                                            <span class="float-left py-1"><small><i></i></small></span>
                                            <h5><i class="fa fa-comments"></i> Comments</h5>
                                            <section class="row mb-3">
                                                @foreach($allComments as $comment)
                                                    <div class="col-12 mt-3 mb-2">
                                                        <div class="media">
                                                            <img class="mr-3" src="{{ Avatar::create(\App\User::where('id', $comment->user_id)->first()->name)->setShape('square')->toBase64() }}" alt="Generic placeholder image">
                                                            <div class="media-body">
                                                                <h5 class="mt-0">
                                                                    {{ \App\User::getUsername($comment->user_id) }}<br/>
                                                                    <small style="font-size: 12px">{{ date('F d, Y', strtotime($comment->created_at)).' | '.date('H:i', strtotime($comment->created_at)) }}</small>
                                                                </h5>
                                                                {{ $comment->content }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                            </section>
                                            @if(Auth::check())
                                                <section class="row">
                                                    <div class="col">
                                                        <h5 class="ml-2"><i class="fa fa-comment"></i> Comment to the Blog</h5>
                                                        <form action="{{ route('blog.comment') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="slug"  value="{{ \Illuminate\Support\Str::slug($blog->title, '-') }}" />
                                                            <div class="form-group">
                                                                <label>Comment down below:</label>
                                                                <textarea name="comment" id="comment" class="form-control"></textarea>
                                                            </div>
                                                            <button class="btn btn-primary btn-sm float-right"><i class="fa fa-comment-alt mr-1"></i> Comment</button>
                                                        </form>
                                                    </div>
                                                </section>
                                            @endif
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </section>
                    </div>
                </section>
        </section>
        <aside class="col-12 col-lg-3 mt-3">
            @if(\Illuminate\Support\Facades\Auth::check())
                <div class="center-block text-center">
                    <img src="{{Avatar::create(Auth::user()->name)->setShape('square')->setFontSize(60)->setDimension(150,150)->toBase64()}}" class="img-responsive rounded shadow-item mb-3" />
                    <h4>{{ Auth::user()->name }}</h4>
                    <span>{{ $userBlogs }} posts, {{ $userComments }} comments</span>
                    <br/>
                    <a class="btn btn-warning btn-sm" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                <hr/>
            @endif
            <h6 class="pt-4"><i class="fa fa-comments"></i> Top Commented Blogposts</h6>
            <br/>
            <ul class="nav flex-column">
                @foreach($blogsOnTop as $blog)
                    <li class="nav-item bg-white p-2 mb-2 rounded border-right border-primary shadow-item-sidenav">
                        <a href="{{ route('blog.view', \Illuminate\Support\Str::slug($blog->title, '-')) }}" class="nav-link text-dark">
                            <div class="d-inline text-right">
                                <span class="float-left">{{ $blog->title }}</span>
                                <p class="float-right blog-user-text-side">
                                    by {{ \App\User::getUsername($blog->user_id) }}<br/>
                                    {{ $allComments->where('blogpost_id', $blog->id)->count() }} comments
                                </p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </aside>
    </div>
@endsection
