<canvas id="activity_order_chart" width="400" height="400"></canvas>
<script>
    $(function () {
        var ctx = document.getElementById("activity_order_chart").getContext('2d');
        var activity_order_chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: JSON.parse('{!! $ao_time !!}'),
                datasets: [{
                    label: '消费金额',
                    data: JSON.parse('{!! $ao_price !!}'),
                    backgroundColor: 'rgba(102, 164, 255,100)',
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    });
</script>