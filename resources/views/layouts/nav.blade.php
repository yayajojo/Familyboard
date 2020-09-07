<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @yield('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>


<body class="h-full  bg-gray-300">
    <div id="app">
        <section class="px-16 py-4 bg-gray-500 ">
            <header class="container justify-between flex-col">
                <h1 class="text-left text-lg font-bold">
                    {{ config('app.name', 'Laravel') }}
                </h1>
                <div class="flex">
                    <div class="my-5 flex-1">
                        <form action="" method="post">
                            <button class="button-add" type="submit">Update {{ Auth::user()->name }}'s profile</button>
                        </form>
                    </div>
                    <div>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </header>
        </section>
        <section>
            <main class="px-16 py-4  h-screen">
                @yield('content')
            </main>
        </section>
        @yield('footer')
    </div>
</body>