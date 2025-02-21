@extends('layout')

@section('title', 'Roles List')


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="card-body">
                        <div class="">
                            <h5 class="">List Role</h5>
                        </div>
                        <div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Description</th>
                                        <th scope="col" class="d-flex justify-content-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['data'] as $index => $role)
                                        <tr>
                                            <td>{{ ($data['data']->currentPage() - 1) * $data['data']->perPage() + $index + 1 }}
                                            </td>
                                            <td>{{ $role->role_name }}</td>
                                            <td>{{ $role->role_description }}</td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <button type="submit" class="btn btn-info me-2">
                                                        <a href="{{ route('roles.show', $role->role_id) }}"
                                                            style="color: white;">Edit</a>
                                                    </button>
                                                    <button type="button" class="btn btn-danger deactivate-account"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $role->role_id }}">
                                                        Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Modal --}}
                                        <div class="modal fade" id="deleteModal{{ $role->role_id }}" tabindex="-1"
                                            aria-labelledby="deleteModalLabel{{ $role->role_id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $role->role_id }}">
                                                            Confirm Deletion</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah kamu mau menghapus role <strong>{{ $role->role_name }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('roles.delete', $role->role_id) }}"
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
                        <a href="{{ route('roles.create') }}" style="color: white;">Tambah Role</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
