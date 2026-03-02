<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, User $user)
    {
        $actorId = $request->user()->id;
        if ($actorId === $user->id) {
            return back();
        }

        $alreadyToday = Like::where('user_id', $actorId)
            ->where('liked_user_id', $user->id)
            ->where('created_at', '>=', Carbon::today())
            ->exists();

        if ($alreadyToday) {
            return back();
        }

        Like::create([
            'user_id' => $actorId,
            'liked_user_id' => $user->id,
        ]);

        return back();
    }
}

