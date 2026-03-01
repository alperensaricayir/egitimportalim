<?php

use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LessonController as AdminLessonController;
use App\Http\Controllers\Admin\ToolsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminAccess;
use App\Http\Middleware\CheckEnrollment;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('courses.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Minimal Auth routes (login/logout)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Public Course Routes
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Enrollment
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])->name('courses.enroll');

    // Protected Lesson Routes
    Route::middleware(CheckEnrollment::class)->scopeBindings()->group(function () {
        Route::get('/courses/{course}/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');
    });
});

// Admin Routes
Route::middleware(['auth', AdminAccess::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/tools/route-tester', [ToolsController::class, 'routeTester'])->name('tools.route_tester');
    
    // Manage Courses
    Route::post('courses/bulk-action', [AdminCourseController::class, 'bulkAction'])->name('courses.bulk_action');
    Route::put('courses/{course}/restore', [AdminCourseController::class, 'restore'])->name('courses.restore')->withTrashed();
    Route::post('courses/{course}/revisions/{revision}/restore', [AdminCourseController::class, 'restoreRevision'])->name('courses.restore_revision')->withTrashed();
    Route::delete('courses/{course}', [AdminCourseController::class, 'destroy'])->name('courses.destroy')->withTrashed();
    Route::resource('courses', AdminCourseController::class)->except(['destroy']);
    
    // Manage Lessons (Nested under Courses)
    Route::scopeBindings()->group(function () {
        Route::post('courses/{course}/lessons/reorder', [AdminLessonController::class, 'reorder'])->name('lessons.reorder');
        Route::post('courses/{course}/lessons/{lesson}/revisions/{revision}/restore', [AdminLessonController::class, 'restoreRevision'])->name('lessons.restore_revision');
        Route::get('/courses/{course}/lessons/create', [AdminLessonController::class, 'create'])->name('lessons.create');
        Route::post('/courses/{course}/lessons', [AdminLessonController::class, 'store'])->name('lessons.store');
        Route::get('/courses/{course}/lessons/{lesson}/edit', [AdminLessonController::class, 'edit'])->name('lessons.edit');
        Route::put('/courses/{course}/lessons/{lesson}', [AdminLessonController::class, 'update'])->name('lessons.update');
        Route::delete('/courses/{course}/lessons/{lesson}', [AdminLessonController::class, 'destroy'])->name('lessons.destroy');
    });
});

require __DIR__.'/auth.php';
