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
        <div class="flex flex-col gap-1">
            <p class="text-xs font-medium uppercase tracking-wide text-indigo-600">
                Course
            </p>
            <h2 class="text-2xl font-semibold leading-tight text-gray-900">
                <?php echo e($course->title); ?>

            </h2>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
        <div class="p-6 md:p-8">
            <div class="flex flex-col gap-8 md:flex-row md:items-start">
                <div class="md:w-1/3">
                    <?php if($course->thumbnail): ?>
                        <img src="<?php echo e(Storage::disk('public')->url($course->thumbnail)); ?>" alt="<?php echo e($course->title); ?>" class="w-full rounded-xl shadow-md">
                    <?php else: ?>
                        <div class="flex h-64 w-full items-center justify-center rounded-xl bg-gray-100 text-gray-400">
                            No Image
                        </div>
                    <?php endif; ?>

                    <div class="mt-6 rounded-2xl border border-gray-100 bg-gray-50 p-5">
                        <div class="mb-3 text-sm font-medium text-gray-500">
                            Course price
                        </div>
                        <div class="text-3xl font-bold text-gray-900">
                            <?php echo e($course->is_paid ? '$' . $course->price : 'Free'); ?>

                        </div>

                        <div class="mt-4 text-xs text-gray-500">
                            <?php echo e($course->lessons->count()); ?> lesson<?php echo e($course->lessons->count() === 1 ? '' : 's'); ?> included
                        </div>
                        
                        <div class="mt-5">
                            <?php if(auth()->guard()->check()): ?>
                                <?php if(auth()->user()->courses->contains($course->id)): ?>
                                    <div class="w-full rounded-full bg-green-100 py-2.5 text-center text-sm font-semibold text-green-800">
                                        You are enrolled
                                    </div>
                                <?php else: ?>
                                    <form action="<?php echo e(route('courses.enroll', $course)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="flex w-full items-center justify-center rounded-full bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                                            Enroll now
                                        </button>
                                    </form>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if(Route::has('login')): ?>
                                    <a href="<?php echo e(route('login')); ?>" class="flex w-full items-center justify-center rounded-full bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                                        Login to enroll
                                    </a>
                                <?php else: ?>
                                    <span class="block w-full rounded-full bg-gray-300 py-2.5 text-center text-sm font-semibold text-gray-600">
                                        Login feature not available
                                    </span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="md:w-2/3">
                    <section class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Description
                        </h3>
                        <div class="mt-3 max-w-none text-sm leading-relaxed text-gray-600">
                            <?php echo e($course->description); ?>

                        </div>
                    </section>

                    <section>
                        <h3 class="mb-4 text-lg font-semibold text-gray-900">
                            Course content
                        </h3>
                        <div class="overflow-hidden rounded-2xl border border-gray-100">
                            <?php $__empty_1 = true; $__currentLoopData = $course->lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="flex items-center justify-between gap-4 border-b last:border-b-0 bg-white px-4 py-3.5 text-sm transition hover:bg-gray-50">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-50 text-xs font-semibold text-indigo-700">
                                            <?php echo e($loop->iteration); ?>

                                        </span>
                                        <span class="font-medium text-gray-900">
                                            <?php echo e($lesson->title); ?>

                                        </span>
                                    </div>
                                    
                                    <?php if(auth()->guard()->check()): ?>
                                        <?php if(auth()->user()->courses->contains($course->id) || in_array(auth()->user()->role, ['admin', 'editor'], true)): ?>
                                            <a href="<?php echo e(route('lessons.show', [$course, $lesson])); ?>" class="text-xs font-semibold uppercase tracking-wide text-indigo-600 hover:text-indigo-800">
                                                Start
                                            </a>
                                        <?php else: ?>
                                            <span class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                                Locked
                                            </span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                            Locked
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="px-4 py-6 text-sm text-gray-500">
                                    No lessons available yet.
                                </div>
                            <?php endif; ?>
                        </div>
                    </section>
                </div>
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
<?php /**PATH C:\Users\Guney\Documents\trae_projects\egitim-portali\resources\views/courses/show.blade.php ENDPATH**/ ?>