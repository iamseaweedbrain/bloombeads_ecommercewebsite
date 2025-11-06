<!DOCTYPE html>
    <html lang="en" class="scroll-smooth">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="csrf-token" content="{{ csrf_token() }}">

            <title>{{ $title ?? 'Bloombeads by Jinx' }}</title>

            {{-- Tailwind + Fonts --}}
            <script src="https://cdn.tailwindcss.com"></script>
            <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400..700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

            {{-- Icons --}}
            <script src="https://unpkg.com/lucide@latest"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js" crossorigin="anonymous"></script>


            {{-- Vite / asset files --}}
            @vite(['resources/css/app.css', 'resources/js/app.js'])
            
            <script>
                tailwind.config = {
                    theme: {
                        extend: {
                            colors: {
                                sakura: '#FF6B81',
                                sky: '#48DBFB',
                                cta: '#FFB347',
                                dark: '#333333',
                                neutral: '#F7F7F7',
                            },
                            fontFamily: {
                                fredoka: ['Fredoka', 'sans-serif'],
                                poppins: ['Poppins', 'sans-serif'],
                            },
                        },
                    },
                };
            </script>
        </head>

    <body class="bg-neutral min-h-screen">
        {{ $slot }}

        <div id="toast-container" class="fixed bottom-5 right-5 z-[100] space-y-2 pointer-events-none">
            </div>

        <script src="{{ asset('js/toast.js') }}"></script>

        <script>
            window.addEventListener('DOMContentLoaded', () => lucide.createIcons());
        </script>
    </body>
</html>