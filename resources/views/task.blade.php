<style>
    .fixed-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        /* Memastikan tombol berada di atas elemen lain */
    }

    .fixed-btn {
        position: fixed;
        bottom: 20px;
        right: 165px;
        z-index: 1000;
    }
</style>

@extends('layout')

@section('title', 'Proyek List')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-l   g-12 mb-4 order-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5>List Task</h5>

                    </div>
                    <div class="d-flex align-items-end">
                        <div class="me-2">
                            <label for="html5-date-input" class="col-form-label">Date</label>
                            <input class="form-control" type="date" value="2021-06-18" id="html5-date-input" />
                        </div>
                        <div class="me-2">
                            <label for="html5-date-input" class="col-form-label">Date</label>
                            <input class="form-control" type="date" value="2021-06-18" id="html5-date-input" />
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary mt-3">
                                <a href="" style="color: white;">Filter</a>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="container mt-3">
                    <div class="list-group mt-3">
                        {{-- @foreach ($data_proyek as $proyek)
                        <button type="button" class="list-group-item list-group-item-action" data-bs-toggle="modal"
                            data-bs-target="#taskModal">
                            <h6>{{ $proyek->proyek_name }}</h6>
                            <h5>
                                ss
                            </h5>
                            <p>sdsdksdj</p>
                        </button>
                        @endforeach --}}
                    </div>




                    <!-- Modal for Task Detail -->
                    {{-- @foreach ($tasks as $task) --}}
                    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="taskModalLabel">
                                        ss</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Description:</strong> </p>
                                    <p><strong>Created at:</strong></p>
                                    <p><strong>Status:</strong></p>
                                    <p><strong>Proyek:</strong></p>
                                    <p><strong>Due Date:</strong> </p>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">Progress:</span>
                                        <div class="progress w-100">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: %;"
                                                aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <a href="" class="btn btn-primary">Edit</a>
                                    <a href="" class="btn btn-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- @endforeach --}}


                    <div class="col-12 mb-3">
                        <div class="upgrade-to-pro">
                            <button type="button" class="btn btn-primary fixed-button" data-bs-toggle="modal"
                                data-bs-target="#taskModalCreate">
                                Tambah Task
                            </button>

                            <!-- Modal untuk Menambah/Edit Task -->
                            <div class="modal fade" id="taskModalCreate" tabindex="-1"
                                aria-labelledby="taskModalCreateLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="taskModalCreateLabel">Tambah Task</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Form Input Task -->
                                            <form method="POST" action="{{ route('task.store') }}">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="task_name" class="form-label">Task Name</label>
                                                    <input type="text" class="form-control" id="task_name"
                                                        name="task_name" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="task_description" class="form-label">Task
                                                        Description</label>
                                                    <textarea class="form-control" id="task_description" name="task_description" rows="3" required></textarea>
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
                                                    <label for="status" class="form-label">Status</label>
                                                    <select class="form-select" id="status" name="status" required>
                                                        <option value="Pending">Doing</option>
                                                        <option value="In Progress">Hold</option>
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
                                                    <label for="proses" class="form-label">Progress (%)</label>
                                                    <!-- Range Slider -->
                                                    <input type="range" class="form-range" id="proses"
                                                        name="proses" min="0" max="100" value="0"
                                                        oninput="updateProgressBar(this.value)" required>

                                                    <!-- Progress Bar -->
                                                    <div class="progress mt-2">
                                                        <div id="progressBar" class="progress-bar" role="progressbar"
                                                            style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                                                            aria-valuemax="100">0%</div>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Tambah Task</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Modal -->
                    </div>
                    <div class="">
                        <div class="upgrade-to-pro">
                            <button type="button" class="btn btn-primary fixed-btn">
                                Tambah On Progress
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
