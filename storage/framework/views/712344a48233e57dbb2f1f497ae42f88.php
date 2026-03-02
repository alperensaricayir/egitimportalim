<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('ui.admin_dashboard')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-gray-900 dark:border dark:border-gray-700">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-900 dark:border-gray-700">
                <div class="text-gray-500 text-sm uppercase font-semibold dark:text-gray-300">Total Users</div>
                <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100"><?php echo e($stats['users']); ?></div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-gray-900 dark:border dark:border-gray-700">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-900 dark:border-gray-700">
                <div class="text-gray-500 text-sm uppercase font-semibold dark:text-gray-300">Total Courses</div>
                <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100"><?php echo e($stats['courses']); ?></div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-gray-900 dark:border dark:border-gray-700">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-900 dark:border-gray-700">
                <div class="text-gray-500 text-sm uppercase font-semibold dark:text-gray-300">Total Enrollments</div>
                <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100"><?php echo e($stats['enrollments']); ?></div>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4 dark:text-gray-100"><?php echo e(__('ui.quick_actions')); ?></h3>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-gray-900 dark:border dark:border-gray-700">
            <div class="p-6 bg-white border-b border-gray-200 flex flex-wrap gap-4 dark:bg-gray-900 dark:border-gray-700">
                <?php if(in_array(auth()->user()->role, ['admin','editor'])): ?>
                    <a href="<?php echo e(route('admin.courses.index')); ?>" class="text-indigo-600 hover:text-indigo-900 font-semibold dark:text-indigo-400 dark:hover:text-indigo-300"><?php echo e(__('ui.courses')); ?> &rarr;</a>
                    <span class="text-gray-300 dark:text-gray-600">|</span>
                    <a href="<?php echo e(route('admin.lessons.create', ['course' => optional(\App\Models\Course::first())->id])); ?>" class="text-indigo-600 hover:text-indigo-900 font-semibold dark:text-indigo-400 dark:hover:text-indigo-300"><?php echo e(__('ui.lessons')); ?> &rarr;</a>
                    <span class="text-gray-300 dark:text-gray-600">|</span>
                    <a href="<?php echo e(route('admin.tickets.index')); ?>" class="text-indigo-600 hover:text-indigo-900 font-semibold dark:text-indigo-400 dark:hover:text-indigo-300"><?php echo e(__('ui.tickets')); ?> &rarr;</a>
                    <span class="text-gray-300 dark:text-gray-600">|</span>
                    <a href="<?php echo e(route('admin.announcements.index')); ?>" class="text-indigo-600 hover:text-indigo-900 font-semibold dark:text-indigo-400 dark:hover:text-indigo-300"><?php echo e(__('ui.announcements')); ?> &rarr;</a>
                    <span class="text-gray-300 dark:text-gray-600">|</span>
                    <a href="<?php echo e(route('admin.jobs.index')); ?>" class="text-indigo-600 hover:text-indigo-900 font-semibold dark:text-indigo-400 dark:hover:text-indigo-300"><?php echo e(__('ui.jobs')); ?> &rarr;</a>
                <?php endif; ?>
                <?php if(auth()->user()->role === 'admin'): ?>
                    <span class="text-gray-300 dark:text-gray-600">|</span>
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="text-indigo-600 hover:text-indigo-900 font-semibold dark:text-indigo-400 dark:hover:text-indigo-300"><?php echo e(__('ui.students')); ?> &rarr;</a>
                    <span class="text-gray-300 dark:text-gray-600">|</span>
                    <a href="<?php echo e(route('admin.settings.index')); ?>" class="text-indigo-600 hover:text-indigo-900 font-semibold dark:text-indigo-400 dark:hover:text-indigo-300"><?php echo e(__('ui.settings')); ?> &rarr;</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Guney\Documents\trae_projects\egitim-portali\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>