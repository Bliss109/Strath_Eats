<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Registration Form</title>
</head>

<body>
    <div class="hero">
        <div class="form-box">
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" class="toggle-btn" onclick="login()">Log In</button>
                <button type="button" class="toggle-btn" onclick="register()">Register</button>
            </div>
            <div class="social-icons">
                <img src="../Registration/Assets/instagram (2).png">
                <img src="../Registration/Assets/facebook (2).png">
                <img src="../Registration/Assets/twitterx.png">
            </div>

            <!-- Login Form -->
            <form id="login" class="input-group" action="../User/login.php" method="POST">
                <input type="text" class="input-field" placeholder="User Name" name="name" required id="username">
                <!-- Password field with eye toggle -->
                <div class="password-container">
                    <input type="password" class="input-field" placeholder="Enter Password" name="password" required id="password">
                    <span id="eye-icon" onclick="togglePasswordVisibility()" class="eye-icon">👁️</span>
                </div>
                <input type="checkbox" class="check-box"><span>Remember Password</span>
                <button type="submit" class="submit-btn">Log In</button>
            </form>

            <!-- Register Form -->
            <form id="register" class="input-group" action="../User/register.php">
                <input type="text" class="input-field" placeholder="User Name" name="name" required id="name">
                <input type="email" class="input-field" placeholder="Email" name="email" required id="email">
                <div class="password-field">
                    <input type="password" class="input-field" placeholder="Enter Password" name="password" required id="password">
                    <span id="eye-icon" onclick="togglePasswordVisibility()" class="eye-icon">👁️</span>
                </div>
                <input type="tel" class="input-field" placeholder="e.g 2547xxxx" pattern="\254[0-9]{9}" name="phone_number" required id="phone_number">
                <input type="checkbox" class="check-box" id="terms"><span>I agree to the terms & conditions</span>
                <button type="submit" class="submit-btn">Register</button>
            </form>
        </div>
    </div>

    <script>
        var x = document.getElementById("login");
        var y = document.getElementById("register");
        var z = document.getElementById("btn");

        function register() {
            x.style.left = "-400px";
            y.style.left = "50px";
            z.style.left = "110px";
        }

        function login() {
            x.style.left = "50px";
            y.style.left = "450px";
            z.style.left = "0";
        }

        // Registration form event listener
        document.getElementById('register').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Retrieve form data
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const phone_number = document.getElementById('phone_number').value;
            const termsAccepted = document.getElementById('terms').checked;

            // Validate terms acceptance
            if (!termsAccepted) {
                alert("You must agree to the terms & conditions.");
                return;
            }

            // Check for empty fields
            if (!name || !email || !password || !phone_number) {
                alert("All fields are required!");
                return;
            }

            // Create JSON data
            const data = {
                name: name,
                email: email,
                password: password,
                phone_number: phone_number
            };

            // Send JSON data using fetch API
            fetch('../User/register.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.text())
                .then(result => {
                    alert(result); // Display server response
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });

        // Login form event listener
        document.getElementById('login').addEventListener('submit', function(event) {
            event.preventDefault();

            // Retrieve form data
            const name = document.getElementById('name').value;
            const password = document.getElementById('password').value;

            // Check for empty fields
            if (!name || !password) {
                alert("Both fields are required!");
                return;
            }

            // Create JSON data
            const data = {
                name: name,
                password: password
            };

            // Send JSON data using fetch API
            fetch('../User/login.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.text())
                .then(result => {
                    alert(result); // Display server response
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
        // Function to toggle password visibility
        function togglePasswordVisibility() {
            var passwordField = document.getElementById('password');
            var eyeIcon = document.getElementById('eye-icon');
            
            // Toggle password field type between text and password
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.textContent = "🙈";  // Change the icon to "hide"
            } else {
                passwordField.type = "password";
                eyeIcon.textContent = "👁️";  // Change the icon to "show"
            }
        }
    </script>
</body>

</html>
