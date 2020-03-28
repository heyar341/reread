<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!--TinyMCE用 -->
    <script src="https://cdn.tiny.cloud/1/bzhihshw66iu4sbm1p6ru690ztzi8ywr0lxhy0d4y9zb7mi0/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: '#tinytextarea',
            skin_url:'/myskin',
            plugins:'preview',
            language: 'ja',
            menubar: false,
            toolbar: 'formatselect | fontsizeselect',
        });
    </script>
</head>
<body>
<div id="app">
    @include('inc.navbar')

    <main class="py-4 pt-70">
        @yield('content')
    </main>
    @include('inc.footer')
</div>
</body>
</html>
