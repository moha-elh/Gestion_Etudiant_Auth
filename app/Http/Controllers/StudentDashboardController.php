<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $student = $user->student; 
        
        return view('student.dashboard', compact('user', 'student'));
    }
}
