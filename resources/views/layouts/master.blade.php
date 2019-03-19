<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') | BB-Blogger</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
          crossorigin="anonymous">
    <style>
        body {
            background-image: linear-gradient(to bottom right, #1a2a6c, #b21f1f, #fdbb2d);
            background-repeat: no-repeat;
        }
        .shadow-item{
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .shadow-item-sidenav{
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.19);
        }
        .brand-text {
            font-size: 22px
        }
        .nav-text {
            font-size: 16px;
            color: #110110
        }
        .min-height{
            min-height: 100vh
        }
        .date-text{
            font-size:24px;
            font-weight: bold;
        }
        .time-text{
            font-size:12px
        }
        .month-text{
            font-size: 16px;
        }
        .blog-user-text{
            font-size: 12px;
        }
        .blog-user-text-side{
            font-size: 10px;
        }
        .btn-circle.btn-xl {
             width: 70px;
             height: 70px;
             padding: 10px 16px;
             border-radius: 35px;
             font-size: 24px;
             line-height: 1.33;
         }

        .btn-circle {
            width: 30px;
            height: 30px;
            padding: 6px 0px;
            border-radius: 15px;
            text-align: center;
            font-size: 12px;
            line-height: 1.42857;
        }

    </style>
    <script src="https://cdn.ckeditor.com/4.11.3/standard/ckeditor.js"></script>
</head>

<body>
<div class="container-fluid">
    <nav class="navbar navbar-light bg-white">
        <a class="navbar-brand brand-text" href="{{ url('/') }}">
            <img src="https://ui-avatars.com/api/?background=ffbd07&color=fefefe&name=BB+Blogger" width="40" height="40"
                 class="d-inline-block align-top rounded" alt="">
            BB-Blogger
        </a>
        <ul class="navbar-nav mr-auto">
        </ul>
        @if(\Illuminate\Support\Facades\Auth::check())
            <span class="nav-text text-dark">Welcome, {{ Auth::user()->name }} <img src="{{Avatar::create(Auth::user()->name)->setShape('circle')->toBase64()}}" width="40" height="40"/></span>
        @else
            <a href="{{ route('login') }}" class="nav-text text-dark"><i class="fa fa-sign-in-alt"></i> Login</a>
        @endif
    </nav>
    <div class="container-fluid bg-light" style="min-height: 80vh">
        @section('content')
        @show
    </div>
    <footer class="page-footer font-small bg-secondary text-light pt-4">
        <div class="container-fluid text-center text-md-left">
            <div class="row">
                <div class="col-md-6 mt-md-0 mt-3">
                    <h5 class="text-uppercase">BB-Blogger</h5>
                    <p>Blogging site made with L. (Laravel)</p>
                </div>
            </div>
        </div>
        <div class="footer-copyright bg-dark text-center py-1">
            Copyright © 2019
        </div>
    </footer>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>
