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
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Admin Tools / Route Tester
            </h2>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-sm text-gray-600 hover:text-gray-900">Back to Dashboard</a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <?php if(session('success')): ?>
                <div class="p-4 bg-green-50 text-green-800 rounded border border-green-200">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="p-4 bg-red-50 text-red-800 rounded border border-red-200">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="p-4 bg-yellow-50 text-yellow-800 rounded border border-yellow-200">
                    <ul class="list-disc pl-5">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($e); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Navigable GET pages -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">A) Navigable GET Pages</h3>
                        <ul class="list-disc pl-5 space-y-2 text-indigo-700">
                            <li><a class="hover:underline" href="<?php echo e(url('/')); ?>">/</a></li>
                            <li><a class="hover:underline" href="<?php echo e(route('courses.index')); ?>">/courses</a></li>
                            <?php if($firstCourse): ?>
                                <li><a class="hover:underline" href="<?php echo e(route('courses.show', $firstCourse)); ?>">/courses/<?php echo e($firstCourse->id); ?></a></li>
                            <?php endif; ?>
                            <li><a class="hover:underline" href="<?php echo e(route('admin.dashboard')); ?>">/admin</a></li>
                            <li><a class="hover:underline" href="<?php echo e(route('admin.courses.index')); ?>">/admin/courses</a></li>
                            <li><a class="hover:underline" href="<?php echo e(route('admin.courses.create')); ?>">/admin/courses/create</a></li>
                            <?php if($firstCourse): ?>
                                <li><a class="hover:underline" href="<?php echo e(route('admin.courses.edit', $firstCourse)); ?>">/admin/courses/<?php echo e($firstCourse->id); ?>/edit</a></li>
                            <?php endif; ?>
                            <?php if($firstCourse && $firstLesson): ?>
                                <li><a class="hover:underline" href="<?php echo e(route('admin.lessons.create', $firstCourse)); ?>">/admin/courses/<?php echo e($firstCourse->id); ?>/lessons/create</a></li>
                                <li><a class="hover:underline" href="<?php echo e(route('admin.lessons.edit', [$firstCourse, $firstLesson])); ?>">/admin/courses/<?php echo e($firstCourse->id); ?>/lessons/<?php echo e($firstLesson->id); ?>/edit</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <!-- Action routes -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">B) Action Routes (Forms)</h3>
                        <div class="space-y-6">
                            <!-- POST /courses/{course}/enroll -->
                            <div>
                                <h4 class="font-medium mb-2">Enroll Course (POST)</h4>
                                <form method="POST" data-template="/courses/{course}/enroll" onsubmit="return setActionFromTemplate(this)">
                                    <?php echo csrf_field(); ?>
                                    <label class="block text-sm text-gray-700 mb-1">Course</label>
                                    <select name="course" class="border rounded p-2 w-full mb-2">
                                        <?php $__currentLoopData = $courses->whereNull('deleted_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($c->id); ?>"><?php echo e($c->id); ?> — <?php echo e($c->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-1.5 px-3 rounded text-sm">Enroll</button>
                                </form>
                            </div>

                            <!-- POST /admin/courses/bulk-action -->
                            <div>
                                <h4 class="font-medium mb-2">Courses Bulk Action (POST)</h4>
                                <form method="POST" action="<?php echo e(route('admin.courses.bulk_action')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <label class="block text-sm text-gray-700 mb-1">Action</label>
                                    <select name="action" class="border rounded p-2 w-full mb-2">
                                        <option value="publish">publish</option>
                                        <option value="unpublish">unpublish</option>
                                        <option value="delete">delete</option>
                                        <option value="restore">restore</option>
                                        <option value="force_delete">force_delete</option>
                                    </select>
                                    <label class="block text-sm text-gray-700 mb-1">IDs</label>
                                    <select name="ids[]" multiple size="4" class="border rounded p-2 w-full mb-2">
                                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($c->id); ?>"><?php echo e($c->id); ?> — <?php echo e($c->title); ?> <?php echo e($c->deleted_at ? '(trashed)' : ''); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-1.5 px-3 rounded text-sm">Apply</button>
                                </form>
                            </div>

                            <!-- PUT /admin/courses/{course}/restore -->
                            <div>
                                <h4 class="font-medium mb-2">Restore Course (PUT)</h4>
                                <form method="POST" data-template="/admin/courses/{course}/restore" onsubmit="return setActionFromTemplate(this)">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <label class="block text-sm text-gray-700 mb-1">Trashed Course</label>
                                    <select name="course" class="border rounded p-2 w-full mb-2">
                                        <?php $__empty_1 = true; $__currentLoopData = $courses->whereNotNull('deleted_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <option value="<?php echo e($c->id); ?>"><?php echo e($c->id); ?> — <?php echo e($c->title); ?> (trashed)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <option value="">No trashed course</option>
                                        <?php endif; ?>
                                    </select>
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-1.5 px-3 rounded text-sm">Restore</button>
                                </form>
                            </div>

                            <!-- POST /admin/courses/{course}/revisions/{revision}/restore -->
                            <div>
                                <h4 class="font-medium mb-2">Restore Course Revision (POST)</h4>
                                <form method="POST" data-template="/admin/courses/{course}/revisions/{revision}/restore" onsubmit="return setActionFromTemplate(this)">
                                    <?php echo csrf_field(); ?>
                                    <label class="block text-sm text-gray-700 mb-1">Course</label>
                                    <select name="course" class="border rounded p-2 w-full mb-2">
                                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($c->id); ?>"><?php echo e($c->id); ?> — <?php echo e($c->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <label class="block text-sm text-gray-700 mb-1">Course Revision</label>
                                    <select name="revision" class="border rounded p-2 w-full mb-2">
                                        <?php $__currentLoopData = $courseRevisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($r->id); ?>">#<?php echo e($r->id); ?> (course <?php echo e($r->course_id); ?>)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-1.5 px-3 rounded text-sm">Restore</button>
                                </form>
                            </div>

                            <!-- POST /admin/courses/{course}/lessons (store) -->
                            <div>
                                <h4 class="font-medium mb-2">Create Lesson (POST)</h4>
                                <form method="POST" data-template="/admin/courses/{course}/lessons" onsubmit="return setActionFromTemplate(this)">
                                    <?php echo csrf_field(); ?>
                                    <label class="block text-sm text-gray-700 mb-1">Course</label>
                                    <select name="course" class="border rounded p-2 w-full mb-2">
                                        <?php $__currentLoopData = $courses->whereNull('deleted_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($c->id); ?>"><?php echo e($c->id); ?> — <?php echo e($c->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Title</label>
                                            <input name="title" class="border rounded p-2 w-full" value="Sample Lesson">
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Order</label>
                                            <input name="order" type="number" class="border rounded p-2 w-full" value="1">
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <label class="block text-sm text-gray-700 mb-1">Status</label>
                                        <select name="status" class="border rounded p-2 w-full">
                                            <option value="draft">draft</option>
                                            <option value="published">published</option>
                                            <option value="archived">archived</option>
                                        </select>
                                    </div>
                                    <div class="mt-2">
                                        <label class="block text-sm text-gray-700 mb-1">Content</label>
                                        <textarea name="content" rows="3" class="border rounded p-2 w-full">Body</textarea>
                                    </div>
                                    <button type="submit" class="mt-2 bg-indigo-600 hover:bg-indigo-700 text-white py-1.5 px-3 rounded text-sm">Create</button>
                                </form>
                            </div>

                            <!-- POST /admin/courses/{course}/lessons/reorder -->
                            <div>
                                <h4 class="font-medium mb-2">Reorder Lessons (POST)</h4>
                                <form method="POST" data-template="/admin/courses/{course}/lessons/reorder" onsubmit="return setActionFromTemplate(this, true)">
                                    <?php echo csrf_field(); ?>
                                    <label class="block text-sm text-gray-700 mb-1">Course</label>
                                    <select name="course" class="border rounded p-2 w-full mb-2">
                                        <?php $__currentLoopData = $courses->whereNull('deleted_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($c->id); ?>"><?php echo e($c->id); ?> — <?php echo e($c->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <label class="block text-sm text-gray-700 mb-1">Order IDs (comma separated)</label>
                                    <input name="order_csv" class="border rounded p-2 w-full mb-2" value="<?php echo e(implode(',', $defaultLessonOrder)); ?>">
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-1.5 px-3 rounded text-sm">Submit</button>
                                </form>
                            </div>

                            <!-- PUT /admin/courses/{course}/lessons/{lesson} -->
                            <div>
                                <h4 class="font-medium mb-2">Update Lesson (PUT)</h4>
                                <form method="POST" data-template="/admin/courses/{course}/lessons/{lesson}" onsubmit="return setActionFromTemplate(this)">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Course</label>
                                            <select name="course" class="border rounded p-2 w-full">
                                                <?php $__currentLoopData = $courses->whereNull('deleted_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($c->id); ?>"><?php echo e($c->id); ?> — <?php echo e($c->title); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Lesson</label>
                                            <select name="lesson" class="border rounded p-2 w-full">
                                                <?php $__currentLoopData = $lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($l->id); ?>"><?php echo e($l->id); ?> — <?php echo e($l->title); ?> (c:<?php echo e($l->course_id); ?>)</option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Order</label>
                                            <input name="order" type="number" class="border rounded p-2 w-full" value="<?php echo e($firstLesson?->order ?? 1); ?>">
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <label class="block text-sm text-gray-700 mb-1">Status</label>
                                        <select name="status" class="border rounded p-2 w-full">
                                            <option value="draft">draft</option>
                                            <option value="published">published</option>
                                            <option value="archived">archived</option>
                                        </select>
                                    </div>
                                    <div class="mt-2">
                                        <label class="block text-sm text-gray-700 mb-1">Title</label>
                                        <input name="title" class="border rounded p-2 w-full" value="<?php echo e($firstLesson?->title ?? 'Lesson'); ?>">
                                    </div>
                                    <div class="mt-2">
                                        <label class="block text-sm text-gray-700 mb-1">Content</label>
                                        <textarea name="content" rows="3" class="border rounded p-2 w-full"><?php echo e($firstLesson?->content ?? '...'); ?></textarea>
                                    </div>
                                    <button type="submit" class="mt-2 bg-indigo-600 hover:bg-indigo-700 text-white py-1.5 px-3 rounded text-sm">Update</button>
                                </form>
                            </div>

                            <!-- DELETE /admin/courses/{course} -->
                            <div>
                                <h4 class="font-medium mb-2">Delete Course (DELETE)</h4>
                                <form method="POST" data-template="/admin/courses/{course}" onsubmit="return setActionFromTemplate(this)">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <label class="block text-sm text-gray-700 mb-1">Course</label>
                                    <select name="course" class="border rounded p-2 w-full mb-2">
                                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($c->id); ?>"><?php echo e($c->id); ?> — <?php echo e($c->title); ?> <?php echo e($c->deleted_at ? '(trashed)' : ''); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <label class="inline-flex items-center space-x-2">
                                        <input type="checkbox" name="force" value="1" class="rounded">
                                        <span class="text-sm text-gray-700">Force delete (if trashed)</span>
                                    </label>
                                    <div class="mt-2">
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-1.5 px-3 rounded text-sm" onclick="return confirm('Delete course?')">Delete</button>
                                    </div>
                                </form>
                            </div>

                            <!-- DELETE /admin/courses/{course}/lessons/{lesson} -->
                            <div>
                                <h4 class="font-medium mb-2">Delete Lesson (DELETE)</h4>
                                <form method="POST" data-template="/admin/courses/{course}/lessons/{lesson}" onsubmit="return setActionFromTemplate(this)">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Course</label>
                                            <select name="course" class="border rounded p-2 w-full">
                                                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($c->id); ?>"><?php echo e($c->id); ?> — <?php echo e($c->title); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Lesson</label>
                                            <select name="lesson" class="border rounded p-2 w-full">
                                                <?php $__currentLoopData = $lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($l->id); ?>"><?php echo e($l->id); ?> — <?php echo e($l->title); ?> (c:<?php echo e($l->course_id); ?>)</option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="mt-2 bg-red-600 hover:bg-red-700 text-white py-1.5 px-3 rounded text-sm" onclick="return confirm('Delete lesson?')">Delete</button>
                                </form>
                            </div>

                            <!-- POST /admin/courses/{course}/lessons/{lesson}/revisions/{revision}/restore -->
                            <div>
                                <h4 class="font-medium mb-2">Restore Lesson Revision (POST)</h4>
                                <form method="POST" data-template="/admin/courses/{course}/lessons/{lesson}/revisions/{revision}/restore" onsubmit="return setActionFromTemplate(this)">
                                    <?php echo csrf_field(); ?>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Course</label>
                                            <select name="course" class="border rounded p-2 w-full">
                                                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($c->id); ?>"><?php echo e($c->id); ?> — <?php echo e($c->title); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Lesson</label>
                                            <select name="lesson" class="border rounded p-2 w-full">
                                                <?php $__currentLoopData = $lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($l->id); ?>"><?php echo e($l->id); ?> — <?php echo e($l->title); ?> (c:<?php echo e($l->course_id); ?>)</option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Revision</label>
                                            <select name="revision" class="border rounded p-2 w-full">
                                                <?php $__currentLoopData = $lessonRevisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($r->id); ?>">#<?php echo e($r->id); ?> (l:<?php echo e($r->lesson_id); ?>)</option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="mt-2 bg-indigo-600 hover:bg-indigo-700 text-white py-1.5 px-3 rounded text-sm">Restore</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setActionFromTemplate(form, isReorder = false) {
            var template = form.getAttribute('data-template');
            if (!template) return true;
            var course = form.querySelector('[name="course"]')?.value;
            var lesson = form.querySelector('[name="lesson"]')?.value;
            var revision = form.querySelector('[name="revision"]')?.value;
            var action = template;
            if (course !== undefined) action = action.replace('{course}', encodeURIComponent(course));
            if (lesson !== undefined) action = action.replace('{lesson}', encodeURIComponent(lesson));
            if (revision !== undefined) action = action.replace('{revision}', encodeURIComponent(revision));
            form.setAttribute('action', action);

            if (isReorder) {
                var csv = form.querySelector('[name="order_csv"]')?.value || '';
                var ids = csv.split(',').map(function(s){ return s.trim(); }).filter(Boolean);
                // Ensure we send order[] inputs
                // Remove old dynamic inputs
                form.querySelectorAll('input[name="order[]"]').forEach(function(el){ el.remove(); });
                ids.forEach(function(id) {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'order[]';
                    input.value = id;
                    form.appendChild(input);
                });
            }
            return true;
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
<?php /**PATH C:\Users\Guney\Documents\trae_projects\egitim-portali\resources\views\admin\tools\route-tester.blade.php ENDPATH**/ ?>