<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = \App\Models\User::where('role', 'student')->with('student')->get();
        return view('admin.dashboard', compact('students'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'cne' => 'required|string|unique:students',
            'sector' => 'required|string',
            'city' => 'required|string',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make('password'), // Type: 'password'
            'role' => 'student',
        ]);

        \App\Models\Student::create([
            'user_id' => $user->id,
            'cne' => $request->cne,
            'sector' => $request->sector,
            'city' => $request->city,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Student created successfully.');
    }

    public function edit($id)
    {
        $student = \App\Models\User::with('student')->findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'cne' => 'required|string|unique:students,cne,' . ($user->student->id ?? 'NULL'), // Handle missing student record case if any
            'sector' => 'required|string',
            'city' => 'required|string',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user->student()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'cne' => $request->cne,
                'sector' => $request->sector,
                'city' => $request->city,
            ]
        );

        return redirect()->route('admin.dashboard')->with('success', 'Student updated successfully.');
    }

    public function destroy($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Student deleted successfully.');
    }

    public function showCompleteRegistration()
    {
        // Prevent users who already have a student record from accessing this page
        if (auth()->user()->student) {
            return redirect()->route('dashboard');
        }
        return view('auth.complete-registration');
    }

    public function storeCompleteRegistration(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'cne' => 'required|string|unique:students',
            'sector' => 'required|string',
            'city' => 'required|string',
        ]);

        \App\Models\Student::create([
            'user_id' => auth()->id(),
            'cne' => $request->cne,
            'sector' => $request->sector,
            'city' => $request->city,
        ]);

        return redirect()->route('student.dashboard');
    }
}
