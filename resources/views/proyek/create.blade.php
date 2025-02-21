@extends('layout')

@section('title', 'Create Proyek')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">Create Proyek</h5>
                </div>
                <div class="card-body">
                  <form action="{{ route('proyek.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                      <label class="form-label" for="proyek_name">Proyek Name</label>
                      <input 
                      type="text" 
                      name="proyek_name"
                      class="form-control" 
                      id="proyek_name" 
                      placeholder="nama proyek"/>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="proyek_description">Proyek Descirption</label>
                      <textarea
                        id="proyek_description"
                        name="proyek_description"
                        class="form-control"
                        placeholder="deskripsi proyek"
                      ></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Proyek</button>
                  </form>
                </div>
              </div>
        </div>
    </div>
@endsection
