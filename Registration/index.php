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
                <img src="./Assets/instagram.png">
                <img src="./Assets/facebook.png">
                <img src="./Assets/twitter.png">
            </div>
            <!-- Login form remains unchanged -->
            <form id="login" action="../User/login.php" class="input-group" method="POST">
                <input type="text" class="input-field" placeholder="User Name" name="username" required>
                <input type="password" class="input-field" placeholder="Enter Password" name="password" required>
                <input type="checkbox" class="check-box"><span>Remember Password</span>
                <button type="submit" class="submit-btn">Log In</button>
            </form>
            
            <!-- Register form with updated ID and method for preventing default submission -->
            <form id="register" class="input-group" method="POST">
                <input type="text" class="input-field" placeholder="User Name" name="name" required id="name">
                <input type="email" class="input-field" placeholder="Email" name="email" required id="email">
                <input type="password" class="input-field" placeholder="Enter Password" name="password" required id="password">
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

        // Attach the submit event handler to the registration form
        document.getElementById('register').addEventListener('submit', function(event) {
            event.preventDefault();  // Prevent default form submission

            // Retrieve form data
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const termsAccepted = document.getElementById('terms').checked;

            // Check if terms are accepted
            if (!termsAccepted) {
                alert("You must agree to the terms & conditions.");
                return;
            }

            // Check for empty fields
            if (!name || !email || !password) {
                alert("All fields are required!");
                return;
            }

            // Create JSON data
            const data = {
                name: name,
                email: email,
                password: password
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
                    // Display server response
                    alert(result);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>
</body>

</html>

