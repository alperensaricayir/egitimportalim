<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilesController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('profile')
            ->whereHas('profile', function ($q) {
                $q->where('is_public', true);
            });

        // Search functionality
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('profile', function ($q) use ($search) {
                        $q->where('headline', 'like', "%{$search}%")
                            ->orWhere('city', 'like', "%{$search}%")
                            ->orWhere('country', 'like', "%{$search}%")
                            ->orWhereJsonContains('skills', $search);
                    });
            });
        }

        $profiles = $query->paginate(12);

        return view('profiles.index', compact('profiles'));
    }

    public function show(User $user)
    {
        // Ensure profile exists
        if (!$user->profile) {
            abort(404);
        }

        // Authorization check
        $canView = $user->profile->is_public || 
                   Auth::check() && (Auth::id() === $user->id || Auth::user()->isAdminOrEditor());

        if (!$canView) {
            abort(403, 'This profile is private.');
        }

        return view('profiles.show', [
            'user' => $user,
            'profile' => $user->profile,
        ]);
    }
}
