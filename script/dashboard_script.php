<?php
include 'config/db.php';

// Fetch sales data for the chart
$stmt = $pdo->query("SELECT 
                        DATE(transaction_date) as date, 
                        SUM(total) as total_sales 
                    FROM sales_transactions 
                    GROUP BY DATE(transaction_date)");
$sales_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$dates = [];
$sales = [];
foreach ($sales_data as $data) {
    $dates[] = $data['date'];
    $sales[] = $data['total_sales'];
}

// Fetch top-selling products
$stmt = $pdo->query("SELECT 
                        p.name as product_name, 
                        SUM(st.quantity) as total_quantity 
                    FROM sales_transactions st 
                    JOIN products p ON st.product_id = p.id 
                    GROUP BY st.product_id 
                    ORDER BY total_quantity DESC 
                    LIMIT 5"); // Top 5 products
$top_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
$product_names = [];
$product_quantities = [];
foreach ($top_products as $product) {
    $product_names[] = $product['product_name'];
    $product_quantities[] = $product['total_quantity'];
}


?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line', // You can change this to 'bar', 'pie', etc.
        data: {
            labels: <?php echo json_encode($dates); ?>,
            datasets: [{
                label: 'Total Sales',
                data: <?php echo json_encode($sales); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                fill: true
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: true
                },
                tooltip: {
                    enabled: true
                }
            }
        }
    });

    const ctxTopProducts = document.getElementById('topProductsChart').getContext('2d');
    const topProductsChart = new Chart(ctxTopProducts, {
        type: 'pie', // Change to 'pie' for a pie chart
        data: {
            labels: <?php echo json_encode($product_names); ?>,
            datasets: [{
                label: 'Total Quantity Sold',
                data: <?php echo json_encode($product_quantities); ?>,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: true
                },
                tooltip: {
                    enabled: true
                }
            }
        }
    });

</script>
