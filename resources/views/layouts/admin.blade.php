<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ninetasy Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        /* Touch scroll halus untuk tablet */
        .overflow-x-auto {
            -webkit-overflow-scrolling: touch;
        }
    </style>
</head>
<body class="min-h-screen w-full bg-[#EFEFEF] flex gap-4 md:gap-6 lg:gap-8 text-gray-800 antialiased">
    {{-- Sidebar Admin --}}
    @include('layouts.partials.admin.sidebar')

    {{-- Main Content Area --}}
    <main class="flex-1 min-w-0 pr-4 md:pr-6 lg:pr-8 py-4 md:py-6 lg:py-8">
        @yield('content')
    </main>
</body>
</html>
