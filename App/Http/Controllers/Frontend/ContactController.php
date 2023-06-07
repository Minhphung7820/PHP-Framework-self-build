<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

class ContactController extends BaseController
{
    public function index()
    {
        return view('frontend.contact.index');
    }
}
