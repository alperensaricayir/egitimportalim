<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $user->fill($request->only([
            'name',
            'email',
        ]));

        $user->save();

        return redirect()->route('profile.edit');
    }

    public function destroy(Request $request)
    {
        $user = $request->user();

        $user->delete();

        return redirect('/');
    }
}

