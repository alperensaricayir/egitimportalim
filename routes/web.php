<?php

use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LessonController as AdminLessonController;
use App\Http\Controllers\Admin\ToolsController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SupportTicketController as AdminTicketController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LocaleController;
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

// Backward compatibility: /home should always resolve
Route::redirect('/home', '/')->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Locale
Route::post('/locale', [LocaleController::class, 'update'])->name('locale.update');

// Minimal Auth routes (login/logout) — Türkçe URL'ler, isimler aynı
Route::middleware('guest')->group(function () {
    Route::get('/giris', [LoginController::class, 'show'])->name('login');
    Route::post('/giris', [LoginController::class, 'login'])->name('login.post');
});
Route::post('/cikis', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Public Course Routes — Türkçe
Route::get('/kurslar', [CourseController::class, 'index'])->name('courses.index');
Route::get('/kurslar/{course}', [CourseController::class, 'show'])->name('courses.show');

// Public Portal Pages — Türkçe
Route::get('/urunler', [ProductController::class, 'index'])->name('products.index');
Route::get('/is-ilanlari', [PortalController::class, 'jobs'])->name('jobs.index');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profil', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Enrollment
    Route::post('/kurslar/{course}/kayit', [EnrollmentController::class, 'store'])->name('courses.enroll');

    // Protected Lesson Routes
    Route::middleware(CheckEnrollment::class)->scopeBindings()->group(function () {
        Route::get('/kurslar/{course}/dersler/{lesson}', [LessonController::class, 'show'])->name('lessons.show');
    });

    // Portal Routes
    Route::get('/uyelerim', [PortalController::class, 'profiles'])->name('members.index');
    Route::get('/destek', [SupportTicketController::class, 'index'])->name('support.index');
    Route::get('/planlar', [MembershipController::class, 'index'])->name('plans.index');
    Route::post('/planlar/{plan}/abonelik', [MembershipController::class, 'subscribe'])->name('plans.subscribe');
    Route::post('/planlar/abonelik-iptal', [MembershipController::class, 'unsubscribe'])->name('plans.unsubscribe');
    // Resource: kullanıcı destek talepleri (URI Türkçe, isimler aynı kalır)
    Route::resource('destek', SupportTicketController::class)
        ->names('tickets')
        ->parameters(['destek' => 'ticket']);
    Route::post('/destek/{ticket}/yanitla', [SupportTicketController::class, 'reply'])->name('tickets.reply');
    Route::get('/uyeler', [PortalController::class, 'profiles'])->name('profiles.index');
    Route::get('/uyeler/{user}', [PortalController::class, 'showProfile'])->name('profiles.show');
    Route::post('/uyeler/{user}/begen', [LikeController::class, 'store'])->name('profiles.like');
});

// Admin Routes (legacy tools only — Filament panel handles CRUD & dashboard)
Route::middleware(['auth', AdminAccess::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/tools/route-tester', [ToolsController::class, 'routeTester'])->name('tools.route_tester');
});

// Profile Routes — Türkçe
Route::middleware(['auth'])->group(function () {
    Route::get('/profilim', [MyProfileController::class, 'show'])->name('my.profile.show');
    Route::get('/profilim/duzenle', [MyProfileController::class, 'edit'])->name('my.profile.edit');
    Route::put('/profilim', [MyProfileController::class, 'update'])->name('my.profile.update');
});

// Public Profile Routes — Türkçe
Route::get('/uyeler', [ProfilesController::class, 'index'])->name('public.profiles.index');
Route::get('/uyeler/{user}', [ProfilesController::class, 'show'])->name('public.profiles.show');

Route::get('/ben', function () {
    return redirect()->route('my.profile.show');
})->middleware('auth')->name('me');

require __DIR__.'/auth.php';
