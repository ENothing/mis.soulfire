<canvas id="member_num_chart" width="400" height="400"></canvas>
<script>
$(function () {
    var ctx = document.getElementById("member_num_chart").getContext('2d');
    var member_num_chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: JSON.parse('{!! $time !!}'),
            datasets: [{
                label: '用户数量',
                data: JSON.parse('{!! $count !!}'),
                backgroundColor: 'rgba(156,133,255,100)',
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