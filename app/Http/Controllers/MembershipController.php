<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use App\Models\Subscription;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        $plans = MembershipPlan::all();
        $current = auth()->user()->activeSubscription?->plan;
        return view('portal.plans.index', compact('plans', 'current'));
    }

    public function subscribe(MembershipPlan $plan)
    {
        $user = auth()->user();
        // Deactivate existing
        $user->subscriptions()->where('active', true)->update(['active' => false, 'ends_at' => now()]);
        // Create new
        $user->subscriptions()->create([
            'membership_plan_id' => $plan->id,
            'active' => true,
            'starts_at' => now(),
            'ends_at' => null,
        ]);
        return redirect()->route('plans.index');
    }

    public function unsubscribe()
    {
        $user = auth()->user();
        $user->subscriptions()->where('active', true)->update(['active' => false, 'ends_at' => now()]);
        return redirect()->route('plans.index');
    }
}

