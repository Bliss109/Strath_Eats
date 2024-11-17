<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'Analytics.php';

try {
    $analytics = new Analytics();
    
    $totalUsers = $analytics->getTotalUsers();
    // Removed: $totalOrders = $analytics->getTotalOrders();
    // Removed: $totalRevenue = $analytics->getTotalRevenue();
    
    $userStats = $analytics->getUserStats();
    // Removed: $orderStats = $analytics->getOrderStats();
    // Removed: $popularItems = $analytics->getPopularItems();
    $revenueStats = $analytics->getRevenueByDay();
    // Removed: $categoryStats = $analytics->getProductCategories();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Analytics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
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

       
        .dashboard-container {
            padding: 20px;
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 25px;
        }

       
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

        
        .chart-container h2 {
            color: var(--primary-color);
            font-size: 18px;
            margin-top: 0;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--background-color);
        }

        
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

        .error-message {
            color: #e74c3c;
            text-align: center;
            padding: 20px;
            background: #fdf0ed;
            border-radius: 8px;
            margin: 10px 0;
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
        <!-- Removed: Total Orders stat card -->
        <!-- Removed: Total Revenue stat card -->
    </div>

    <div class="dashboard-container">
        <div class="chart-container">
            <h2>User Distribution</h2>
            <canvas id="userChart"></canvas>
        </div>
        
        <!-- Removed: Popular Items chart container -->

        <div class="chart-container">
            <h2>Revenue Last 7 Days</h2>
            <canvas id="revenueChart"></canvas>
        </div>

        <!-- Removed: Product Categories chart container -->
    </div>

    <script>
        console.log('JavaScript is running');
        
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

        // Removed: Popular Items chart script

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

        // Removed: Product Categories chart script
    </script>
</body>
</html>
