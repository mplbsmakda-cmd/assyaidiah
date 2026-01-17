<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected FirebaseService $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get all data from Firestore collections
        $allStudents = $this->firebaseService->getCollection('students');
        $allGuardians = $this->firebaseService->getCollection('guardians');

        $studentsCollection = collect($allStudents);

        // Perform counts on the collection
        $studentCount = $studentsCollection->count();
        $guardianCount = count($allGuardians);
        $activeStudents = $studentsCollection->where('status', 'aktif')->count();
        $inactiveStudents = $studentsCollection->where('status', 'tidak aktif')->count();
        $graduatedStudents = $studentsCollection->where('status', 'lulus')->count();

        // Sort students by creation date and take the latest 5
        $latestStudents = $studentsCollection->sortByDesc('created_at')->take(5)->values()->all();

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
