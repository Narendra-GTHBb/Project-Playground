<!DOCTYPE html>
<html lang="en" class="bg-[#0F0F0F]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Noir Atelier')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        noir: '#0F0F0F',
                        gold: '#D4AF37',
                        mist: '#A3A3A3'
                    },
                    boxShadow: {
                        soft: '0 12px 38px rgba(0, 0, 0, 0.28)'
                    }
                }
            }
        };
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-noir text-white antialiased selection:bg-gold/25 selection:text-gold min-h-screen">
    <div class="relative isolate min-h-screen overflow-x-hidden">
        <div class="pointer-events-none absolute inset-0 -z-10 bg-[radial-gradient(circle_at_20%_0%,rgba(212,175,55,0.12),transparent_32%),radial-gradient(circle_at_90%_20%,rgba(255,255,255,0.05),transparent_30%)]"></div>

        <x-navbar />

        <main class="pb-16">
            @yield('content')
        </main>

        <x-footer />
    </div>

    @stack('scripts')
</body>
</html>
