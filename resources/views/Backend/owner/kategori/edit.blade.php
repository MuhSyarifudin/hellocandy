@extends('Backend.main')

@section('title', 'Edit Kategori')
@section('page', 'Edit Kategori')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Edit Kategori</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 border p-3 rounded">
                        <label for="category_name" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control border" id="category_name" name="category_name"
                            value="{{ old('category_name', $category->category_name) }}" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection