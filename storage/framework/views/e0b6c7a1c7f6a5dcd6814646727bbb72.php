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
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/app-CkXgqv0L.css')); ?>">
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

            <?php if($errors->any()): ?>
                <div class="mb-4 p-3 bg-red-50 text-red-800 rounded border border-red-200">
                    <ul class="list-disc pl-5 text-sm">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login.post')); ?>">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email', 'admin@example.com')); ?>" class="w-full border rounded p-2 border-gray-300 bg-white text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" required autofocus>
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
            var btn = document.getElementById('login-theme-toggle');
            var label = document.getElementById('login-theme-toggle-label');
            function sync() {
                label.textContent = document.documentElement.classList.contains('dark') ? 'Light' : 'Dark';
            }
            if (btn && label) {
                sync();
                btn.addEventListener('click', function(){
                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.theme = 'light';
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.theme = 'dark';
                    }
                    sync();
                });
            }
        })();
    </script>
</body>
</html>
<?php /**PATH C:\Users\Guney\Documents\trae_projects\egitim-portali\resources\views/auth/login.blade.php ENDPATH**/ ?>