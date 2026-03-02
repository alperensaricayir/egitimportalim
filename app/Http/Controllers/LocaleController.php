<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'locale' => 'required|in:tr,en',
        ]);

        $locale = $data['locale'];
        $request->session()->put('locale', $locale);

        return back()->withCookie(cookie('locale', $locale, 60 * 24 * 365));
    }
}

