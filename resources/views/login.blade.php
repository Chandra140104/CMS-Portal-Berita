<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Info BNN Kota Kediri</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ url('/images/favicon2.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        /* Gen Z Dark Blue Theme */
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(59, 130, 246, 0.3);
            box-shadow: 0 0 30px rgba(59, 130, 246, 0.2);
            border-radius: 20px;
            transition: all 0.4s ease;
        }

        .login-card:hover {
            box-shadow: 0 0 40px rgba(59, 130, 246, 0.4);
            transform: translateY(-5px);
        }

        /* .input-glow {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(59, 130, 246, 0.5);
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.1);
            transition: all 0.3s ease;
        }

        .input-glow:focus {
            background: rgba(30, 41, 59, 0.8);
            border-color: #3b82f6;
            box-shadow: 0 0 25px rgba(59, 130, 246, 0.4);
            outline: none;
        } */

        .btn-neon {
            background: linear-gradient(90deg, #3b82f6, #06b6d4);
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
            transition: all 0.4s ease;
        }

        .btn-neon:hover {
            background: linear-gradient(90deg, #2563eb, #0891b2);
            box-shadow: 0 0 30px rgba(59, 130, 246, 0.8);
            transform: scale(1.05);
        }

        .text-glow {
            text-shadow: 0 0 10px rgba(59, 130, 246, 0.6);
        }

        .link-neon:hover {
            color: #06b6d4 !important;
            text-shadow: 0 0 10px rgba(6, 182, 212, 0.6);
        }
    </style>

    @vite('resources/css/app.css')
</head>

<body>

    <div class="mx-auto w-full max-w-sm p-6 login-card">
        <form class="space-y-6" action="{{ route('proses-login') }}" method="POST">
            @csrf
            <h5 class="text-3xl font-bold text-center text-white text-glow">LOGIN</h5>
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-cyan-300" style="color:white;">Email</label>
                <input type="email" name="email" id="email"
                    class="input-glow text-black placeholder-gray-400 rounded-lg block w-full p-3"
                    placeholder="name@gmail.com" required />
            </div>
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-cyan-300" style="color:white;">Password</label>
                <input type="password" name="password" id="password" placeholder="••••••••"
                    class="input-glow text-black placeholder-gray-400 rounded-lg block w-full p-3"
                    required />
            </div>
            <button type="submit"
                class="w-full btn-neon text-white font-bold rounded-lg text-lg px-5 py-3 text-center">
                Login
            </button>
            <div class="flex justify-between text-sm font-medium text-gray-300">
                <a href="{{ route('welcome') }}" class="link-neon hover:underline">Kembali</a>
                <div>
                    Buat akun? <a href="{{ route('registrasi') }}"
                        class="text-cyan-400 link-neon hover:underline">Klik di sini</a>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
</body>

</html>