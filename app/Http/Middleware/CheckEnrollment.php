<?php

namespace App\Http\Middleware;

use App\Models\Course;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEnrollment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $courseParam = $request->route('course');
        $course = $courseParam instanceof Course ? $courseParam : Course::find($courseParam);
        if (!$course) {
            abort(404);
        }
        
        if (!auth()->check()) {
            return \Illuminate\Support\Facades\Route::has('login')
                ? redirect()->route('login')
                : redirect()->route('courses.show', $course)->with('error', 'Please log in to continue.');
        }

        $user = auth()->user();

        // Admin/editor bypass
        if (in_array($user->role, ['admin', 'editor'], true)) {
            return $next($request);
        }

        // Check if user is enrolled
        if (!$user->courses()->where('courses.id', $course->id)->exists()) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'You must be enrolled to access this content.');
        }

        return $next($request);
    }
}
