<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EmployeeHub | Log in</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800">
    <main class="min-h-screen p-4 sm:p-8 lg:p-12">
        <section class="mx-auto grid min-h-[calc(100vh-2rem)] max-w-6xl overflow-hidden rounded-2xl bg-white shadow-2xl lg:grid-cols-2">
            <div class="relative hidden min-h-full overflow-hidden bg-indigo-700 lg:block">
                <img src="{{ asset('images/OIP (1).webp') }}" alt="Employee management illustration" class="h-full w-full object-cover object-center opacity-90">
                <div class="absolute inset-0 bg-gradient-to-t from-indigo-950/75 via-indigo-700/20 to-transparent"></div>
                <div class="absolute bottom-0 p-12 text-white">
                    <p class="text-sm font-semibold tracking-[0.2em]">EMPLOYEEHUB</p>
                    <h1 class="mt-3 text-4xl font-bold leading-tight">One place for your people and departments.</h1>
                    <p class="mt-4 max-w-md text-indigo-100">Keep employee details organized, searchable, and easy to manage.</p>
                </div>
            </div>

            <div class="flex items-center justify-center px-6 py-12 sm:px-12">
                <div class="w-full max-w-md">
                    <a href="/" class="text-2xl font-bold text-indigo-700">EmployeeHub</a>
                    <h2 class="mt-10 text-3xl font-bold tracking-tight">Welcome back</h2>
                    <p class="mt-2 text-sm text-slate-600">Log in to manage your employees and departments.</p>

                    @if (session('status'))
                        <div class="mt-5 rounded-md bg-green-50 p-3 text-sm text-green-700">{{ session('status') }}</div>
                    @endif

                    <form class="mt-8 space-y-5" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700">Email address</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <div class="flex items-center justify-between"><label for="password" class="block text-sm font-medium text-slate-700">Password</label><a href="{{ route('password.request') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Forgot password?</a></div>
                            <input id="password" name="password" type="password" required autocomplete="current-password" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <label class="flex items-center gap-2 text-sm text-slate-600"><input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"> Remember me</label>
                        <button type="submit" class="w-full rounded-md bg-indigo-600 px-4 py-3 font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Log in</button>
                    </form>

                    <p class="mt-8 text-center text-sm text-slate-600">Don’t have an account? <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Sign up</a></p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
