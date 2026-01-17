<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuardianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guardians = Guardian::with('students')->latest()->paginate(10);
        return view('guardians.index', compact('guardians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
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
            'student_ids.*' => 'exists:students,id',
        ]);

        try {
            DB::beginTransaction();

            $guardian = Guardian::create($validated);

            if (!empty($validated['student_ids'])) {
                Student::whereIn('id', $validated['student_ids'])->update(['guardian_id' => $guardian->id]);
            }

            DB::commit();

            return redirect()->route('guardians.index')->with('success', 'Data wali santri berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guardian $guardian)
    {
        $students = Student::all();
        return view('guardians.edit', compact('guardian', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guardian $guardian)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
            'student_ids' => 'nullable|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        try {
            DB::beginTransaction();

            $guardian->update($validated);

            // Detach all students from this guardian first
            Student::where('guardian_id', $guardian->id)->update(['guardian_id' => null]);

            // Attach the new set of students
            if (!empty($validated['student_ids'])) {
                Student::whereIn('id', $validated['student_ids'])->update(['guardian_id' => $guardian->id]);
            }

            DB::commit();

            return redirect()->route('guardians.index')->with('success', 'Data wali santri berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guardian $guardian)
    {
        try {
            DB::beginTransaction();

            // Set guardian_id to null for associated students
            Student::where('guardian_id', $guardian->id)->update(['guardian_id' => null]);

            $guardian->delete();

            DB::commit();

            return redirect()->route('guardians.index')->with('success', 'Data wali santri berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
