  Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    // Pie Chart Example

	<?php 
if(isset($chart)){
    foreach ($chart as $data) {
        $totalantri[] = $data['totalantri'];
        $totalproses[] = $data['totalproses'];
        $totalterlewat[] = $data['totalterlewat'];
        $totalselesai[] = $data['totalselesai'];
    }
} ?>
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Dalam Antrian", "Dalam Proses", "Antrian Terlewat", "Selesai"],
            datasets: [{
                data: [<?php echo json_encode($totalantri), <?php echo json_encode($totalproses); ?>, <?php echo json_encode($totalterlewat); ?>, <?php echo json_encode($totalselesai); ?>],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });