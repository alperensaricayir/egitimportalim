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
                <?php echo e(__('Manage Courses')); ?>

            </h2>
            <a href="<?php echo e(route('admin.courses.create')); ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                Add New Course
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search & Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                <form action="<?php echo e(route('admin.courses.index')); ?>" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                        <input type="text" name="search" id="search" value="<?php echo e(request('search')); ?>" placeholder="Title..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">All Statuses</option>
                            <option value="published" <?php echo e(request('status') === 'published' ? 'selected' : ''); ?>>Published</option>
                            <option value="draft" <?php echo e(request('status') === 'draft' ? 'selected' : ''); ?>>Draft</option>
                            <option value="archived" <?php echo e(request('status') === 'archived' ? 'selected' : ''); ?>>Archived</option>
                        </select>
                    </div>
                    <div>
                        <label for="is_paid" class="block text-sm font-medium text-gray-700">Price Type</label>
                        <select name="is_paid" id="is_paid" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">All</option>
                            <option value="1" <?php echo e(request('is_paid') === '1' ? 'selected' : ''); ?>>Paid</option>
                            <option value="0" <?php echo e(request('is_paid') === '0' ? 'selected' : ''); ?>>Free</option>
                        </select>
                    </div>
                    <div>
                        <label for="trashed" class="block text-sm font-medium text-gray-700">Deleted</label>
                        <select name="trashed" id="trashed" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Active Only</option>
                            <option value="with" <?php echo e(request('trashed') === 'with' ? 'selected' : ''); ?>>With Trashed</option>
                            <option value="only" <?php echo e(request('trashed') === 'only' ? 'selected' : ''); ?>>Only Trashed</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded w-full">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Bulk Actions & List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="<?php echo e(route('admin.courses.bulk_action')); ?>" method="POST" id="bulk-action-form">
                    <?php echo csrf_field(); ?>
                    <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <select name="action" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                                <option value="">Bulk Actions</option>
                                <option value="publish">Publish</option>
                                <option value="unpublish">Unpublish</option>
                                <option value="delete">Delete</option>
                                <option value="restore">Restore</option>
                                <option value="force_delete">Force Delete</option>
                            </select>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to apply this action to selected items?')">
                                Apply
                            </button>
                        </div>
                        <div class="text-sm text-gray-500">
                            <?php echo e($courses->total()); ?> courses found
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4">
                                        <input type="checkbox" id="select-all" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'title', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])); ?>" class="group flex items-center">
                                            Title
                                            <!-- Sort icon logic here if needed -->
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'students_count', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])); ?>">
                                            Students
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])); ?>">
                                            Date
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="<?php echo e($course->trashed() ? 'bg-red-50' : ''); ?>">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="checkbox" name="ids[]" value="<?php echo e($course->id); ?>" class="course-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <?php if($course->thumbnail): ?>
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded object-cover" src="<?php echo e(Storage::url($course->thumbnail)); ?>" alt="">
                                                    </div>
                                                <?php else: ?>
                                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded flex items-center justify-center">
                                                        <span class="text-gray-500 text-xs">No Img</span>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <?php echo e($course->title); ?>

                                                        <?php if($course->trashed()): ?>
                                                            <span class="text-red-600 text-xs ml-2">(Deleted)</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="text-xs text-gray-500"><?php echo e(\Illuminate\Support\Str::limit($course->description, 50)); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                <?php echo e($course->status === 'published' ? 'bg-green-100 text-green-800' : 
                                                   ($course->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')); ?>">
                                                <?php echo e(ucfirst($course->status)); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo e($course->is_paid ? '$' . $course->price : 'Free'); ?>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo e($course->users_count ?? 0); ?>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo e($course->created_at->format('M d, Y')); ?>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <?php if($course->trashed()): ?>
                                                <button type="button" onclick="confirmRestore('<?php echo e($course->id); ?>')" class="text-green-600 hover:text-green-900 mr-3">Restore</button>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('admin.courses.edit', $course)); ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                            <?php endif; ?>
                                            
                                            <button type="button" onclick="confirmDelete('<?php echo e($course->id); ?>', <?php echo e($course->trashed() ? 'true' : 'false'); ?>)" class="text-red-600 hover:text-red-900">
                                                <?php echo e($course->trashed() ? 'Force Delete' : 'Delete'); ?>

                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                            No courses found.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            
            <div class="mt-4">
                <?php echo e($courses->withQueryString()->links()); ?>

            </div>
        </div>
    </div>

    <!-- Hidden forms for individual actions -->
    <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($course->trashed()): ?>
            <form id="restore-form-<?php echo e($course->id); ?>" action="<?php echo e(route('admin.courses.restore', $course->id)); ?>" method="POST" class="hidden">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
            </form>
        <?php endif; ?>
        <form id="delete-form-<?php echo e($course->id); ?>" action="<?php echo e(route('admin.courses.destroy', $course->id)); ?>" method="POST" class="hidden">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <?php if($course->trashed()): ?>
                <input type="hidden" name="force" value="1">
            <?php endif; ?>
        </form>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            var checkboxes = document.getElementsByClassName('course-checkbox');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = this.checked;
            }
        });

        function confirmDelete(id, isForce) {
            var message = isForce ? 'Are you sure you want to permanently delete this course? This action cannot be undone.' : 'Are you sure you want to move this course to trash?';
            if (confirm(message)) {
                document.getElementById('delete-form-' + id).submit();
            }
        }

        function confirmRestore(id) {
            if (confirm('Restore this course from trash?')) {
                document.getElementById('restore-form-' + id).submit();
            }
        }
    </script>

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
<?php /**PATH C:\Users\Guney\Documents\trae_projects\egitim-portali\resources\views\admin\courses\index.blade.php ENDPATH**/ ?>