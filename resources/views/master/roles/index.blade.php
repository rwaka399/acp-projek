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
                                                        <a href="{{ route('roles.show', $role->role_id) }}" style="color: white;">Edit</a>
                                                    </button>
                                                    <form action="{{ route('roles.delete', $role->role_id) }}" method="POST">
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
                        <a href="{{ route('roles.create') }}" style="color: white;">Tambah Role</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
