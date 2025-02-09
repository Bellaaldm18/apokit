<script>
    document.addEventListener('DOMContentLoaded', function () {

        var ctx = document.getElementById('weeklyRevenueChart').getContext('2d');
        var daysOfWeek = @json($daysOfWeek);
        var revenueData = @json($revenueData);
        ctx.canvas.width = 350;
        ctx.canvas.height = 100;

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: daysOfWeek,
                datasets: [{
                    label: 'Pendapatan Per Hari',
                    data: revenueData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                    pointBorderColor: 'rgba(75, 192, 192, 1)',
                    pointBorderWidth: 1,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    pointStyle: 'rect',
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'category',
                        labels: {!! json_encode(array_map(function($day) { return \Carbon\Carbon::parse($day)->format('d-m-Y'); }, $daysOfWeek)) !!},
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    });

</script>
