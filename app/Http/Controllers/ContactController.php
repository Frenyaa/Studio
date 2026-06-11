<?php

namespace App\Http\Controllers;

class ContactController extends Controller
{
    public function index()
    {
        // $settings được chia sẻ sẵn cho 'partials.contact' qua View composer (AppServiceProvider).
        return view('contact');
    }
}
