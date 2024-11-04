let orderMenu = document.getElementById('order-menu');
let totalAmount = document.getElementById('total-amount');
let totalPrice = 0;

const addButtons = document.querySelectorAll('.add-btn');
addButtons.forEach(button => {
    button.addEventListener('click', (e) => {
        const dishName = e.target.dataset.name;
        const dishPrice = parseFloat(e.target.dataset.price);
        addToCart(dishName, dishPrice);
    });
});

function addToCart(name, price) {
    const orderItem = document.createElement('li');
    orderItem.textContent = `${name} - KSh ${price.toFixed(2)}`;
    orderMenu.appendChild(orderItem);
    
    totalPrice += price;
    totalAmount.textContent = `Total: KSh ${totalPrice.toFixed(2)}`;
}

const checkoutButton = document.querySelector('.checkout-btn');
checkoutButton.addEventListener('click', () => {
    if (totalPrice > 0) {
        alert(`Order placed successfully! Total: KSh ${totalPrice.toFixed(2)}`);
        clearCart();
    } else {
        alert('Your cart is empty!');
    }
});

function clearCart() {
    orderMenu.innerHTML = '';
    totalPrice = 0;
    totalAmount.textContent = 'Total: KSh 0.00';
}

const categoryButtons = document.querySelectorAll('.category-item');
categoryButtons.forEach(button => {
    button.addEventListener('click', () => {
        filterDishes(button.dataset.category);
    });
});

function filterDishes(category) {
    const allDishes = document.querySelectorAll('.dish-card');
    allDishes.forEach(dish => {
        if (dish.dataset.category === category || category === 'all') {
            dish.style.display = 'block';
        } else {
            dish.style.display = 'none';
        }
    });
}
document.addEventListener("DOMContentLoaded", () => {
    const walletBalanceElement = document.getElementById("wallet-balance").querySelector("span");

    // Fetch wallet balance (example using an API endpoint)
    fetch("get_balance.php")
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                walletBalanceElement.textContent = data.balance;
            } else {
                alert("Error fetching wallet balance.");
            }
        });
});

// Function to handle opening a deposit modal
function openDepositModal() {
    alert("Deposit functionality will go here!");
}
