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
                                                    <form action="{{ route('users.delete', $users->user_id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger deactivate-account">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
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
