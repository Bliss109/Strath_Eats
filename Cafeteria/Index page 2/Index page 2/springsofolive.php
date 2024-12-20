<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Springs of Olive - StrathEats</title>
    <link rel="stylesheet" href="style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />
  </head>
  <body>
    <aside class="sidebar1">
      <div class="sidebar-close">
        <i class="fa-solid fa-close"></i>
      </div>
      <h2>StrathEats</h2>
      <img src="../../../Images/logoo.png" alt="StrathEats Logo" class="logo-image" />
      <nav>
        <ul>
          <li><a href="#">Dashboard</a></li>
          <li><a href="#">Food Order</a></li>
          <li><a href="#">Favorite</a></li>
          <li><a href="#">Message</a></li>
          <li><a href="#">Order History</a></li>
          <li><a href="#">Bills</a></li>
          <li><a href="#">Login</a></li>
        </ul>
      </nav>
    </aside>

    <header class="header">
      <nav class="menu">
        <div class="burger-icons">
          <i class="fa-solid fa-bars"></i>
        </div>
        <div class="search--box">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="text" placeholder="Search" />
        </div>
        <div class="menu--icons">
          <i class="fa-solid fa-bowl-food"></i>
          <div class="cart-icon">
            <i class="fa-solid fa-cart-shopping"></i>
            <span>0</span>
          </div>
        </div>
      </nav>
    </header>
    <h1>Welcome to Springs of Olive</h1>

    <div class="content">
      <section class="cover">
        <div class="cover-overlay">
          <h1>
            <span class="slogan">Best in Quality and Price!</span>
          </h1>
        </div>
      </section>

      <main>
        <h2 class="section-heading">Categories</h2>
        <div class="menu-list">
          <div class="menu-item">
            <img src="../../../Images/chapati img.jpg" alt="" />
            <h5>All Menu Items</h5>
          </div>
          <div class="menu-item" id="breakfast-menu">
            <img src="../../../Images/croissant.jpg" alt="Breakfast" />
            <h5>Breakfast</h5>
          </div>
          <div class="menu-item" id="lunch-menu">
            <img src="../../../Images/beef.png" alt="Lunch" />
            <h5>Lunch</h5>
          </div>
          <div class="menu-item" id="dessert-menu">
            <img src="../../../Images/Red_Velvet_Cake.png" alt="Dessert" />
            <h5>Dessert</h5>
          </div>
          <div class="menu-item" id="drinks-menu">
            <img src="../../../Images/mirinda.png" alt="Beverages" />
            <h5>Beverages</h5>
          </div>
        </div>

        <!-- card item section-->
        <h2 class="section-heading">Food Items</h2>
        <div class="card-list">
          <!-- Starter Dishes -->
          <div class="card" id="snacks-menu">
            <img src="../../../Images/smokies.png" alt="smokies" />
            <h4 class="card-title">Smokies</h4>
            <div class="card-price">
              <span class="price">Ksh 30</span>
              <i class="fa-solid fa-plus add-to-cart"></i>
            </div>
          </div>
          <div class="card" id="snacks-menu">
            <img src="../../../Images/samosas.png" alt="Beef Samosa" />
            <h4 class="card-title">Beef Samosa</h4>
            <div class="card-price">
              <span class="price">Ksh 40</span>
              <i class="fa-solid fa-plus add-to-cart"></i>
            </div>
          </div>

          <!-- Main Course Dishes -->
          <div class="card" id="lunch-menu">
            <img src="../../../Images/wraps.png" alt="wraps" />
            <h4 class="card-title">Chicken wraps</h4>
            <div class="card-price">
              <span class="price">Ksh 180</span>
              <i class="fa-solid fa-plus add-to-cart"></i>
            </div>
          </div>
          <div class="card" id="lunch-menu">
            <img src="../../../Images/masala_chips.png" alt="Masala" />
            <h4 class="card-title">Masala Chips</h4>
            <div class="card-price">
              <span class="price">Ksh 180</span>
              <i class="fa-solid fa-plus add-to-cart"></i>
            </div>
          </div>

          <!-- Dessert Dishes -->
          <div class="card" id="dessert-menu">
            <img src="../../../Images/chips_wings.png" alt="chips" />
            <h4 class="card-title">Chips and Wings</h4>
            <div class="card-price">
              <span class="price">Ksh 200</span>
              <i class="fa-solid fa-plus add-to-cart"></i>
            </div>
          </div>
          <div class="card" id="dessert-menu">
            <img src="../../../Images/chapati_beef.png" alt="Chapati" />
            <h4 class="card-title">Chapati and Beef</h4>
            <div class="card-price">
              <span class="price">Ksh 30</span>
              <i class="fa-solid fa-plus add-to-cart"></i>
            </div>
          </div>
          <div class="card" id="dessert-menu">
            <img src="../../../Images/fries.png" alt="Chapati" />
            <h4 class="card-title">Chips</h4>
            <div class="card-price">
              <span class="price">Ksh 130</span>
              <i class="fa-solid fa-plus add-to-cart"></i>
            </div>
          </div>

          <!-- Beverages -->
          <div class="card" id="drinks-menu">
            <img src="../../../Images/soda img.jpg" alt="soda" />
            <h4 class="card-title">Soda</h4>
            <div class="card-price">
              <span class="price">Ksh 50</span>
              <i class="fa-solid fa-plus add-to-cart"></i>
            </div>
          </div>
          <div class="card" id="drinks-menu">
            <img src="../../../Images/mirinda.png" alt="soda" />
            <h4 class="card-title">Mirinda</h4>
            <div class="card-price">
              <span class="price">Ksh 40</span>
              <i class="fa-solid fa-plus add-to-cart"></i>
            </div>
          </div>
        </div>

        <!-- cart sidebar section-->
        <div class="sidebar" id="sidebar">
          <div class="sidebar-close">
            <i class="fa-solid fa-close"></i>
          </div>
          <div class="cart-menu">
            <h3>My Cart</h3>
            <div class="cart-items"></div>
          </div>

          <div class="sidebar-footer">
            <div class="total-amount">
              <h5>Total</h5>
              <div class="cart-total">Ksh 0.00</div>
            </div>
            <button class="checkout-btn">Checkout</button>
          </div>
        </div>
      </main>
    </div>
    <footer class="footer">
      <p>© 2024 StrathEats. All rights reserved.</p>
    </footer>
    <script src="main.js"></script>
  </body>
</html>
