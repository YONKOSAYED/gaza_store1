<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    /**
     * Switch the application language.
     *
     * @param  string  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switch($locale)
    {
        if (!in_array($locale, ['ar', 'en'])) {
            abort(404);
        }

        Session::put('locale', $locale);

        App::setLocale($locale);

        return redirect()->back();
    }
}
