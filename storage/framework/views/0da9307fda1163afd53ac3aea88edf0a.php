<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel Education')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script>
            tailwind = window.tailwind || {};
            tailwind.config = Object.assign({}, tailwind.config || {}, { darkMode: 'class' });
        </script>
        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900 dark:bg-gray-950 dark:text-gray-100">
        <div class="min-h-screen">
            <!-- Navigation -->
            <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur supports-[backdrop-filter]:bg-white/70 border-b border-gray-200 shadow-sm dark:bg-gray-900/80 dark:border-gray-800">
                <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16 lg:h-18 gap-4">
                        <div class="flex items-center gap-4 lg:gap-6">
                            <div class="shrink-0 flex items-center">
                                <a href="<?php echo e(route('courses.index')); ?>" class="flex items-center gap-3">
                                    <img src="<?php echo e(asset('images/3sgrupENiyilogo.png')); ?>" alt="3S Grup" class="h-10 w-auto object-contain" />
                                </a>
                            </div>
                            <details class="relative hidden lg:block">
                                <summary class="list-none cursor-pointer inline-flex items-center gap-2 rounded-full border border-gray-200 bg-gray-50 px-3 py-1.5 text-sm font-medium text-gray-800 hover:bg-gray-100 hover:border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700">
                                    <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
                                    <span><?php echo e(__('ui.categories')); ?></span>
                                    <svg class="h-3.5 w-3.5 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
                                </summary>
                                <div class="absolute left-0 mt-2 w-64 rounded-xl border border-gray-200 bg-white shadow-lg ring-1 ring-black/5 dark:border-gray-700 dark:bg-gray-900">
                                    <div class="p-2 grid grid-cols-1 gap-1 text-sm">
                                        <a href="<?php echo e(route('courses.index')); ?>" class="flex items-center justify-between rounded-lg px-3 py-2 text-gray-800 hover:bg-gray-100 dark:text-gray-100 dark:hover:bg-gray-800">
                                            <span><?php echo e(__('ui.courses')); ?></span>
                                            <span class="text-xs text-gray-500">›</span>
                                        </a>
                                        <?php if(Route::has('products.index')): ?>
                                            <a href="<?php echo e(route('products.index')); ?>" class="flex items-center justify-between rounded-lg px-3 py-2 text-gray-800 hover:bg-gray-100 dark:text-gray-100 dark:hover:bg-gray-800">
                                                <span><?php echo e(__('ui.products')); ?></span>
                                                <span class="text-xs text-gray-500">›</span>
                                            </a>
                                        <?php endif; ?>
                                        <?php if(Route::has('jobs.index')): ?>
                                            <a href="<?php echo e(route('jobs.index')); ?>" class="flex items-center justify-between rounded-lg px-3 py-2 text-gray-800 hover:bg-gray-100 dark:text-gray-100 dark:hover:bg-gray-800">
                                                <span><?php echo e(__('ui.jobs')); ?></span>
                                                <span class="text-xs text-gray-500">›</span>
                                            </a>
                                        <?php endif; ?>
                                        <?php if(Route::has('public.profiles.index')): ?>
                                            <a href="<?php echo e(route('public.profiles.index')); ?>" class="flex items-center justify-between rounded-lg px-3 py-2 text-gray-800 hover:bg-gray-100 dark:text-gray-100 dark:hover:bg-gray-800">
                                                <span><?php echo e(__('ui.members') ?? 'Üyeler'); ?></span>
                                                <span class="text-xs text-gray-500">›</span>
                                            </a>
                                        <?php endif; ?>
                                        <?php if(Route::has('support.index')): ?>
                                            <a href="<?php echo e(route('support.index')); ?>" class="flex items-center justify-between rounded-lg px-3 py-2 text-gray-800 hover:bg-gray-100 dark:text-gray-100 dark:hover:bg-gray-800">
                                                <span><?php echo e(__('ui.support')); ?></span>
                                                <span class="text-xs text-gray-500">›</span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </details>
                        </div>

                        <div class="hidden md:flex flex-1 max-w-2xl">
                            <form action="<?php echo e(route('courses.index')); ?>" method="GET" class="w-full">
                                <div class="relative">
                                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="11" cy="11" r="6" />
                                            <line x1="16" y1="16" x2="21" y2="21" />
                                        </svg>
                                    </span>
                                    <input
                                        type="text"
                                        name="q"
                                        value="<?php echo e(request('q')); ?>"
                                        placeholder="<?php echo e(__('ui.search_placeholder')); ?>"
                                        class="block w-full rounded-full border border-gray-200 bg-gray-50 py-3 pl-10 pr-4 text-sm text-gray-900 placeholder:text-gray-400 shadow-inner focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder:text-gray-400 dark:focus:border-indigo-400 dark:focus:ring-indigo-400"
                                    >
                                </div>
                            </form>
                        </div>

                        <div class="flex items-center gap-3 lg:gap-4">
                            <div class="flex items-center gap-4 text-sm font-medium text-gray-700 md:hidden dark:text-gray-300">
                                <a href="<?php echo e(route('courses.index')); ?>" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <?php echo e(__('ui.courses')); ?>

                                </a>
                                <?php if(auth()->guard()->check()): ?>
                                    <?php if(in_array(auth()->user()->role, ['admin','editor'])): ?>
                                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-indigo-600">
                                            <?php echo e(__('ui.admin_panel')); ?>

                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <button
                                    id="theme-toggle-mobile"
                                    type="button"
                                    class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-gray-100 px-3 py-1.5 text-sm font-medium text-gray-900 hover:bg-gray-200 hover:border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700"
                                >
                                    <span class="inline-flex h-4 w-4 items-center justify-center">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364 6.364-1.414-1.414M7.05 7.05 5.636 5.636m12.728 0-1.414 1.414M7.05 16.95 5.636 18.364" />
                                            <circle cx="12" cy="12" r="4" />
                                        </svg>
                                    </span>
                                    <span id="theme-toggle-mobile-label">Dark</span>
                                </button>
                            </div>

                            <div class="hidden sm:flex items-center gap-2 lg:gap-3">
                                <div class="flex items-center gap-1">
                                    <form method="POST" action="<?php echo e(route('locale.update')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="locale" value="tr">
                                        <button type="submit" class="rounded-md px-2 py-1 text-sm <?php echo e(app()->getLocale()==='tr' ? 'ring-2 ring-indigo-500 font-semibold' : ''); ?> hover:bg-gray-100 dark:hover:bg-gray-800" aria-label="Türkçe">🇹🇷</button>
                                    </form>
                                    <form method="POST" action="<?php echo e(route('locale.update')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="locale" value="en">
                                        <button type="submit" class="rounded-md px-2 py-1 text-sm <?php echo e(app()->getLocale()==='en' ? 'ring-2 ring-indigo-500 font-semibold' : ''); ?> hover:bg-gray-100 dark:hover:bg-gray-800" aria-label="English">🇬🇧</button>
                                    </form>
                                </div>
                                <button
                                    id="theme-toggle"
                                    type="button"
                                    class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-gray-100 px-3 py-1.5 text-sm font-medium text-gray-900 hover:bg-gray-200 hover:border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700"
                                >
                                    <span class="inline-flex h-4 w-4 items-center justify-center">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364 6.364-1.414-1.414M7.05 7.05 5.636 5.636m12.728 0-1.414 1.414M7.05 16.95 5.636 18.364" />
                                            <circle cx="12" cy="12" r="4" />
                                        </svg>
                                    </span>
                                    <span id="theme-toggle-label">Dark</span>
                                </button>
                                <?php if(auth()->guard()->check()): ?>
                                    <div x-data="{ open: false }" class="relative">
                                        <button @click="open = !open" class="flex items-center gap-2 rounded-full border border-gray-200 bg-gray-50 px-3 py-1.5 text-sm font-medium text-gray-800 hover:bg-gray-100 hover:border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700">
                                            <img class="h-6 w-6 rounded-full object-cover" src="<?php echo e(Auth::user()->profile?->avatar ? asset('storage/' . Auth::user()->profile->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=7F9CF5&background=EBF4FF'); ?>" alt="<?php echo e(Auth::user()->name); ?>" />
                                            <span><?php echo e(Auth::user()->name); ?></span>
                                            <svg class="h-3.5 w-3.5 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
                                        </button>
                                        <div
                                            x-show="open"
                                            @click.away="open = false"
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 scale-95"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="opacity-100 scale-100"
                                            x-transition:leave-end="opacity-0 scale-95"
                                            class="absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-800"
                                            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                            <a href="<?php echo e(route('my.profile.show')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Profilim</a>
                                            <?php if(Route::has('settings.index')): ?>
                                                <a href="<?php echo e(route('settings.index')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Ayarlar</a>
                                            <?php endif; ?>
                                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">
                                                    Çıkış Yap
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <?php if(Route::has('login')): ?>
                                        <a href="<?php echo e(route('login')); ?>" class="text-sm font-medium text-gray-700 hover:text-indigo-600 dark:text-gray-200 dark:hover:text-indigo-400">
                                            <?php echo e(__('ui.login')); ?>

                                        </a>
                                    <?php endif; ?>
                                    <?php if(Route::has('register')): ?>
                                        <a href="<?php echo e(route('register')); ?>" class="rounded-full bg-indigo-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-indigo-700">
                                            <?php echo e(__('ui.register')); ?>

                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 mb-4 md:hidden">
                        <form action="<?php echo e(route('courses.index')); ?>" method="GET">
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="11" cy="11" r="6" />
                                        <line x1="16" y1="16" x2="21" y2="21" />
                                    </svg>
                                </span>
                                <input
                                    type="text"
                                    name="q"
                                    value="<?php echo e(request('q')); ?>"
                                    placeholder="<?php echo e(__('ui.search_placeholder')); ?>"
                                    class="block w-full rounded-full border border-gray-200 bg-gray-50 py-2.5 pl-9 pr-4 text-sm text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                >
                            </div>
                        </form>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <?php if(isset($header)): ?>
                <header class="bg-white shadow dark:bg-gray-900 dark:shadow-black/20">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <?php echo e($header); ?>

                    </div>
                </header>
            <?php endif; ?>

            <!-- Page Content -->
            <main>
                <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                    <?php if(session('success')): ?>
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative dark:bg-green-900 dark:border-green-500 dark:text-green-100" role="alert">
                            <span class="block sm:inline"><?php echo e(session('success')); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if(session('error')): ?>
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative dark:bg-red-900 dark:border-red-500 dark:text-red-100" role="alert">
                            <span class="block sm:inline"><?php echo e(session('error')); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($slot)): ?>
                        <?php echo e($slot); ?>

                    <?php else: ?>
                        <?php echo $__env->yieldContent('content'); ?>
                    <?php endif; ?>
                </div>
            </main>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var pairs = [
                    { btn: document.getElementById('theme-toggle'), label: document.getElementById('theme-toggle-label') },
                    { btn: document.getElementById('theme-toggle-mobile'), label: document.getElementById('theme-toggle-mobile-label') },
                ].filter(function(p){ return p.btn && p.label; });
                function syncAll() {
                    var isDark = document.documentElement.classList.contains('dark');
                    pairs.forEach(function(p){
                        p.label.textContent = isDark ? 'Light' : 'Dark';
                    });
                }
                syncAll();
                pairs.forEach(function(p){
                    p.btn.addEventListener('click', function () {
                        if (document.documentElement.classList.contains('dark')) {
                            document.documentElement.classList.remove('dark');
                            localStorage.theme = 'light';
                        } else {
                            document.documentElement.classList.add('dark');
                            localStorage.theme = 'dark';
                        }
                        syncAll();
                    });
                });
            });
        </script>
        <?php echo $__env->yieldPushContent('scripts'); ?>
    </body>
</html>
<?php /**PATH C:\Users\Guney\Documents\trae_projects\egitim-portali\resources\views/layouts/app.blade.php ENDPATH**/ ?>