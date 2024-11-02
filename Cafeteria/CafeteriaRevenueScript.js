document.addEventListener('DOMContentLoaded', function () {
    const revenueData = [
        { itemName: 'Burger', price: 5.00, quantitySold: 20, server: 'John', timestamp: '10:00 AM' },
        { itemName: 'Fries', price: 2.50, quantitySold: 40, server: 'Anna', timestamp: '10:15 AM' },
        { itemName: 'Soda', price: 1.50, quantitySold: 30, server: 'Chris', timestamp: '10:30 AM' }
    ];

    const revenueTable = document.getElementById('revenueData');
    const orderDataContainer = document.getElementById('orderData');
    let totalRevenue = 0;

    revenueData.forEach(item => {
        // Populate the table
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.itemName}</td>
            <td>$${item.price.toFixed(2)}</td>
            <td>${item.quantitySold}</td>
            <td>$${(item.price * item.quantitySold).toFixed(2)}</td>
        `;
        revenueTable.appendChild(row);

        // Calculate total revenue
        totalRevenue += item.price * item.quantitySold;

        // Create a container for each order in chronological order view
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

    // Update the total revenue and wages
    document.getElementById('totalRevenue').textContent = totalRevenue.toFixed(2);
    document.getElementById('employeeWages').textContent = (totalRevenue * 0.2).toFixed(2);
    document.getElementById('deliveryWages').textContent = (totalRevenue * 0.1).toFixed(2);
});
