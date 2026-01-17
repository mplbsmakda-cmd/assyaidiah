<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    protected FirebaseService $firebaseService;
    private string $studentsCollection = 'students';
    private string $guardiansCollection = 'guardians';

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function index(Request $request)
    {
        // Get all students and guardians
        $allStudents = $this->firebaseService->getCollection($this->studentsCollection);
        $allGuardians = $this->firebaseService->getCollection($this->guardiansCollection);
        $guardiansKeyedById = collect($allGuardians)->keyBy('id')->all();

        // Manually filter based on request
        $filteredStudents = collect($allStudents)->filter(function ($student) use ($request) {
            $search = strtolower($request->input('search', ''));
            $status = $request->input('status', '');

            $searchMatch = true;
            if ($search) {
                $searchMatch = Str::contains(strtolower($student['name']), $search) || Str::contains(strtolower($student['nis']), $search);
            }

            $statusMatch = true;
            if ($status) {
                $statusMatch = $student['status'] === $status;
            }

            return $searchMatch && $statusMatch;
        })->map(function ($student) use ($guardiansKeyedById) {
            // Manually attach guardian data
            if (isset($student['guardian_id']) && isset($guardiansKeyedById[$student['guardian_id']])) {
                $student['guardian'] = $guardiansKeyedById[$student['guardian_id']];
            }
            return $student;
        });

        // Basic manual pagination (can be improved with more complex logic)
        $students = collect($filteredStudents)->values()->all(); 

        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|max:20',
            'name' => 'required|max:255',
            'birth_date' => 'required|date',
            'address' => 'required',
            'status' => 'required|in:aktif,tidak aktif,lulus',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'guardian_name' => 'required|max:255',
            'guardian_phone_number' => 'required|max:20',
            'guardian_address' => 'required',
        ]);

        try {
            // Create guardian first
            $guardianId = $this->firebaseService->addDocument($this->guardiansCollection, [
                'name' => $validated['guardian_name'],
                'phone_number' => $validated['guardian_phone_number'],
                'address' => $validated['guardian_address'],
                'created_at' => now()->toIso8601String(),
            ]);

            $studentData = [
                'nis' => $validated['nis'],
                'name' => $validated['name'],
                'birth_date' => $validated['birth_date'],
                'address' => $validated['address'],
                'status' => $validated['status'],
                'guardian_id' => $guardianId,
                'created_at' => now()->toIso8601String(),
            ];

            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $photoPath = 'students/' . time() . '-' . $photo->getClientOriginalName();
                $studentData['photo_url'] = $this->firebaseService->upload($photo, $photoPath);
            }

            $this->firebaseService->addDocument($this->studentsCollection, $studentData);

            return redirect()->route('students.index')->with('success', 'Data santri berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error("Student Store Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan data santri.')->withInput();
        }
    }

    public function show(string $id)
    {
        $student = $this->firebaseService->getDocument($this->studentsCollection, $id);
        if (!$student) {
            return redirect()->route('students.index')->with('error', 'Santri tidak ditemukan.');
        }

        if (isset($student['guardian_id'])) {
            $student['guardian'] = $this->firebaseService->getDocument($this->guardiansCollection, $student['guardian_id']);
        }

        return view('students.show', compact('student'));
    }

    public function edit(string $id)
    {
        $student = $this->firebaseService->getDocument($this->studentsCollection, $id);
        if (!$student) {
            return redirect()->route('students.index')->with('error', 'Santri tidak ditemukan.');
        }

        if (isset($student['guardian_id'])) {
            $student['guardian'] = $this->firebaseService->getDocument($this->guardiansCollection, $student['guardian_id']);
        }

        return view('students.edit', compact('student'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nis' => 'required|max:20',
            'name' => 'required|max:255',
            'birth_date' => 'required|date',
            'address' => 'required',
            'status' => 'required|in:aktif,tidak aktif,lulus',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'guardian_name' => 'required|max:255',
            'guardian_phone_number' => 'required|max:20',
            'guardian_address' => 'required',
        ]);

        try {
            $student = $this->firebaseService->getDocument($this->studentsCollection, $id);
            if (!$student) {
                return redirect()->route('students.index')->with('error', 'Santri tidak ditemukan.');
            }

            $studentData = [
                'nis' => $validated['nis'],
                'name' => $validated['name'],
                'birth_date' => $validated['birth_date'],
                'address' => $validated['address'],
                'status' => $validated['status'],
                'updated_at' => now()->toIso8601String(),
            ];

            if ($request->hasFile('photo')) {
                if (!empty($student['photo_url'])) {
                    $this->firebaseService->delete($student['photo_url']);
                }
                $photo = $request->file('photo');
                $photoPath = 'students/' . time() . '-' . $photo->getClientOriginalName();
                $studentData['photo_url'] = $this->firebaseService->upload($photo, $photoPath);
            }

            $this->firebaseService->updateDocument($this->studentsCollection, $id, $studentData);

            if (isset($student['guardian_id'])) {
                $this->firebaseService->updateDocument($this->guardiansCollection, $student['guardian_id'], [
                    'name' => $validated['guardian_name'],
                    'phone_number' => $validated['guardian_phone_number'],
                    'address' => $validated['guardian_address'],
                    'updated_at' => now()->toIso8601String(),
                ]);
            }

            return redirect()->route('students.index')->with('success', 'Data santri berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error("Student Update Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui data santri.')->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $student = $this->firebaseService->getDocument($this->studentsCollection, $id);
            if (!$student) {
                return redirect()->route('students.index')->with('success', 'Data santri sudah dihapus.');
            }

            if (!empty($student['photo_url'])) {
                $this->firebaseService->delete($student['photo_url']);
            }

            $this->firebaseService->deleteDocument($this->studentsCollection, $id);
            
            // Optional: Check if the guardian has other students before deleting
            if (isset($student['guardian_id'])) {
                $otherStudents = $this->firebaseService->getCollection($this->studentsCollection);
                $isGuardianInUse = collect($otherStudents)->contains('guardian_id', $student['guardian_id']);
                if (!$isGuardianInUse) {
                    $this->firebaseService->deleteDocument($this->guardiansCollection, $student['guardian_id']);
                }
            }

            return redirect()->route('students.index')->with('success', 'Data santri berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error("Student Delete Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus data santri.');
        }
    }
    
    // Public Registration Methods
    public function createPublic()
    {
        return view('students.register');
    }

    public function storePublic(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'birth_date' => 'required|date',
            'address' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'guardian_name' => 'required|max:255',
            'guardian_phone_number' => 'required|max:20',
            'guardian_address' => 'required',
        ]);

        try {
            // Here we can decide to create a new guardian or find an existing one by phone number.
            // For simplicity, we create a new one, but finding existing is better practice.
            $guardianId = $this->firebaseService->addDocument($this->guardiansCollection, [
                'name' => $validated['guardian_name'],
                'phone_number' => $validated['guardian_phone_number'],
                'address' => $validated['guardian_address'],
                'created_at' => now()->toIso8601String(),
            ]);

            $studentData = [
                'nis' => 'S' . date('Ym') . strtoupper(substr(uniqid(), -5)), // Auto-generate NIS
                'name' => $validated['name'],
                'birth_date' => $validated['birth_date'],
                'address' => $validated['address'],
                'status' => 'aktif', // Default status for new public registration
                'guardian_id' => $guardianId,
                'created_at' => now()->toIso8601String(),
            ];

            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $photoPath = 'students/' . time() . '-' . $photo->getClientOriginalName();
                $studentData['photo_url'] = $this->firebaseService->upload($photo, $photoPath);
            }

            $this->firebaseService->addDocument($this->studentsCollection, $studentData);

            return redirect()->route('home')->with('success', 'Pendaftaran berhasil! Silakan tunggu konfirmasi dari admin.');

        } catch (\Exception $e) {
            Log::error("Public Registration Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat pendaftaran.')->withInput();
        }
    }
}
