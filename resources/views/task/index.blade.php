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
                                        <th scope="col">#</th>
                                        <th scope="col">Created at</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Due Date</th>
                                        <th scope="col">End Time</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Proyek</th>
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

                                            <td>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <button type="submit" class="btn btn-info me-2">
                                                        <a href="{{ route('task.show', $task->task_id) }}"
                                                            style="color: white;">Edit</a>
                                                    </button>
                                                    <form action="{{ route('task.delete', $task->task_id) }}"
                                                        method="POST">
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
                        <a href="{{ route('task.create') }}" style="color: white;">Tambah Proyek</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
