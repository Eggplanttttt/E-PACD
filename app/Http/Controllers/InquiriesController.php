<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InquiriesController extends Controller
{
    public function show()
    {
        return view('inquiries'); // This will load resources/views/inquiries.blade.php
    }
}

