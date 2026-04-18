<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
    public function switch($locale)
    {
        if (!in_array($locale, ['en', 'id'])) {
            abort(400);
        }

        session(['locale' => $locale]);

        if (auth()->check()) {
            auth()->user()->update(['language' => $locale]);
        }

        return redirect()->back();
    }
