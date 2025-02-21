@extends('layout')

@section('title', 'Users List')


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="card-body">
                        <div class="">
                            <h5 class="">List Users</h5>
                        </div>
                        <div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Roles</th>
                                        <th scope="col" class="d-flex justify-content-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $users)
                                        <tr>
                                            <td>{{ ($index + 1) }}
                                            </td>
                                            <td>{{ $users->name }}</td>
                                            <td>{{ $users->username }}</td>
                                            <td>
                                                @foreach ($users->userRole as $userRole)
                                                    {{ $userRole->role->role_name }}
                                                @endforeach
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <button type="submit" class="btn btn-info me-2">
                                                        <a href="{{ route('users.show', $users->user_id) }}" style="color: white;">Edit</a>
                                                    </button>
                                                    <button type="button" class="btn btn-danger deactivate-account"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $users->user_id }}">
                                                        Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Modal --}}
                                        <div class="modal fade" id="deleteModal{{ $users->user_id }}" tabindex="-1"
                                            aria-labelledby="deleteModalLabel{{ $users->user_id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $users->user_id }}">
                                                            Confirm Deletion</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah kamu mau menghapus users <strong>{{ $users->users_name }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('users.delete', $users->user_id) }}"
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
                        <a href="{{ route('users.create')}}" style="color: white;">Tambah User</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
