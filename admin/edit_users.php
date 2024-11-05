<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT u.fname, u.sname, u.email, u.password, ut.user_type 
              FROM users u
              JOIN user_types ut ON u.id = ut.user_id
              WHERE u.id = $id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit();
    }
} else {
    echo "No user ID provided.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $sname = $_POST['sname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    $update_user_query = "UPDATE users SET fname='$fname', sname='$sname', email='$email', password='$password' WHERE id=$id";
    $update_type_query = "UPDATE user_types SET user_type='$user_type' WHERE user_id=$id";

    if ($conn->query($update_user_query) === TRUE && $conn->query($update_type_query) === TRUE) {
        echo "User updated successfully.";
        header("Location: display_users.php");
        exit();
    } else {
        echo "Error updating user: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="edit_user.css">
</head>
<body>
    <div class="wrapper">
        <h1>Edit User</h1>
        <form action="edit_user.php?id=<?php echo $id; ?>" method="post">
            <div class="input-box">
                <label for="fname">First Name:</label>
                <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($user['fname']); ?>" required>
            </div>
            <div class="input-box">
                <label for="sname">Last Name:</label>
                <input type="text" id="sname" name="sname" value="<?php echo htmlspecialchars($user['sname']); ?>" required>
            </div>
            <div class="input-box">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="input-box">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($user['password']); ?>" required>
            </div>
            <div class="input-box">
                <label for="phone_number">Phone Number:</label>
                <input type="phone_number" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
            </div>
            <div class="input-box">
                <label for="student_id">Student ID:</label>
                <input type="student_id" id="student_id" name="student_id" value="<?php echo htmlspecialchars($user['student_id']); ?>" required>
            </div>
            <div class="input-box">
                <label for="user_type">User Type:</label>
                <select id="user_type" name="user_type" required>
                    <option value="Student" <?php echo ($user['user_type'] == 'Student') ? 'selected' : ''; ?>>Student</option>
                    <option value="Cafeteria_Manager" <?php echo ($user['user_type'] == 'Cafeteria_Manager') ? 'selected' : ''; ?>>Cafeteria_Manager</option>
                </select>
            </div>
            <div>
                <button type="submit" class="btn">Update</button>
            </div>
        </form>
    </div>
</body>
</html>
