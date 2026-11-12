<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ninetasy</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen w-full bg-[#EFEFEF] flex">
    <div class="flex-1 bg-[#E6E2D6] flex items-center justify-center">
        <div class="flex flex-col gap-2">
            <h3 class="text-3xl font-medium">Selamat Datang di,</h3>
            <h1 class="text-7xl font-bold mb-2">Ninetasy</h1>
            <p class="text-lg">Kelola transaksi anda dengan cepat dan mudah</p>
        </div>
    </div>
    <div class="flex-1">
        @yield('auth')
    </div>
</body>
</html>