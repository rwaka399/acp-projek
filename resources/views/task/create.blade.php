@extends('layout')

@section('title', 'Create Role')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create Task</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('task.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="task_name" class="form-label">Task Name</label>
                            <input type="text" class="form-control" id="task_name"
                                name="task_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="Hold">Hold</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="priority" class="form-label">Prioritas</label>
                            <select class="form-select" id="status" name="priority" required>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="due_date"
                                name="due_date" required>
                        </div>
                        <div class="mb-3">  
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="time" class="form-control" id="end_time"
                                name="end_time" required>
                        </div>
                        <div class="mb-3">
                            <label for="proyek" class="form-label">Proyek</label>
                            <select class="form-select" id="proyek" name="proyek" required>
                                <option value="" selected disabled>Pilih Proyek</option>
                                @foreach ($data_proyek as $proyek)
                                    <option value="{{ $proyek->proyek_id }}">
                                        {{ $proyek->proyek_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="proses">Proses (%)</label>
                                <input type="number" 
                                       name="proses" 
                                       id="proses" 
                                       class="form-control" 
                                       min="0" 
                                       max="100" 
                                        
                                       placeholder="Masukkan persen progress (0-100)">
                            </div>
                        </div>
                        
                    
                        
                        <button type="submit" class="btn btn-primary">Tambah Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
