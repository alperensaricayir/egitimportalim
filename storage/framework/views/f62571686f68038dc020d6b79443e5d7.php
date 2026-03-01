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
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <?php echo e($course->title); ?> - <?php echo e($lesson->title); ?>

            </h2>
            <a href="<?php echo e(route('courses.show', $course)); ?>" class="text-sm text-indigo-600 hover:underline">
                Back to Course
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <?php if($lesson->video_url): ?>
                    <div class="aspect-w-16 aspect-h-9 mb-6">
                        <iframe src="<?php echo e($lesson->video_url); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-96 rounded"></iframe>
                    </div>
                <?php endif; ?>

                <div class="prose max-w-none mb-8">
                    <?php echo nl2br(e($lesson->content)); ?>

                </div>

                <div class="flex justify-between border-t pt-6 mt-6">
                    <?php if($previous): ?>
                        <a href="<?php echo e(route('lessons.show', [$course, $previous])); ?>" class="flex items-center text-indigo-600 hover:text-indigo-800">
                            &larr; Previous Lesson
                        </a>
                    <?php else: ?>
                        <span></span>
                    <?php endif; ?>

                    <?php if($next): ?>
                        <a href="<?php echo e(route('lessons.show', [$course, $next])); ?>" class="flex items-center text-indigo-600 hover:text-indigo-800">
                            Next Lesson &rarr;
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('courses.show', $course)); ?>" class="text-green-600 hover:text-green-800 font-semibold">
                            Complete Course
                        </a>
                    <?php endif; ?>
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
<?php /**PATH C:\Users\Guney\Documents\trae_projects\egitim-portali\resources\views\lessons\show.blade.php ENDPATH**/ ?>