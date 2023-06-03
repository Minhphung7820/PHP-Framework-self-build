<?php

namespace Http\Controllers\Frontend;

use Http\Controllers\BaseController;

class ContactController extends BaseController
{
    public function index()
    {
        return view('frontend.contact.index');
    }
}
