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
            <!-- Login form remains unchanged -->
            <form id="login" action="../User/login.php" class="input-group" method="POST">
                <input type="text" class="input-field" placeholder="User Name" name="username" required>
                <input type="password" class="input-field" placeholder="Enter Password" name="password" required>
                <input type="checkbox" class="check-box"><span>Remember Password</span>
                <button type="submit" class="submit-btn">Log In</button>
            </form>

            <!-- Register form with updated ID and method for preventing default submission -->
            <form id="register" class="input-group" method="POST" enctype="multipart/form-data">
                <input type="text" class="input-field" placeholder="User Name" name="name" required id="name">
                <input type="email" class="input-field" placeholder="Email" name="email" required id="email">
                <input type="password" class="input-field" placeholder="Enter Password" name="password" required id="password">
                <input type="tel" class="input-field" placeholder="e.g 2547xxxx" pattern="\254[0-9]{9}" name="phone_number" required id="phone_number">
                <!-- Profile Picture Upload -->
                <input type="file" class="input-field" name="profile_picture" accept="image/*" id="profile_picture">
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
        document.getElementById('register').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Retrieve form data
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const phone_number = document.getElementById('phone_number').value;
            const termsAccepted = document.getElementById('terms').checked;
            const profile_picture = document.getElementById('profile_picture').files[0]; // Get the selected file

            // Log the collected data for debugging
            console.log("name:", name);
            console.log("Email:", email);
            console.log("Password:", password);
            console.log("Phone:", phone_number);
            console.log("Profile Picture:", profile_picture);

            // Check if terms are accepted
            if (!termsAccepted) {
                alert("You must agree to the terms & conditions.");
                return;
            }

            // Check for empty fields
            if (!username || !email || !password || !phone_number || !profile_picture) {
                alert("All fields are required!");
                return;
            }

            // Create FormData object to handle file upload and other form fields
            const formData = new FormData();
            formData.append('name', name);
            formData.append('email', email);
            formData.append('password', password);
            formData.append('phone_number', phone_number);

            // Append profile picture only if it's selected
            if (profile_picture) {
                formData.append('profile_picture', profile_picture);
            }

            // Send FormData using fetch API
            fetch('../User/register.php', {
                    method: 'POST',
                    body: formData
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


        document.getElementById('login').addEventListener('submit', function(event) {
            event.preventDefault();

            //Retrieve form data
            const name = document.getElementById('name').value;
            const password = document.getElementById('password').value;

            //Check for empty fields
            if (!name || !password) {
                alert("Both fields are required!");
                return;
            }
            //Create JSON data
            const data = {
                name: name,
                password: password
            };

            //Send JSON data using fetch API
            fetch('../User/login.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.text())
                .then(result => {
                    // Display server response (could be a success message or error)
                    alert(result);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>
</body>

</html>
