@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <div class="row">
        <section class="col-12 col-lg-9">
            @if(Auth::check())
                <section class="col-12 mb-3 mt-5">
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
                        </section>
                        <section class="col-12 col-lg-10">
                            <div class="row">
                                <article class="col-12">
                                    <div class="card shadow-item">
                                        <div class="card-body">
                                            <div id="accordion">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">

                                                    <h5 class="mb-4 text-dark"><i class="fa fa-plus fa-sm"></i> New Blog Post</h5>
                                                </button>

                                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                    <form action="{{ route('blogpost.submit') }}" method="post">
                                                        @csrf
                                                        <div class="form-group-sm mb-3">
                                                            <input class="form-control" name="title" id="title" placeholder="Title"/>
                                                        </div>
                                                        <div class="form-group-sm">
                                                            <textarea class="form-control" name="content" id="content"></textarea>
                                                        </div>
                                                        <script>
                                                            CKEDITOR.replace( 'content' );
                                                        </script>
                                                        <button class="btn btn-primary float-right">Post it!</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </section>
                    </div>
                </section>
            @endif
            <section class="col-12 mb-4">
                <h4 class="pt-4"><i class="fa fa-rss-square"></i> BlogFeed</h4>
            </section>
            @foreach($blogposts as $blogpost)
                <section class="col-12 mb-5">
                    <div class="row">
                        <section class="col-12 col-lg-2">
                            <div class="row">
                                <article class="col text-center">
                                    <span class="my-auto">
                                        <span class="date-text my-auto">{{ date('d', strtotime($blogpost->post_date)) }}<span class="w-100">&nbsp;</span><small class="month-text my-auto">{{ date('M', strtotime($blogpost->post_date)) }}</small><hr class="w-75 my-auto"/></span>
                                        <span class="time-text my-auto">{{ date('H:i', strtotime($blogpost->post_date)) }}</span>
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
                                                <img class="img-responsive rounded" src="{{ Avatar::create($users->where('id', $blogpost->user_id)->first()->name)->setShape('square')->toBase64() }}" width="40" height="40"/>
                                                <span class="ml-2">{{ $users->where('id', $blogpost->user_id)->first()->name }}</span>
                                            </p>
                                        </div>
                                        @isset($blogpost->image_header)
                                            <img class="card-img-top" src="https://via.placeholder.com/1280x320.png?text=Blog+Title"
                                                 alt="Card image cap">
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                {{ $blogpost->title }}<br/>
                                            </h5>
                                            <p class="card-text text-truncate">{!! $blogpost->content !!}</p>
                                            <hr class="w-100"/>
                                            <span class="float-left py-1"><small><i>{{ $comments->where('blogpost_id', $blogpost->id)->count() > 1 ? $comments->where('blogpost_id', $blogpost->id)->count().' comments' : $comments->where('blogpost_id', $blogpost->id)->count() == 1 ? $comments->where('blogpost_id', $blogpost->id)->count().' comment' : 'No comments ' }}</i></small></span>
                                            <a href="{{ route('blog.view', \Illuminate\Support\Str::slug($blogpost->title, '-')) }}" class="btn btn-primary-outline float-right">Read More >></a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </section>
                    </div>
                </section>
            @endforeach

                <section class="col-12">
                    {{ $blogposts->links() }}
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
