document.addEventListener('DOMContentLoaded', function () {
    // Fetch Revenue Data
    fetch('getRevenueData.php')
        .then(response => response.json())
        .then(data => {
            const revenueTable = document.getElementById('revenueData');
            const orderDataContainer = document.getElementById('orderData');
            let totalRevenue = 0;

            data.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.name}</td>
                    <td>$${item.price.toFixed(2)}</td>
                    <td>${item.quantitySold}</td>
                    <td>$${(item.price * item.quantitySold).toFixed(2)}</td>
                `;
                revenueTable.appendChild(row);
                totalRevenue += item.price * item.quantitySold;

                const orderContainer = document.createElement('div');
                orderContainer.classList.add('order-container');
                orderContainer.innerHTML = `
                    <p><strong>Item Name:</strong> ${item.name}</p>
                    <p><strong>Price:</strong> $${item.price.toFixed(2)}</p>
                    <p><strong>Quantity:</strong> ${item.quantitySold}</p>
                    <p><strong>Total:</strong> $${(item.price * item.quantitySold).toFixed(2)}</p>
                `;
                orderDataContainer.appendChild(orderContainer);
            });

            document.getElementById('totalRevenue').textContent = totalRevenue.toFixed(2);
            document.getElementById('employeeWages').textContent = (totalRevenue * 0.2).toFixed(2);
            document.getElementById('deliveryWages').textContent = (totalRevenue * 0.1).toFixed(2);
        });

    // Fetch Order Data
    fetch('getOrderData.php')
        .then(response => response.json())
        .then(data => {
            const orderDataContainer = document.getElementById('orderData');

            data.forEach(order => {
                const orderContainer = document.createElement('div');
                orderContainer.classList.add('order-container');
                orderContainer.innerHTML = `
                    <p><strong>Order Date:</strong> ${new Date(order.order_date).toLocaleString()}</p>
                    <p><strong>Product:</strong> ${order.product_name}</p>
                    <p><strong>Quantity:</strong> ${order.quantity}</p>
                    <p><strong>Price per Item:</strong> $${order.price.toFixed(2)}</p>
                    <p><strong>Total Price:</strong> $${order.total_price.toFixed(2)}</p>
                `;
                orderDataContainer.appendChild(orderContainer);
            });
        })
        .catch(error => console.error('Error fetching order data:', error));

    // Chart: Popular Dish Categories
    fetch('getDishCategoryData.php')
        .then(response => response.json())
        .then(data => {
            new Chart(document.getElementById('dishCategoriesChart'), {
                type: 'pie',
                data: {
                    labels: data.categories,
                    datasets: [{
                        data: data.sales,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#66FF66', '#3399FF']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        title: { display: true, text: 'Popularity of Dish Categories' }
                    }
                }
            });
        });

    // Chart: Frequent Out-of-Stock Items
    fetch('getOutOfStockData.php')
        .then(response => response.json())
        .then(data => {
            new Chart(document.getElementById('stockOutChart'), {
                type: 'bar',
                data: {
                    labels: data.items,
                    datasets: [{
                        label: 'Out-of-Stock Count',
                        data: data.counts,
                        backgroundColor: '#FF5733'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        title: { display: true, text: 'Frequently Out-of-Stock Items' }
                    }
                }
            });
        });

    // Chart: Supplier Distribution
    fetch('getSupplierData.php')
        .then(response => response.json())
        .then(data => {
            new Chart(document.getElementById('supplierChart'), {
                type: 'doughnut',
                data: {
                    labels: data.names,
                    datasets: [{
                        data: data.frequencies,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#66FF66']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        title: { display: true, text: 'Supplier Distribution' }
                    }
                }
            });
        });

    // Chart: Yearly Revenue
    fetch('getYearlyRevenueData.php')
        .then(response => response.json())
        .then(data => {
            new Chart(document.getElementById('yearlyRevenueChart'), {
                type: 'bar',
                data: {
                    labels: data.months,
                    datasets: [{
                        label: 'Revenue ($)',
                        data: data.revenues,
                        backgroundColor: '#4CAF50',
                        borderColor: '#388E3C',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        title: { display: true, text: 'Yearly Revenue' }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1000 }
                        }
                    }
                }
            });
        });
});
