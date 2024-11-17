<?php
session_start();


// Check if user data exists in the session
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $name = htmlspecialchars($user['name']);
    $email = htmlspecialchars($user['email']);
    $phone_number = htmlspecialchars($user['phone_number']);
    $student_id = htmlspecialchars($user['student_id'] ?? ''); // Optional field
    $role = htmlspecialchars($user['role'] ?? '');            // Optional field
} else {
    // Redirect to login or registration if session does not exist
    header("Location: ../Registration/index.php");
    exit;
}

// Profile Picture logic
$profilePicture = isset($_SESSION['profile_picture']) ? 'uploads/' . $_SESSION['profile_picture'] : '../UserProfile/cindy.jpeg';

// Determine the home URL based on user role
$homeUrl = '../UserProfile/home.php'; // Default home URL
if (isset($user['role'])) {
    switch ($user['role']) {
        case 'deliverer':
            $homeUrl = '../Delivery/DeliveryHome.php'; // Redirect to deliverer home
            break;
        case 'client':
            $homeUrl = '../Cafeteria/Index page 2/landing.php'; // Redirect to client home
            break;
    }
}

// Handle Profile Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update name, email, phone, student id, and role
    $updatedName = $_POST['name'] ?? '';
    $updatedEmail = $_POST['email'] ?? '';
    $updatedPhoneNumber = $_POST['phone_number'] ?? '';
    $updatedStudentId = $_POST['student_id'] ?? '';
    $updatedRole = $_POST['role'] ?? '';

    // Update the session with new values
    $_SESSION['user']['name'] = $updatedName;
    $_SESSION['user']['email'] = $updatedEmail;
    $_SESSION['user']['phone_number'] = $updatedPhoneNumber;
    $_SESSION['user']['student_id'] = $updatedStudentId;
    $_SESSION['user']['role'] = $updatedRole;

    // Handle Profile Picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $profilePictureName = $_FILES['profile_picture']['name'];
        $profilePicturePath = 'uploads/' . $profilePictureName;
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profilePicturePath);

        // Update session with new profile picture
        $_SESSION['profile_picture'] = $profilePictureName;
        $profilePicture = $profilePicturePath; // Update the displayed profile picture
    }

    // After updating, you can redirect or show a success message
    header("Location: profile.php"); // Redirect to the same page to see updated details
    exit;
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
                    <li><a href="<?php echo $homeUrl; ?>">Home</a></li>
                    <li><a href="#wallet">Wallet</a></li>
                    <li><a href="#order-now">Order Now</a></li>
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
                    <button class="btn btn-primary" type="submit" form="profileForm">Save</button>
                </div>
            </div>

            <div class="profile-section">
                <div class="left-section">
                    <div class="profile-photo">
                        <!-- Display Current Profile Image -->
                        <img id="profileImagePreview" src="<?php echo $profilePicture; ?>" alt="profile_picture"/>

                        <!-- Change Photo Form -->
                        <form id="profileForm" action="../User/profile.php" method="POST" enctype="multipart/form-data">
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
                        <label>Name</label>
                        <input type="text" class="form-control" value="<?php echo $name; ?>" name="name">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" placeholder="eg. kevinmorel@gmail.com" value="<?php echo $email; ?>" name="email">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="tel" class="form-control" placeholder="eg. +254 759 074 192" value="<?php echo $phone_number; ?>" name="phone_number">
                    </div>
                </div>

                <div class="right-section">
                    <!-- Right Section Form Groups -->
                    <div class="form-group">
                        <label>Student id (if applicable)</label>
                        <input type="text" class="form-control" value="<?php echo $student_id; ?>" name="student_id">
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select class="form-control" name="role" id="role">
                            <option value="">Select a role</option>
                            <option value="user" <?php echo $role === 'user' ? 'selected' : ''; ?>>Client</option>
                            <option value="viewer" <?php echo $role === 'viewer' ? 'selected' : ''; ?>>Deliverer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Payment Methods</label>
                        <div class="payment-methods">
                            <div class="payment-card">
                                <a href="../Payment System/Payment System/index.php"><img src="../UserProfile/mpesa.jpeg" alt=""></a>
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
            reader.onload = function () {
                const output = document.getElementById('profileImagePreview');
                output.src = reader.result;
                // Show the save button once a new image is selected
                document.getElementById('submitPhotoButton').style.display = 'inline-block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>