<?php
session_start();
if (isset($_SESSION['profile_picture'])) {
<<<<<<< HEAD
    $profilePicture = 'uploads/' . $_SESSION['profile_picture'];
=======
    $profilePicture = 'C:/xampp/htdocs/Strath_Eats/uploads/' . $_SESSION['profile_picture'];
>>>>>>> 5adc3d3 (Updated profile)
} else {
    $profilePicture = '../UserProfile/cindy.jpeg';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <nav>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#profile">Wallet</a></li>
                    <li><a href="#settings">Order Now</a></li>
                    <li><a href="#logout">Logout</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main content -->
        <div class="main-content">
            <div class="header">
                <h1>My Profile</h1>
                <div class="actions">
                    <button class="btn btn-secondary" onclick="cancelChanges()">Cancel</button>
                    <button class="btn btn-primary" onclick="saveChanges()">Save</button>
                </div>
            </div>

            <div class="profile-section">
                <div class="left-section">
                    <div class="profile-photo">
                        <!-- Display Current Profile Image -->
                        <img id="profileImagePreview" src="<?php echo $profilePicture; ?>" alt="profile_picture"/>

                        <!-- Change Photo Form -->
<<<<<<< HEAD
                        <form id="profileForm" action="../User/profile.php" method="POST" enctype="multipart/form-data">
=======
                        <form action="../User/profile.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="user_id" value="1"> <!-- Replace with dynamic user ID -->

>>>>>>> 5adc3d3 (Updated profile)
                            <!-- Hidden File Input -->
                            <input type="file" name="profile_picture" id="profilePictureInput" style="display: none;" accept="image/*" onchange="previewImage(event)">

                            <!-- Change Photo Button -->
                            <button type="button" class="btn btn-secondary" onclick="document.getElementById('profilePictureInput').click();">
                                Change Photo
                            </button>

                            <!-- Submit Button -->
                            <button type="submit" name="update_picture" class="btn btn-primary" style="display: none;" id="submitPhotoButton">
                                Save
                            </button>
                        </form>
                    </div>

                    <!-- Left Section Form Groups -->
                    <div class="form-group">
                        <label>name</label>
                        <input type="text" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" placeholder="eg. kevinmorel@gmail.com" value="">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="tel" class="form-control" placeholder="eg. +254 759 074 192" value="">
                    </div>
                </div>

                <div class="right-section">
                    <div class="form-group">
                        <label>Student id (if applicable)</label>
                        <input type="text" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select class="form-control">
                            <option value="">Select a role</option>
                            <option value="user">Student</option>
                            <option value="editor">Cafeteria Manager</option>
                            <option value="viewer">Delivery Guy</option>
                            <!-- Add more roles as needed -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Payment Methods</label>
                        <div class="payment-methods">
                            <div class="payment-card">
                                <a href="../Payment System/index.php" ><img src="../UserProfile/mpesa.jpeg" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
        // Preview selected profile image
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('profileImagePreview');
                output.src = reader.result;
                // Show the save button once a new image is selected
                document.getElementById('submitPhotoButton').style.display = 'inline-block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        // Handle form submission
        document.getElementById('profileForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.success);
                    location.reload();
                } else {
                    alert(data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the profile picture.');
            });
        });
    </script>
</body>

</html>