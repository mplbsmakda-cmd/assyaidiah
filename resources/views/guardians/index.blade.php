@extends('layouts.app')

@section('title', 'Data Wali Santri')

@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Data</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Wali Santri</a></li>
            </ol>
        </div>
        <!-- row -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Wali Santri</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-4">
                            <a href="{{ route('guardians.create') }}" class="btn btn-primary">Tambah Data</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">                                
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>No. Telepon</th>
                                        <th>Alamat</th>
                                        <th>Santri</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($guardians as $guardian)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $guardian->name }}</td>
                                            <td>{{ $guardian->phone_number }}</td>
                                            <td>{{ $guardian->address }}</td>
                                            <td>
                                                @foreach ($guardian->students as $student)
                                                    <span class="badge bg-primary">{{ $student->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('guardians.edit', $guardian) }}" class="btn btn-warning shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                                    <form action="{{ route('guardians.destroy', $guardian) }}" method="POST" class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $guardians->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush
