<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('build/assets/app-CkXgqv0L.css') }}">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-md bg-white p-6 rounded shadow">
            <h1 class="text-xl font-semibold mb-4">Sign in</h1>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 text-red-800 rounded border border-red-200">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', 'admin@example.com') }}" class="w-full border rounded p-2" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="block text-sm text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" value="password" class="w-full border rounded p-2" required>
                </div>
                <label class="inline-flex items-center space-x-2 mb-4">
                    <input type="checkbox" name="remember" class="rounded">
                    <span class="text-sm text-gray-700">Remember me</span>
                </label>
                <div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded">Sign in</button>
                </div>
            </form>

            <p class="text-xs text-gray-500 mt-4">
                Tip: Seeded admin user is admin@example.com / password
            </p>
        </div>
    </div>
</body>
</html>
