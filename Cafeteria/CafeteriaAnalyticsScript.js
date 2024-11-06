document.addEventListener('DOMContentLoaded', function () {
    // Revenue Data (Existing Code)
    const revenueData = [
        { itemName: 'Burger', price: 5.00, quantitySold: 20, server: 'John', timestamp: '10:00 AM' },
        { itemName: 'Fries', price: 2.50, quantitySold: 40, server: 'Anna', timestamp: '10:15 AM' },
        { itemName: 'Soda', price: 1.50, quantitySold: 30, server: 'Chris', timestamp: '10:30 AM' }
    ];

    const revenueTable = document.getElementById('revenueData');
    const orderDataContainer = document.getElementById('orderData');
    let totalRevenue = 0;

    revenueData.forEach(item => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.itemName}</td>
            <td>$${item.price.toFixed(2)}</td>
            <td>${item.quantitySold}</td>
            <td>$${(item.price * item.quantitySold).toFixed(2)}</td>
        `;
        revenueTable.appendChild(row);
        totalRevenue += item.price * item.quantitySold;

        const orderContainer = document.createElement('div');
        orderContainer.classList.add('order-container');
        orderContainer.innerHTML = `
            <p><strong>Item Name:</strong> ${item.itemName}</p>
            <p><strong>Price:</strong> $${item.price.toFixed(2)}</p>
            <p><strong>Quantity:</strong> ${item.quantitySold}</p>
            <p><strong>Total:</strong> $${(item.price * item.quantitySold).toFixed(2)}</p>
            <p><strong>Server:</strong> ${item.server}</p>
            <p><strong>Time:</strong> ${item.timestamp}</p>
        `;
        orderDataContainer.appendChild(orderContainer);
    });

    document.getElementById('totalRevenue').textContent = totalRevenue.toFixed(2);
    document.getElementById('employeeWages').textContent = (totalRevenue * 0.2).toFixed(2);
    document.getElementById('deliveryWages').textContent = (totalRevenue * 0.1).toFixed(2);

    // Chart: Popular Dish Categories (Mock Data)
    new Chart(document.getElementById('dishCategoriesChart'), {
        type: 'pie',
        data: {
            labels: ['Breakfast', 'Lunch', 'Snacks', 'Dessert', 'Drinks'],
            datasets: [{
                data: [150, 300, 100, 200, 250],
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

    // Chart: Frequent Out-of-Stock Items (Mock Data)
    new Chart(document.getElementById('stockOutChart'), {
        type: 'bar',
        data: {
            labels: ['Burger', 'Fries', 'Soda', 'Salad', 'Pizza'],
            datasets: [{
                label: 'Out-of-Stock Count',
                data: [10, 15, 5, 8, 12],
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

    // Chart: Supplier Distribution (Mock Data)
    new Chart(document.getElementById('supplierChart'), {
        type: 'doughnut',
        data: {
            labels: ['Supplier A', 'Supplier B', 'Supplier C', 'Supplier D'],
            datasets: [{
                data: [40, 30, 20, 10],
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

    // Chart: Commonly Bought Together (Mock Data)
    new Chart(document.getElementById('pairingChart'), {
        type: 'line',
        data: {
            labels: ['Burger & Fries', 'Soda & Pizza', 'Salad & Water', 'Sandwich & Coffee'],
            datasets: [{
                label: 'Pairing Frequency',
                data: [120, 90, 60, 150],
                backgroundColor: '#36A2EB',
                borderColor: '#36A2EB',
                fill: false
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: 'Commonly Bought Together' }
            }
        }
    });

    // Chart: Yearly Revenue (Mock Data)
    new Chart(document.getElementById('yearlyRevenueChart'), {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
                label: 'Revenue ($)',
                data: [2000, 3000, 2500, 4000, 3500, 3000, 4500, 5000, 4200, 4600, 4900, 5300], // Example data
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
