@extends('layout')

@section('title', 'Proyek List')


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="card-body">
                        <div class="">
                            <h5 class="">List Proyek</h5>
                        </div>
                        <div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nomor</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Descirption</th>
                                        <th scope="col" class="d-flex justify-content-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $proyeks)
                                        <tr>
                                            <td>{{ $index + 1 }}
                                            </td>
                                            <td>{{ $proyeks->proyek_name }}</td>
                                            <td>{{ $proyeks->proyek_description }}</td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <button type="submit" class="btn btn-info me-2">
                                                        <a href="{{ route('proyek.show', $proyeks->proyek_id) }}"
                                                            style="color: white;">Edit</a>
                                                    </button>
                                                    <button type="button" class="btn btn-danger deactivate-account"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $proyeks->proyek_id }}">
                                                        Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Modal --}}
                                        <div class="modal fade" id="deleteModal{{ $proyeks->proyek_id }}" tabindex="-1"
                                            aria-labelledby="deleteModalLabel{{ $proyeks->proyek_id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $proyeks->proyek_id }}">
                                                            Confirm Deletion</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah kamu mau menghapus <strong>{{ $proyeks->proyek_name }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('proyek.delete', $proyeks->proyek_id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary mt-3">
                        <a href="{{ route('proyek.create') }}" style="color: white;">Tambah Proyek</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
