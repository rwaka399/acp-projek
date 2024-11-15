<style>
    .clock {
        font-family: 'Arial', sans-serif;
        font-size: 48px;
        display: flex;
        font-weight: bold;
        color: black;
        justify-content: end;
        margin-right: 20px;
    }
</style>


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
                    data: [<?= $completed ?>, <?= $progres ?>, <?= $hold ?>],
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


    <div class="clock" id="clock">
    </div>


    <script>
        // Fungsi untuk memperbarui jam
        function updateClock() {
            const clockElement = document.getElementById('clock');
            const currentTime = new Date();

            // Format waktu dalam format HH:MM:SS
            const hours = String(currentTime.getHours()).padStart(2, '0');
            const minutes = String(currentTime.getMinutes()).padStart(2, '0');
            const seconds = String(currentTime.getSeconds()).padStart(2, '0');

            const timeString = `${hours}:${minutes}:${seconds}`;

            // Menampilkan waktu pada elemen dengan id "clock"
            clockElement.textContent = timeString;
        }

        // Memperbarui jam setiap detik
        setInterval(updateClock, 1000);

        // Inisialisasi jam saat halaman pertama kali dimuat
        updateClock();
    </script>

@endsection
