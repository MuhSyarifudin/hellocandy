@extends('Backend.main')

@section('title', 'Edit Pengguna')
@section('page', 'Edit Pengguna')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Edit Pengguna</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 border p-3 rounded">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control border" id="username" name="username"
                            value="{{ old('username', $user->username) }}" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="password" class="form-label">Kata Sandi (Kosongkan jika tidak ingin
                            mengubah)</label>
                        <input type="password" class="form-control border" id="password" name="password">
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="role" class="form-label">Peran</label>
                        <select class="form-control border" id="role" name="role" required>
                            <option value="kasir" {{ $user->role === 'kasir' ? 'selected' : '' }}>Kasir</option>
                            <option value="owner" {{ $user->role === 'owner' ? 'selected' : '' }}>Owner</option>
                        </select>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control border" id="nama" name="nama"
                            value="{{ old('nama', $user->nama) }}" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="email" class="form-label">Email (Opsional)</label>
                        <input type="email" class="form-control border" id="email" name="email"
                            value="{{ old('email', $user->email) }}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection