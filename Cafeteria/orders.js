// Function to fetch and display real-time orders
async function fetchOrders() {
    try {
        // Fetch orders from the backend
        const response = await fetch('get_orders.php');
        const orders = await response.json();

        // Get the table body element
        const ordersBody = document.getElementById('ordersBody');
        ordersBody.innerHTML = ''; // Clear existing rows

        // Loop through the orders and create table rows
        orders.forEach(order => {
            const row = document.createElement('tr');

            // Determine the status class based on the order status
            const statusClass = order.status === 'completed' ? 'status-completed' : 'status-pending';

            // Populate the table row with order data
            row.innerHTML = `
                <td>${order.order_id}</td>
                <td>${order.user_id}</td>
                <td>${new Date(order.order_time).toLocaleString()}</td>
                <td class="${statusClass}">${order.status}</td>
            `;
            ordersBody.appendChild(row);
        });
    } catch (error) {
        console.error('Error fetching orders:', error);
    }
}

// Fetch orders every 5 seconds for real-time updates
setInterval(fetchOrders, 5000);

// Initial fetch when the page loads
document.addEventListener('DOMContentLoaded', fetchOrders);
