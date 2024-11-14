@extends('layout')

@section('title', 'Dashboard')

@section('content')

    <div>
        <canvas id="myChart">
        </canvas>
    </div>

    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Completed', 'In Progress', 'Hold'],
                datasets: [{
                    label: 'Task',
                    data: [<?=$completed?>, <?=$progres?>, <?=$hold?>],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

@endsection
