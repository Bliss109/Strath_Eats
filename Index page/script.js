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

const searchBar = document.querySelector('.search-bar');
    searchBar.addEventListener('input', () => {
        const query = searchBar.value.toLowerCase();
        filterBySearch(query);
    });
    
function filterBySearch(query) {
        const dishes = document.querySelectorAll('.dish-card');
        dishes.forEach(dish => {
            const dishName = dish.querySelector('p').textContent.toLowerCase();
            if (dishName.includes(query)) {
                dish.style.display = 'block';
            } else {
                dish.style.display = 'none';
            }
        });
    }    
}