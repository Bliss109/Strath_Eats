<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Groundfloor Cafeteria - StrathEats</title>
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
    <h1>Welcome to Groundfloor Cafeteria</h1>

    <div class="content">
      <section class="cover">
        <div class="cover-overlay">
          <h1>
            <span class="slogan">Delicious Meals, Quick and Easy</span>
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
          <div class="menu-item" id="starter-menu">
            <img src="../../../Images/croissant.jpg" alt="Breakfast" />
            <h5>Breakfast</h5>
          </div>
          <div class="menu-item" id="main-course-menu">
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

        <!-- Food Items Section -->
        <h2 class="section-heading">Food Items</h2>
        
        <div class="card-list">
          <div class="card" id="starter">
            <img src="../../../Images/cupcakes.jpg" alt="Mandazi" />
            <h4 class="card-title">Cupcakes</h4>
            <div class="card-price">
              <span class="price">Ksh 50</span>
              <i class="fa-solid fa-plus add-to-cart"></i>
            </div>
          </div>
          <div class="card-list">
            <div class="card" id="starter">
              <img src="../../../Images/samosas.png" alt="Samosas" />
              <h4 class="card-title">Samosas</h4>
              <div class="card-price">
                <span class="price">Ksh 50</span>
                <i class="fa-solid fa-plus add-to-cart"></i>
              </div>
            </div>
            </div>
            <div class="card-list">
          <div class="card" id="main-course">
            <img src="../../../Images/pilau.png" alt="pilau" />
            <h4 class="card-title">Pilau</h4>
            <div class="card-price">
              <span class="price">Ksh 300</span>
              <i class="fa-solid fa-plus add-to-cart"></i>
            </div>
          </div>
          </div>
          <div class="card" id="main-course">
            <img src="../../../Images/Lyonnaise_Potatoes.jpg" alt="Chocolate Cake" />
            <h4 class="card-title">Lyonnaise Potatoes</h4>
            <div class="card-price">
              <span class="price">Ksh 80</span>
              <i class="fa-solid fa-plus add-to-cart"></i>
            </div>
          </div>
          <div class="card" id="main-course">
            <img src="../../../Images/Potato_wedges.png" alt="Wedges" />
            <h4 class="card-title">Potato Wedges</h4>
            <div class="card-price">
              <span class="price">Ksh 60</span>
              <i class="fa-solid fa-plus add-to-cart"></i>
            </div>
          </div>
          <div class="card" id="main-course">
            <img src="../../../Images/Rice.png" alt="Rise" />
            <h4 class="card-title">Rice</h4>
            <div class="card-price">
              <span class="price">Ksh 40</span>
              <i class="fa-solid fa-plus add-to-cart"></i>
            </div>
          </div>
          <div class="card" id="main-course">
            <img src="../../../Images/Salad.png" alt="Salad" />
            <h4 class="card-title">Salad</h4>
            <div class="card-price">
              <span class="price">Ksh 40</span>
              <i class="fa-solid fa-plus add-to-cart"></i>
            </div>
          </div>
          <div class="card" id="main-course">
            <img src="../../../Images/Potato_Pea_Curry.png" alt="Curry" />
            <h4 class="card-title">Potato and Pea Curry</h4>
            <div class="card-price">
              <span class="price">Ksh 80</span>
              <i class="fa-solid fa-plus add-to-cart"></i>
            </div>
          </div>
          <div class="card" id="drinks">
            <img src="../../../Images/soda img.jpg" alt="Soda" />
            <h4 class="card-title">Soda</h4>
            <div class="card-price">
              <span class="price">Ksh 50</span>
              <i class="fa-solid fa-plus add-to-cart"></i>
            </div>
          </div>
          <div class="card-list">
            <div class="card" id="starter">
              <img src="../../../Images/Apple.png" alt="Apple" />
              <h4 class="card-title">Apples</h4>
              <div class="card-price">
                <span class="price">Ksh 30</span>
                <i class="fa-solid fa-plus add-to-cart"></i>
              </div>
            </div>
        </div>

        <!-- Cart Sidebar Section -->
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
