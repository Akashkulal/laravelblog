<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Apps\Models\Category;

class DashboardControlller extends Controller
{
    public function index()
    {
        return view('Admin.dashboard');
    }
    public function logout()
    {
        return redirect('/login');
    }
}
