<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GuardianController extends Controller
{
    protected FirebaseService $firebaseService;
    private string $guardiansCollection = 'guardians';
    private string $studentsCollection = 'students';

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guardians = $this->firebaseService->getCollection($this->guardiansCollection);
        return view('guardians.index', compact('guardians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // We pass all students to the view to be selected.
        $students = $this->firebaseService->getCollection($this->studentsCollection);
        return view('guardians.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:25',
            'address' => 'required|string',
            'student_ids' => 'nullable|array',
        ]);

        try {
            // Create the guardian document
            $guardianData = [
                'name' => $validated['name'],
                'phone_number' => $validated['phone_number'],
                'address' => $validated['address'],
                'created_at' => now()->toIso8601String(),
                'updated_at' => now()->toIso8601String(),
            ];
            $guardianId = $this->firebaseService->addDocument($this->guardiansCollection, $guardianData);

            // Update the selected students to link them to this guardian
            if (!empty($validated['student_ids'])) {
                foreach ($validated['student_ids'] as $studentId) {
                    $this->firebaseService->updateDocument($this->studentsCollection, $studentId, ['guardian_id' => $guardianId]);
                }
            }

            return redirect()->route('guardians.index')->with('success', 'Data wali santri berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Guardian Store Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan data.')->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $guardian = $this->firebaseService->getDocument($this->guardiansCollection, $id);
        if (!$guardian) {
            return redirect()->route('guardians.index')->with('error', 'Wali santri tidak ditemukan.');
        }

        // Get all students and check which ones are linked to this guardian
        $allStudents = $this->firebaseService->getCollection($this->studentsCollection);
        $linkedStudentIds = [];
        foreach ($allStudents as $student) {
            if (isset($student['guardian_id']) && $student['guardian_id'] === $id) {
                $linkedStudentIds[] = $student['id'];
            }
        }
        
        return view('guardians.edit', compact('guardian', 'allStudents', 'linkedStudentIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
            'student_ids' => 'nullable|array',
        ]);

        try {
            // Update the guardian document
            $guardianData = [
                'name' => $validated['name'],
                'phone_number' => $validated['phone_number'],
                'address' => $validated['address'],
                'updated_at' => now()->toIso8601String(),
            ];
            $this->firebaseService->updateDocument($this->guardiansCollection, $id, $guardianData);
            
            // To manage student relationships, we need to know the old links
            // This simple approach iterates through all students. For larger datasets, this would need optimization.
            $allStudents = $this->firebaseService->getCollection($this->studentsCollection);
            $newStudentIds = $validated['student_ids'] ?? [];

            foreach ($allStudents as $student) {
                $isLinked = isset($student['guardian_id']) && $student['guardian_id'] === $id;
                $shouldBeLinked = in_array($student['id'], $newStudentIds);

                // Detach: Was linked, but shouldn't be anymore
                if ($isLinked && !$shouldBeLinked) {
                    $this->firebaseService->updateDocument($this->studentsCollection, $student['id'], ['guardian_id' => null]);
                }
                // Attach: Wasn't linked, but should be now
                if (!$isLinked && $shouldBeLinked) {
                    $this->firebaseService->updateDocument($this->studentsCollection, $student['id'], ['guardian_id' => $id]);
                }
            }

            return redirect()->route('guardians.index')->with('success', 'Data wali santri berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Guardian Update Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui data.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // First, detach any students linked to this guardian
            $allStudents = $this->firebaseService->getCollection($this->studentsCollection);
            foreach ($allStudents as $student) {
                if (isset($student['guardian_id']) && $student['guardian_id'] === $id) {
                    $this->firebaseService->updateDocument($this->studentsCollection, $student['id'], ['guardian_id' => null]);
                }
            }

            // Now, delete the guardian document
            $this->firebaseService->deleteDocument($this->guardiansCollection, $id);

            return redirect()->route('guardians.index')->with('success', 'Data wali santri berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Guardian Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus data.');
        }
    }
}
