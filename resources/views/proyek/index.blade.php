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
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Descirption</th>
                                        <th scope="col" class="d-flex justify-content-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $proyeks)
                                        <tr>
                                            <td>{{ ($index + 1) }}
                                            </td>
                                            <td>{{ $proyeks->proyek_name }}</td>
                                            <td>{{ $proyeks->proyek_description }}</td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <button type="submit" class="btn btn-info me-2">
                                                        <a href="{{ route('proyek.show', $proyeks->proyek_id) }}" style="color: white;">Edit</a>
                                                    </button>
                                                    <form action="{{ route('proyek.delete', $proyeks->proyek_id) }}" method="POST">
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
                        <a href="{{ route('proyek.create')}}" style="color: white;">Tambah Proyek</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
