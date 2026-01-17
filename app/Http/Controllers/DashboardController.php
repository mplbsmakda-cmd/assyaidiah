<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Guardian;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $studentCount = Student::count();
        $guardianCount = Guardian::count();
        $activeStudents = Student::where('status', 'aktif')->count();
        $inactiveStudents = Student::where('status', 'tidak aktif')->count();
        $graduatedStudents = Student::where('status', 'lulus')->count();
        $latestStudents = Student::latest()->take(5)->get();

        return view('dashboard', compact(
            'studentCount',
            'guardianCount',
            'activeStudents',
            'inactiveStudents',
            'graduatedStudents',
            'latestStudents'
        ));
    }
}
