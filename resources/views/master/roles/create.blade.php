@extends('layout')

@section('title', 'Create Role')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">Create Role</h5>
                </div>
                <div class="card-body">
                  <form action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                      <label class="form-label" for="role_name">Role Name</label>
                      <input 
                      type="text" 
                      name="role_name"
                      class="form-control" 
                      id="role_name" 
                      placeholder="nama role"/>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="role_description">Description</label>
                      <textarea
                        id="role_description"
                        name="role_description"
                        class="form-control"
                        placeholder="deskripsi role"
                      ></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Role</button>
                  </form>
                </div>
              </div>
        </div>
    </div>
@endsection
