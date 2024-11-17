document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.querySelector('.sidebar');
    const sidebar1 = document.querySelector('.sidebar1');
    const barsIcon = document.querySelector('.fa-bars');
    const cartIcon = document.querySelector('.cart-icon');
    const closeCartButton = sidebar.querySelector('.sidebar-close');
    const closeButtonSidebar1 = sidebar1.querySelector('.sidebar-close');
    const content = document.querySelector('.content');

    // Redirect to new page on menu click
    const menuRedirects = {
        'breakfast-menu': 'breakfast.php',
        'lunch-menu': 'lunch.php',
        'dessert-menu': 'dessert.php',
        'snacks-menu': 'snacks.php',
        'drinks-menu': 'drinks.php',
    };

    Object.entries(menuRedirects).forEach(([menuId, url]) => {
        const menuElement = document.getElementById(menuId);
        if (menuElement) {
            menuElement.addEventListener('click', () => {
                window.location.href = url;
            });
        }
    });

    // Toggle sidebar visibility
    barsIcon.addEventListener('click', () => {
        sidebar1.classList.toggle('open');
    });

    closeButtonSidebar1.addEventListener('click', () => {
        sidebar1.classList.remove('open');
    });

    // Cart functionality
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    const cartItemCount = document.querySelector('.cart-icon span');
    const cartItemsList = document.querySelector('.cart-items');
    const cartTotal = document.querySelector('.cart-total');
    let cartItems = [];
    let totalAmount = 0;

    if (cartItemCount && cartItemsList && cartTotal) {
        addToCartButtons.forEach((button) => {
            button.addEventListener('click', (e) => {
                e.stopPropagation(); // Prevent click event from closing the cart sidebar

                const card = button.closest('.card');
                const itemName = card.querySelector('.card-title').textContent;
                const itemPriceText = card.querySelector('.price').textContent;

                const itemPrice = parseFloat(itemPriceText.replace('Ksh', '').trim());

                const item = {
                    name: itemName,
                    price: itemPrice,
                    quantity: 1,
                };

                // Check if item already exists in cart
                const existingItem = cartItems.find(cartItem => cartItem.name === item.name);
                if (existingItem) {
                    existingItem.quantity++;
                } else {
                    cartItems.push(item);
                }
                totalAmount += item.price;
                updateCartUI();
                sidebar.classList.add('open'); // Ensure cart sidebar is open when item is added
            });
        });
    }

    function updateCartUI() {
        updateCartItemCount(cartItems.length);
        updateCartItemList();
        updateCartTotal();
    }

    function updateCartItemCount(count) {
        cartItemCount.textContent = count;
    }

    function updateCartItemList() {
        cartItemsList.innerHTML = '';
        cartItems.forEach((item, index) => {
            const cartItem = document.createElement('div');
            cartItem.classList.add('cart-item', 'individual-cart-item');
            cartItem.innerHTML = `
                <span>(${item.quantity} x) ${item.name}</span>
                <span class="cart-item-price">Ksh ${(item.price * item.quantity).toFixed(2)}
                    <button class="remove-item" data-index="${index}"><i class="fa-solid fa-times"></i></button>
                </span>
            `;
            cartItemsList.append(cartItem);
        });

        // Attach remove item event listeners
        document.querySelectorAll('.remove-item').forEach((button) => {
            button.addEventListener('click', (event) => {
                const index = event.currentTarget.dataset.index;
                removeItemFromCart(index);
            });
        });
    }

    function removeItemFromCart(index) {
        const removedItem = cartItems.splice(index, 1)[0];
        totalAmount -= removedItem.price * removedItem.quantity;
        updateCartUI();
    }

    function updateCartTotal() {
        cartTotal.textContent = `Ksh ${totalAmount.toFixed(2)}`;
    }

    // Open and close the cart sidebar
    cartIcon.addEventListener('click', () => {
        sidebar.classList.toggle('open');
    });

    closeCartButton.addEventListener('click', () => {
        sidebar.classList.remove('open');
    });

    // Prevent cart sidebar from closing when interacting with it
    sidebar.addEventListener('click', (e) => {
        e.stopPropagation();
    });
});
