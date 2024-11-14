@extends('layout')

@section('title', 'Create Role')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create User</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="masukkan namamu"
                                required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="masukkan username"
                                required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input type="text" name="password" class="form-control" placeholder="masukkan password" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="role">Pilih Role</label>
                            <div class="d-flex flex-wrap">
                                @foreach ($data as $role)
                                    <div class="form-check me-3 mb-2">
                                        <input type="checkbox" name="role[]" class="form-check-input"
                                            value="{{ $role->role_id }}" id="role_{{ $role->role_id }}">
                                        <label class="form-check-label" for="role_{{ $role->role_id }}">
                                            {{ $role->role_name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
