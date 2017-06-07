<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="{{ asset('css/app_v4.css') }}" rel="stylesheet">
    </head>
    <body>


        <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="/">Diary</a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                </ul>

                <ul class="navbar-nav text-right">
                    @if (Auth::check())
                        <li class="nav-item">
                            <a href="/home" class="nav-link btn btn-outline-secondary">Go to App</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="/login" class="nav-link">
                                Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/register" class="nav-link">
                                Register
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>


        <div class="container">


            <div class="jumbotron">
                <h1 class="display-3">Diary</h1>
                <p class="lead">Encrypted, selfhosted, opensource, free</p>
                <hr class="my-4">
                <p>A simple to use, hosted diary. Everything is encrypted and can only be read by you.</p>
                <p class="lead">
                    <a class="btn btn-primary" href="#" role="button">Learn more</a>
                </p>
            </div>


            <hr>

            <div class="card text-center">

                <div class="card-block">
                    <h4 class="card-title">Special title treatment</h4>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-block">
                            <h3 class="card-title">Special title treatment</h3>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-block">
                            <h3 class="card-title">Special title treatment</h3>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </body>
</html>
