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
        <div class="flex flex-col gap-2">
            <h2 class="text-2xl font-semibold text-gray-900">
                Learn something new today
            </h2>
            <p class="text-sm text-gray-500">
                Browse curated courses and keep improving your skills.
            </p>
        </div>
     <?php $__env->endSlot(); ?>

    <section class="mb-6 rounded-2xl bg-gradient-to-r from-indigo-600 via-indigo-500 to-violet-500 px-6 py-8 text-white">
        <div class="max-w-3xl">
            <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">
                Upgrade your skills with modern courses
            </h1>
            <p class="mt-3 text-sm sm:text-base text-indigo-100">
                Discover practical, up-to-date content designed to help you move faster in your learning journey.
            </p>
        </div>
        <div class="mt-6 flex flex-wrap items-center gap-3 text-xs sm:text-sm">
            <span class="rounded-full bg-white/10 px-3 py-1">
                Real-world projects
            </span>
            <span class="rounded-full bg-white/10 px-3 py-1">
                Lifetime access
            </span>
            <span class="rounded-full bg-white/10 px-3 py-1">
                Learn at your pace
            </span>
        </div>
    </section>

    <section>
        <div class="mb-4 flex items-center justify-between gap-3">
            <h3 class="text-lg font-semibold text-gray-900">
                All courses
            </h3>
            <span class="text-xs sm:text-sm text-gray-500">
                <?php echo e($courses->total()); ?> course<?php echo e($courses->total() === 1 ? '' : 's'); ?> available
            </span>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($course->thumbnail): ?>
                        <div class="relative">
                            <img
                                src="<?php echo e(Storage::disk('public')->url($course->thumbnail)); ?>"
                                alt="<?php echo e($course->title); ?>"
                                class="h-44 w-full object-cover transition duration-200 group-hover:scale-[1.02]"
                            >
                        </div>
                    <?php else: ?>
                        <div class="flex h-44 w-full items-center justify-center bg-gray-100 text-sm font-medium text-gray-400">
                            No Image
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div class="flex flex-1 flex-col p-5">
                        <div class="flex items-baseline justify-between gap-2 text-xs">
                            <span class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 font-semibold text-indigo-700">
                                <?php echo e($course->is_paid ? '$' . $course->price : 'Free'); ?>

                            </span>
                            <span class="text-gray-500">
                                <?php echo e($course->lessons_count); ?> lesson<?php echo e($course->lessons_count === 1 ? '' : 's'); ?>

                            </span>
                        </div>

                        <h4 class="mt-3 line-clamp-2 text-sm sm:text-base font-semibold text-gray-900">
                            <?php echo e($course->title); ?>

                        </h4>
                        <p class="mt-2 line-clamp-2 text-xs sm:text-sm text-gray-500">
                            <?php echo e($course->description); ?>

                        </p>

                        <div class="mt-4 flex items-center justify-between">
                            <a
                                href="<?php echo e(route('courses.show', $course)); ?>"
                                class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800"
                            >
                                View details
                                <span class="ml-1 text-xs">→</span>
                            </a>
                        </div>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="mt-8">
            <?php echo e($courses->links()); ?>

        </div>
    </section>
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
<?php /**PATH C:\Users\Guney\Documents\trae_projects\egitim-portali\resources\views/courses/index.blade.php ENDPATH**/ ?>