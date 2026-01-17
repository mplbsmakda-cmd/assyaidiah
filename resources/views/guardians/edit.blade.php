@extends('layouts.app')

@section('title', 'Edit Data Wali')

@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Data</a></li>
                <li class="breadcrumb-item"><a href="{{ route('guardians.index') }}">Wali Santri</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Edit Data</a></li>
            </ol>
        </div>
        <!-- row -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Data Wali</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('guardians.update', $guardian) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $guardian->name) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">No. Telepon</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $guardian->phone_number) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address', $guardian->address) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="students" class="form-label">Santri</label>
                                <select multiple class="form-control" id="students" name="student_ids[]">
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}" {{ in_array($student->id, $guardian->students->pluck('id')->toArray()) ? 'selected' : '' }}>
                                            {{ $student->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('guardians.index') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
