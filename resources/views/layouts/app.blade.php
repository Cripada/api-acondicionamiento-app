<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'CRIPADA')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-100 text-gray-900">

    <div class="container mx-auto py-6">
        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>
