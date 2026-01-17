<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Guardian;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function index(Request $request)
    {
        $query = Student::with('guardian')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->where('status', $status);
        }

        $students = $query->paginate(10);

        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:students|max:20',
            'name' => 'required|max:255',
            'birth_date' => 'required|date',
            'address' => 'required',
            'status' => 'required|in:aktif,tidak aktif,lulus',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'guardian_name' => 'required|max:255',
            'guardian_phone_number' => 'required|max:20',
            'guardian_address' => 'required',
        ]);

        DB::transaction(function () use ($request) {
            $guardian = Guardian::create([
                'name' => $request->guardian_name,
                'phone_number' => $request->guardian_phone_number,
                'address' => $request->guardian_address,
            ]);

            $studentData = $request->only('nis', 'name', 'birth_date', 'address', 'status');
            $studentData['guardian_id'] = $guardian->id;

            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $photoPath = 'students/' . time() . '-' . $photo->getClientOriginalName();
                $photoUrl = $this->firebaseService->upload($photo, $photoPath);
                $studentData['photo_url'] = $photoUrl;
            }

            Student::create($studentData);
        });

        return redirect()->route('students.index')->with('success', 'Data santri berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $student = Student::with('guardian')->findOrFail($id);
        return view('students.show', compact('student'));
    }

    public function edit(string $id)
    {
        $student = Student::with('guardian')->findOrFail($id);
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nis' => 'required|max:20|unique:students,nis,' . $id,
            'name' => 'required|max:255',
            'birth_date' => 'required|date',
            'address' => 'required',
            'status' => 'required|in:aktif,tidak aktif,lulus',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'guardian_name' => 'required|max:255',
            'guardian_phone_number' => 'required|max:20',
            'guardian_address' => 'required',
        ]);

        $student = Student::findOrFail($id);

        DB::transaction(function () use ($request, $student) {
            $studentData = $request->only('nis', 'name', 'birth_date', 'address', 'status');

            if ($request->hasFile('photo')) {
                if ($student->photo_url) {
                    $this->firebaseService->delete($student->photo_url);
                }

                $photo = $request->file('photo');
                $photoPath = 'students/' . time() . '-' . $photo->getClientOriginalName();
                $photoUrl = $this->firebaseService->upload($photo, $photoPath);
                $studentData['photo_url'] = $photoUrl;
            }

            $student->update($studentData);

            $student->guardian->update([
                'name' => $request->guardian_name,
                'phone_number' => $request->guardian_phone_number,
                'address' => $request->guardian_address,
            ]);
        });

        return redirect()->route('students.index')->with('success', 'Data santri berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        
        DB::transaction(function () use ($student) {
            if ($student->photo_url) {
                $this->firebaseService->delete($student->photo_url);
            }

            $student->guardian()->delete();
            $student->delete();
        });

        return redirect()->route('students.index')->with('success', 'Data santri berhasil dihapus.');
    }

    // Public Registration Methods
    public function createPublic()
    {
        return view('students.register');
    }

    public function storePublic(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'birth_date' => 'required|date',
            'address' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'guardian_name' => 'required|max:255',
            'guardian_phone_number' => 'required|max:20',
            'guardian_address' => 'required',
        ]);

        DB::transaction(function () use ($request) {
            $guardian = Guardian::firstOrCreate(
                ['phone_number' => $request->guardian_phone_number],
                [
                    'name' => $request->guardian_name,
                    'address' => $request->guardian_address,
                ]
            );

            $studentData = $request->only('name', 'birth_date', 'address');
            $studentData['nis'] = 'S' . date('Ym') . strtoupper(substr(uniqid(), -5));
            $studentData['status'] = 'aktif';
            $studentData['guardian_id'] = $guardian->id;

            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $photoPath = 'students/' . time() . '-' . $photo->getClientOriginalName();
                $photoUrl = $this->firebaseService->upload($photo, $photoPath);
                $studentData['photo_url'] = $photoUrl;
            }

            Student::create($studentData);
        });

        return redirect()->route('home')->with('success', 'Pendaftaran berhasil! Silakan tunggu konfirmasi dari admin.');
    }
}
