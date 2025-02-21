@extends('layout')

@section('title', 'Task List')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="card-body">
                        <div class="">
                            <h5 class="">List Task</h5>
                        </div>
                        @if (!empty($notifications))
                            <div class="alert alert-warning">
                                <ul>
                                    @foreach ($notifications as $notification)
                                        <li>{{ $notification }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nomor</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Tenggat</th>
                                        <th scope="col">Waktu</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Proyek</th>
                                        <th scope="col">Proses</th>
                                        <th scope="col" class="d-flex justify-content-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_task as $index => $task)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($task->created_at)->format('d-m-Y') }}</td>
                                            <td>{{ $task->task_name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($task->due_date)->format('d-m-Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($task->end_time)->format('H:i') }}</td>
                                            <td>{{ $task->status }}</td>
                                            <td>
                                                @forelse ($task->proyek as $proyek)
                                                    {{ $proyek->proyek_name }}
                                                @empty
                                                    No proyek assigned
                                                @endforelse
                                            </td>
                                            <td>{{$task->proses}}</td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <button type="submit" class="btn btn-info me-2">
                                                        <a href="{{ route('task.show', $task->task_id) }}"
                                                            style="color: white;">Edit</a>
                                                    </button>
                                                    <button type="button" class="btn btn-danger deactivate-account"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $task->task_id }}">
                                                        Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Modal --}}
                                        <div class="modal fade" id="deleteModal{{ $task->task_id }}" tabindex="-1"
                                            aria-labelledby="deleteModalLabel{{ $task->task_id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $task->task_id }}">
                                                            Confirm Deletion</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah kamu mau menghapus task
                                                        <strong>{{ $task->task_name }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('task.delete', $task->task_id) }}"
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
                        <a href="{{ route('task.create') }}" style="color: white;">Tambah Task</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
