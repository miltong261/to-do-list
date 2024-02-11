<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To-Do List App</title>

    <style>
        .success-message {
            color: green;
        }
        .error-message {
            color: red;
        }
    </style>

    @yield('styles')
</head>
<body>
    <h1>
        @yield('title')
    </h1>

    <div>
        @if (session()->has('success'))
            <div class="success-message">{{ session('success') }}</div>
        @elseif (session()->has('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>
