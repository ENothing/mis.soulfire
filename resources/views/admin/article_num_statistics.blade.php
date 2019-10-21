<canvas id="article_num_chart" width="400" height="400"></canvas>
<script>
    $(function () {
        var ctx = document.getElementById("article_num_chart").getContext('2d');
        var article_num_chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: JSON.parse('{!! $time !!}'),
                datasets: [{
                    label: '文章数量',
                    data: JSON.parse('{!! $count !!}'),
                    backgroundColor: 'rgba(255,113,159,100)',
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