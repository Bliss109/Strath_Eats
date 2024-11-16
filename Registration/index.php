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
            <form id="login" class="input-group" action="../User/login.php" method="POST" onsubmit="submitLoginForm(event)">
                <input type="email" class="input-field" placeholder="email" name="email" required id="email">
                <!-- Password field with eye toggle -->
                <div class="password-container">
                    <input type="password" class="input-field" placeholder="Enter Password" name="password" required id="password">
                    <span id="eye-icon" onclick="togglePasswordVisibility()" class="eye-icon">👁</span>
                </div>
                <input type="checkbox" class="check-box"><span>Remember Password</span>
                <button type="submit" class="submit-btn">Log In</button>
            </form>

            <!-- Register Form -->
            <form id="register" class="input-group" action="../User/register.php" method="POST" onsubmit="submitRegisterForm(event)">
                <input type="text" class="input-field" placeholder="User Name" name="name" required id="name">
                <input type="email" class="input-field" placeholder="Email" name="email" required id="email">
                <div class="password-field">
                    <input type="password" class="input-field" placeholder="Enter Password" name="password" required id="password">
                    <span id="eye-icon" onclick="togglePasswordVisibility()" class="eye-icon">👁</span>
                </div>
                <input type="tel" class="input-field" placeholder="e.g 2547xxxx" pattern="\254[0-9]{9}" name="phone_number" required id="phone_number">
                <input type="checkbox" class="check-box" id="terms" name="terms"><span>I agree to the terms & conditions</span>
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
                eyeIcon.textContent = "👁";  // Change the icon to "show"
            }
        }

        function submitLoginForm(event) {
            event.preventDefault(); // Prevent default form submission

            const form = event.target;
            const formData = new FormData(form);
            const data = {};

            formData.forEach((value, key) => {
                data[key] = value;
            });

            fetch(form.action, {
                method: form.method,
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                alert(result.message); // Display server response
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function submitRegisterForm(event) {
            event.preventDefault(); // Prevent default form submission

            const form = event.target;
            const formData = new FormData(form);
            const data = {};

            formData.forEach((value, key) => {
                data[key] = value;
            });

            fetch(form.action, {
                method: form.method,
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                alert(result.message); // Display server response
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</body>

</html>
