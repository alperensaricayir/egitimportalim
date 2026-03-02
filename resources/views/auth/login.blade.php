<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script>
        tailwind = { config: { darkMode: 'class' } };
    </script>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('build/assets/app-CkXgqv0L.css') }}">
</head>
<body class="bg-gray-100 text-gray-900 dark:bg-gray-950 dark:text-gray-100">
    <div class="min-h-screen flex items-center justify-center relative">
        <button id="login-theme-toggle" type="button" class="absolute top-4 right-4 inline-flex items-center gap-2 rounded-full border border-gray-200 bg-gray-100 px-3 py-1.5 text-sm font-medium text-gray-900 hover:bg-gray-200 hover:border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700">
            <span class="inline-flex h-4 w-4 items-center justify-center">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364 6.364-1.414-1.414M7.05 7.05 5.636 5.636m12.728 0-1.414 1.414M7.05 16.95 5.636 18.364" />
                    <circle cx="12" cy="12" r="4" />
                </svg>
            </span>
            <span id="login-theme-toggle-label">Dark</span>
        </button>
        <div class="w-full max-w-md bg-white p-6 rounded shadow dark:bg-gray-900 dark:border dark:border-gray-700">
            <h1 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Sign in</h1>

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
                    <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', 'admin@example.com') }}" class="w-full border rounded p-2 border-gray-300 bg-white text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Password</label>
                    <input type="password" name="password" value="password" class="w-full border rounded p-2 border-gray-300 bg-white text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" required>
                </div>
                <label class="inline-flex items-center space-x-2 mb-4">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 dark:border-gray-700">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Remember me</span>
                </label>
                <div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded">Sign in</button>
                </div>
            </form>

            <p class="text-xs text-gray-500 dark:text-gray-400 mt-4">
                Tip: Seeded admin user is admin@example.com / password
            </p>
        </div>
    </div>
    <script>
        (function(){
            function applyTheme(theme) {
                var root = document.documentElement;
                var body = document.body;
                if (theme === 'dark') {
                    root.classList.add('dark');
                    body.classList.add('dark');
                    root.setAttribute('data-theme', 'dark');
                    localStorage.theme = 'dark';
                } else {
                    root.classList.remove('dark');
                    body.classList.remove('dark');
                    root.setAttribute('data-theme', 'light');
                    localStorage.theme = 'light';
                }
                var label = document.getElementById('login-theme-toggle-label');
                if (label) {
                    label.textContent = theme === 'dark' ? 'Light' : 'Dark';
                }
            }
            applyTheme(document.documentElement.classList.contains('dark') ? 'dark' : 'light');
            var btn = document.getElementById('login-theme-toggle');
            if (btn) {
                btn.addEventListener('click', function(){
                    var next = document.documentElement.classList.contains('dark') ? 'light' : 'dark';
                    applyTheme(next);
                });
            }
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (e) {
                if (!('theme' in localStorage)) {
                    applyTheme(e.matches ? 'dark' : 'light');
                }
            });
        })();
    </script>
</body>
</html>
