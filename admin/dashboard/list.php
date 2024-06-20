<?php
session_start();
include_once "../config/DBUntil.php";

$db = new DBUntil();
$order = $db->select("SELECT YEAR(created_at) as year, MONTH(created_at) as month, DAY(created_at) as day, SUM(quantity * price) AS total_revenue 
                      FROM order_details 
                      GROUP BY year, month, day");


$datajson = json_encode($order);

?>


<!DOCTYPE html>
<html>

<head>
     <title>Doanh thu</title>
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<style>
     #revenueChart {
          max-width: 100%;
          max-height: 90%;
     }
</style>

<body>
     <h2 class="mt-3" style="text-align: center">Thống kê doanh thu</h2>
     <canvas id="revenueChart"></canvas>
     <script>
          var data = <?php echo $datajson; ?>;

          // Tạo mảng nhãn và mảng doanh thu cho từng dòng data
          var labels = data.map(function(e) {
               return `${e.year}-${e.month}-${e.day}`;
          });

          var amountsByDay = data.map(function(e) {
               return e.total_revenue;
          });

          // Tạo mảng doanh thu theo tháng (tổng hợp doanh thu của tất cả ngày trong tháng)
          var amountsByMonth = [];
          var currentMonth = '';
          var sum = 0;

          data.forEach(function(e) {
               var month = `${e.year}-${e.month}`;
               if (month !== currentMonth) {
                    if (currentMonth !== '') {
                         amountsByMonth.push(sum);
                    }
                    currentMonth = month;
                    sum = 0;
               }
               sum += e.total_revenue;
          });

          // Đảm bảo thêm tổng doanh thu của tháng cuối cùng vào mảng
          if (currentMonth !== '') {
               amountsByMonth.push(sum);
          }

          var ctx = document.getElementById('revenueChart').getContext('2d');
          var revenueChart = new Chart(ctx, {
               type: 'bar',
               data: {
                    labels: labels,
                    datasets: [{
                         label: 'Doanh thu theo ngày',
                         data: amountsByDay,
                         fill: false,
                         borderColor: 'rgba(255, 99, 132, 1)',
                         backgroundColor: 'rgba(255, 99, 132, 0.2)',
                         borderWidth: 1
                    }, {
                         label: 'Doanh thu theo tháng',
                         data: amountsByMonth,
                         fill: false,
                         borderColor: 'rgba(54, 162, 235, 1)',
                         backgroundColor: 'rgba(54, 162, 235, 0.2)',
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
</body>

</html>
