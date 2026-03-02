<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function services()
    {
        $services = Service::all();
        return view('portal.services.index', compact('services'));
    }

    public function jobs()
    {
        $jobs = JobPosting::where('is_active', true)->latest()->get();
        return view('portal.jobs.index', compact('jobs'));
    }
    
    public function profiles()
    {
         $users = User::whereNotNull('bio')->paginate(12);
         return view('portal.profiles.index', compact('users'));
    }
    
    public function showProfile(User $user)
    {
        $user->load(['socialLinks', 'likesReceived']);
        $likedToday = false;
        if (auth()->check()) {
            $likedToday = $user->likesReceived()
                ->where('user_id', auth()->id())
                ->where('created_at', '>=', now()->startOfDay())
                ->exists();
        }
        return view('portal.profiles.show', compact('user', 'likedToday'));
    }
}
