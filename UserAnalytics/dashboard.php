<?php
// Add these at the very top to show errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Test the connection and data
require_once 'Analytics.php';

try {
    $analytics = new Analytics();
    
    // Get the totals
    $totalUsers = $analytics->getTotalUsers();
    $totalOrders = $analytics->getTotalOrders();
    $totalRevenue = $analytics->getTotalRevenue();
    
    $userStats = $analytics->getUserStats();
    $orderStats = $analytics->getOrderStats();
    $popularItems = $analytics->getPopularItems();
    $revenueStats = $analytics->getRevenueByDay();
    $categoryStats = $analytics->getProductCategories();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Add basic CSS to make sure styles are loading -->
    <style>
        /* Modern color scheme and base styles */
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --background-color: #ecf0f1;
            --card-color: #ffffff;
            --text-color: #2c3e50;
            --success-color: #2ecc71;
            --warning-color: #f1c40f;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        /* Header Styling */
        .dashboard-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .dashboard-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 500;
        }

        /* Main Container */
        .dashboard-container {
            padding: 20px;
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 25px;
        }

        /* Chart Containers */
        .chart-container {
            background: var(--card-color);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.07);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .chart-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }

        /* Chart Headers */
        .chart-container h2 {
            color: var(--primary-color);
            font-size: 18px;
            margin-top: 0;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--background-color);
        }

        /* Stats Cards */
        .stats-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
            padding: 0 20px;
        }

        .stat-card {
            background: var(--card-color);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.07);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-value {
            font-size: 28px;
            font-weight: bold;
            color: var(--accent-color);
            margin-bottom: 8px;
        }

        .stat-label {
            color: var(--secondary-color);
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-container {
                grid-template-columns: 1fr;
                padding: 15px;
            }

            .stats-overview {
                grid-template-columns: repeat(2, 1fr);
            }

            .chart-container {
                padding: 15px;
            }
        }

        /* Loading States */
        .loading {
            position: relative;
            opacity: 0.7;
        }

        .loading::after {
            content: "Loading...";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 14px;
            color: var(--accent-color);
        }

        /* Error Messages */
        .error-message {
            color: #e74c3c;
            text-align: center;
            padding: 20px;
            background: #fdf0ed;
            border-radius: 8px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="dashboard-header">
        <h1>User Analytics</h1>
    </div>

    <div class="stats-overview">
        <div class="stat-card">
            <div class="stat-value"><?php echo number_format($totalUsers); ?></div>
            <div class="stat-label">Total Users</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?php echo number_format($totalOrders); ?></div>
            <div class="stat-label">Total Orders</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">Ksh <?php echo number_format($totalRevenue); ?></div>
            <div class="stat-label">Total Revenue</div>
        </div>
    </div>

    <div class="dashboard-container">
        <div class="chart-container">
            <h2>User Distribution</h2>
            <canvas id="userChart"></canvas>
        </div>
        
        <div class="chart-container">
            <h2>Popular Items</h2>
            <canvas id="itemsChart"></canvas>
        </div>

        <div class="chart-container">
            <h2>Revenue Last 7 Days</h2>
            <canvas id="revenueChart"></canvas>
        </div>

        <div class="chart-container">
            <h2>Product Categories</h2>
            <canvas id="categoryChart"></canvas>
        </div>
    </div>

    <!-- Add console debug -->
    <script>
        console.log('JavaScript is running');
        
        // Debug data
        const userData = <?php echo json_encode($userStats ?? []); ?>;
        console.log('User Data:', userData);
        
        if (userData && userData.length > 0) {
            console.log('Creating chart...');
            const ctx = document.getElementById('userChart');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: userData.map(item => item.role),
                    datasets: [{
                        data: userData.map(item => item.total_users),
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'User Distribution by Role'
                    }
                }
            });
        } else {
            console.log('No user data available');
            document.querySelector('.chart-container').innerHTML += '<p>No data available</p>';
        }

        // Popular Items Chart
        const itemsCtx = document.getElementById('itemsChart');
        new Chart(itemsCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($popularItems, 'name')); ?>,
                datasets: [{
                    label: 'Orders',
                    data: <?php echo json_encode(array_column($popularItems, 'order_count')); ?>,
                    backgroundColor: '#36A2EB'
                }]
            }
        });

        // Revenue Chart
        const revenueData = <?php echo json_encode($revenueStats ?? []); ?>;
        if (revenueData && revenueData.length > 0) {
            new Chart(document.getElementById('revenueChart'), {
                type: 'line',
                data: {
                    labels: revenueData.map(item => item.date),
                    datasets: [{
                        label: 'Daily Revenue',
                        data: revenueData.map(item => item.daily_revenue),
                        borderColor: '#4CAF50',
                        fill: false
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
        } else {
            document.getElementById('revenueChart').insertAdjacentHTML('beforebegin', 
                '<p style="color: red;">No revenue data available for the last 7 days</p>');
        }

        // Category Chart
        const categoryData = <?php echo json_encode($categoryStats ?? []); ?>;
        if (categoryData && categoryData.length > 0) {
            new Chart(document.getElementById('categoryChart'), {
                type: 'doughnut',
                data: {
                    labels: categoryData.map(item => item.category),
                    datasets: [{
                        data: categoryData.map(item => item.product_count),
                        backgroundColor: [
                            '#FF6384',
                            '#36A2EB',
                            '#FFCE56',
                            '#4BC0C0',
                            '#9966FF'
                        ]
                    }]
                }
            });
        } else {
            document.getElementById('categoryChart').insertAdjacentHTML('beforebegin', 
                '<p style="color: red;">No category data available</p>');
        }
    </script>
</body>
</html>