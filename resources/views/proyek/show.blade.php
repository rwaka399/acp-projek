@extends('layout')

@section('title', 'Edit Proyek')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">Edit Proyek</h5>
                </div>
                <div class="card-body">
                  <form action="{{ route('proyek.update', $data->proyek_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                      <label class="form-label" for="proyek_name">Proyek Name</label>
                      <input 
                      type="text" 
                      name="proyek_name"
                      class="form-control" 
                      id="proyek_name"
                      placeholder="nama proyek"
                      value="{{ $data->proyek_name }}"/>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="proyek_description">Proyek Description</label>
                      <textarea
                        id="proyek_description"
                        name="proyek_description"
                        class="form-control"
                        placeholder="deskripsi proyek"
                      >{{ $data->proyek_description }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Proyek</button>
                  </form>
                </div>
              </div>
        </div>
    </div>
@endsection
