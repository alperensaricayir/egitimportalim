<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MyProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
        // Ensure profile exists
        if (!$user->profile) {
            $user->profile()->create([
                'headline' => 'Member',
                'bio' => 'Welcome to my profile!',
                'city' => $user->city ?? null,
                'country' => $user->country ?? null,
                'skills' => $user->isAdmin() ? ['Laravel', 'PHP', 'Web Development'] : [],
                'is_public' => false,
            ]);
            // Reload the relationship after creation
            $user->load('profile');
        }
        
        return view('my-profile.show', [
            'user' => $user,
            'profile' => $user->profile,
        ]);
    }

    public function edit()
    {
        $user = Auth::user();
        
        // Ensure profile exists
        if (!$user->profile) {
            $user->profile()->create([
                'headline' => 'Member',
                'bio' => 'Welcome to my profile!',
                'city' => $user->city ?? null,
                'country' => $user->country ?? null,
                'skills' => $user->isAdmin() ? ['Laravel', 'PHP', 'Web Development'] : [],
                'is_public' => false,
            ]);
            // Reload the relationship after creation
            $user->load('profile');
        }
        
        return view('my-profile.edit', [
            'user' => $user,
            'profile' => $user->profile,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Ensure profile exists
        if (!$user->profile) {
            $user->profile()->create([
                'headline' => 'Member',
                'bio' => 'Welcome to my profile!',
                'city' => $user->city ?? null,
                'country' => $user->country ?? null,
                'skills' => $user->isAdmin() ? ['Laravel', 'PHP', 'Web Development'] : [],
                'is_public' => false,
            ]);
        }
        
        $validated = $request->validate([
            'headline' => ['nullable', 'string', 'max:120'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'city' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'skills' => ['nullable', 'string'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'x_url' => ['nullable', 'url', 'max:255'],
            'behance_url' => ['nullable', 'url', 'max:255'],
            'dribbble_url' => ['nullable', 'url', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:2048'], // 2MB max
            'cover_image' => ['nullable', 'image', 'max:5120'], // 5MB max
            'is_public' => ['boolean'],
        ]);
        
        // Handle skills conversion from comma-separated string to array
        if (isset($validated['skills'])) {
            $validated['skills'] = array_map('trim', explode(',', $validated['skills']));
            $validated['skills'] = array_filter($validated['skills']); // Remove empty values
        }
        
        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->profile->avatar_path) {
                Storage::disk('public')->delete($user->profile->avatar_path);
            }
            
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar_path'] = $avatarPath;
        }
        
        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old cover image if exists
            if ($user->profile->cover_image) {
                Storage::disk('public')->delete($user->profile->cover_image);
            }
            
            $coverPath = $request->file('cover_image')->store('covers', 'public');
            $validated['cover_image'] = $coverPath;
        }
        
        $user->profile->update($validated);
        
        return redirect()->route('my.profile.show')->with('success', 'Profile updated successfully.');
    }
}
