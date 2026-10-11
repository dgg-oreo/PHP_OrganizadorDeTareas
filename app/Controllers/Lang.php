<?php

namespace App\Controllers;

class Lang extends BaseController
{
    public function set(string $locale)
    {
        if (in_array($locale, config('App')->supportedLocales, true)) {
            session()->set('lang', $locale);
        }

        return redirect()->back();
    }
}