<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Diary App</title>

        <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet">
    </head>
    <body class="antialiased bg-blue-lightest">

        <div class="h-screen flex items-center content-center justify-center">
            <div class="container max-w-sm rounded bg-white shadow p-4">

                <h1 class="mb-2">Diary</h1>
                <p class="mb-3">A selfhosted diary app with end to end encryption built in.</p>

                @if (Auth::check())
                    <a href="/home" class="inline-block no-underline bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded">
                        Go to Diary
                    </a>
                @else
                    <a href="/login" class="inline-block no-underline bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded">
                        Login
                    </a>
                    <a href="/register" class="inline-block no-underline border border-grey text-grey-dark font-bold py-2 px-4 rounded">
                        Register
                    </a>
                @endif

            </div>
        </div>

    </body>
</html>
