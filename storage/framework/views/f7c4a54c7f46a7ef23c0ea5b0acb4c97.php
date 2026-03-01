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
            <?php echo e($course->title); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="md:flex md:space-x-8">
                <div class="md:w-1/3 mb-6 md:mb-0">
                    <?php if($course->thumbnail): ?>
                        <img src="<?php echo e(Storage::disk('public')->url($course->thumbnail)); ?>" alt="<?php echo e($course->title); ?>" class="w-full rounded shadow-md">
                    <?php else: ?>
                        <div class="w-full h-64 bg-gray-200 flex items-center justify-center text-gray-400 rounded">
                            No Image
                        </div>
                    <?php endif; ?>

                    <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-100">
                        <div class="text-2xl font-bold text-gray-900 mb-2">
                            <?php echo e($course->is_paid ? '$' . $course->price : 'Free'); ?>

                        </div>
                        
                        <?php if(auth()->guard()->check()): ?>
                            <?php if(auth()->user()->courses->contains($course->id)): ?>
                                <div class="w-full py-3 bg-green-100 text-green-800 text-center rounded font-semibold">
                                    You are enrolled
                                </div>
                            <?php else: ?>
                                <form action="<?php echo e(route('courses.enroll', $course)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded font-semibold transition duration-150">
                                        Enroll Now
                                    </button>
                                </form>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if(Route::has('login')): ?>
                                <a href="<?php echo e(route('login')); ?>" class="block w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-center rounded font-semibold transition duration-150">
                                    Login to Enroll
                                </a>
                            <?php else: ?>
                                <span class="block w-full py-3 bg-gray-300 text-gray-600 text-center rounded font-semibold">
                                    Login feature not available
                                </span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="md:w-2/3">
                    <h3 class="text-lg font-semibold mb-2">Description</h3>
                    <div class="prose max-w-none text-gray-600 mb-8">
                        <?php echo e($course->description); ?>

                    </div>

                    <h3 class="text-lg font-semibold mb-4">Course Content</h3>
                    <div class="border rounded-md overflow-hidden">
                        <?php $__empty_1 = true; $__currentLoopData = $course->lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="flex items-center justify-between p-4 border-b last:border-b-0 hover:bg-gray-50">
                                <div class="flex items-center">
                                    <span class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-sm font-semibold text-gray-600 mr-3">
                                        <?php echo e($loop->iteration); ?>

                                    </span>
                                    <span class="font-medium text-gray-900"><?php echo e($lesson->title); ?></span>
                                </div>
                                
                                <?php if(auth()->guard()->check()): ?>
                                    <?php if(auth()->user()->courses->contains($course->id) || in_array(auth()->user()->role, ['admin', 'editor'], true)): ?>
                                        <a href="<?php echo e(route('lessons.show', [$course, $lesson])); ?>" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                            Start
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-sm">Locked</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-gray-400 text-sm">Locked</span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="p-4 text-gray-500 italic">No lessons available yet.</div>
                        <?php endif; ?>
                    </div>
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