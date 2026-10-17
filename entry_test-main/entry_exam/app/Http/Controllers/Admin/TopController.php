<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TopController extends Controller
{
    public function index(): View
    {
        return view('admin.home');
    }
}
