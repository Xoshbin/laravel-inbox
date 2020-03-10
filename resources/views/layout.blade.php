<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{asset(mix('app.css', 'vendor/inbox'))}}" rel="stylesheet">
    <link href="{{asset(mix('all.css', 'vendor/inbox'))}}" rel="stylesheet">
</head>

<body>
    <div class="email-app mb-4" id="app">
        @include('inbox::includes.nav')
        <router-view></router-view>
    </div>
</body>
<!-- Global Inbox Object -->
<script>
    window.Inbox = @json($inboxScriptVariables);
</script>
<script src="{{asset(mix('app.js', 'vendor/inbox'))}}"></script>
</html>