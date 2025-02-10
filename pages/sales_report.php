<?php
session_start();
require '../function/config.php'; // Include your database configuration file

// Set default filter to 'weekly'
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'weekly';

// Fetch data based on filter
switch ($filter) {
    case 'weekly':
        $interval = '1 WEEK';
        break;
    case 'monthly':
        $interval = '1 MONTH';
        break;
    case 'yearly':
        $interval = '1 YEAR';
        break;
    default:
        $interval = '1 WEEK';
        break;
}

$seller_id = $_SESSION['id'];

// Fetch orders data
$query = "SELECT DATE(ordered_at) as date, COUNT(*) as total_orders, 
                 SUM(CASE WHEN status = 'Delivered' THEN 1 ELSE 0 END) as successful_orders 
          FROM orders 
          WHERE seller_id = ? AND ordered_at >= NOW() - INTERVAL $interval 
          GROUP BY DATE(ordered_at)";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $seller_id);
$stmt->execute();
$result = $stmt->get_result();

$dates = [];
$total_orders = [];
$successful_orders = [];

while ($row = $result->fetch_assoc()) {
    $dates[] = $row['date'];
    $total_orders[] = $row['total_orders'];
    $successful_orders[] = $row['successful_orders'];
}
?>

<?php include 'header.php'; ?>

<!-- Custom CSS -->
<style>
    .filter-buttons {
        margin-bottom: 20px;
    }
    .filter-buttons .btn {
        margin-right: 10px;
    }
</style>

<div class="container">
    <h2 class="welcome-title">Sales Report</h2>
    <div class="filter-buttons">
        <a href="sales_report.php?filter=weekly" class="btn btn-primary">Weekly</a>
        <a href="sales_report.php?filter=monthly" class="btn btn-primary">Monthly</a>
        <a href="sales_report.php?filter=yearly" class="btn btn-primary">Yearly</a>
    </div>
    <canvas id="salesChart"></canvas>
</div>

<!-- Chart.js and date-fns adapter -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
<script>
    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($dates); ?>,
            datasets: [
                {
                    label: 'Total Orders',
                    data: <?php echo json_encode($total_orders); ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                },
                {
                    label: 'Successful Orders',
                    data: <?php echo json_encode($successful_orders); ?>,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    fill: false
                }
            ]
        },
        options: {
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: '<?php echo $filter === 'yearly' ? 'month' : 'day'; ?>'
                    }
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php include 'footer.php'; ?>