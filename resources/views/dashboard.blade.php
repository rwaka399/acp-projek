@extends('layout')

@section('title', 'Dashboard')

@section('content')
    <div>
        <canvas id="myChart" width="500" height="500"></canvas>
    </div>

    <script>
        // Ambil data dari Laravel
        const completed = {{ $count['completed'] }};
        const progress = {{ $count['progress'] }};
        const hold = {{ $count['hold'] }};
    
        const ctx = document.getElementById('myChart').getContext('2d');
        const taskChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'In Progress', 'Hold'],
                datasets: [{
                    data: [completed, progress, hold],
                    backgroundColor: ['#4caf50', '#ff9800', '#f44336']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                // Mengurangi margin chart agar lebih compact
                layout: {
                    padding: 20
                },
                
                // Memastikan chart lebih kecil
                maintainAspectRatio: false
            }
        });
    </script>
@endsection
