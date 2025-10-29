<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloombeads - Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400..700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite('resources/css/app.css')
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sakura: 'var(--color-sakura)',
                        sky: 'var(--color-sky)',
                        cta: 'var(--color-cta)',
                        dark: 'var(--color-dark)',
                        neutral: 'var(--color-neutral)',
                    },
                    fontFamily: {
                        fredoka: ['Fredoka', 'sans-serif'],
                        poppins: ['Poppins', 'sans-serif'],
                    },
                },
            },
        }
    </script>
</head>
<body class="bg-neutral min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-8 card-radius shadow-soft w-full max-w-md">
        <h1 class="text-3xl font-fredoka font-bold text-sakura text-center mb-6">Bloombeads Admin</h1>
        <p class="font-poppins text-center text-dark/70 mb-6">Please sign in to manage your store.</p>

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-input" placeholder="admin" required>
                
                @error('username')
                <p class="text-sakura text-sm font-poppins mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
                @error('password')
                <p class="text-sakura text-sm font-poppins mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-3 px-5 font-fredoka font-bold card-radius text-white bg-cta hover:bg-opacity-90 transition-default shadow-soft">
                    Sign In
                </button>
            </div>
        </form>
    </div>

</body>
</html>
