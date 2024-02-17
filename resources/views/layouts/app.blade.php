<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To-Do List App</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <style type="text/tailwindcss">
        label {
            @apply block uppercase text-slate-700 mb-2
        }

        input,
        textarea {
            @apply shadow-sm appearance-none border w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none
        }

        .btn {
            @apply rounded-md px-2 py-1 text-center font-medium shadow-sm ring-1
        }

        .btn-success {
            @apply text-blue-500 ring-blue-700 hover:bg-blue-50
        }

        .btn-toggle {
            @apply text-green-500 ring-green-700 hover:bg-green-50
        }

        .btn-edit {
            @apply text-orange-500 ring-orange-700 hover:bg-orange-50
        }

        .btn-delete {
            @apply text-red-500 ring-red-700 hover:bg-red-50
        }

        .link {
            @apply font-medium text-gray-700 underline decoration-pink-500
        }

        .error {
            @apply text-red-500 text-sm
        }

        .success {
            @apply text-green-500 text-sm
        }
    </style>

    @yield('styles')
</head>
<body class="container mx-auto mt-10 mb-10 max-w-lg">
    <h1 class="text-2xl mb-4 text-blue-700">
        @yield('title')
    </h1>

    <div>
        <div class="mb-4">
            @if (session()->has('success'))
                <div class="success">
                    {{ session('success') }}
                </div>
            @elseif (session()->has('error'))
                <div class="error">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        @yield('content')
    </div>
</body>
</html>
