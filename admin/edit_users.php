<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "strath_eats";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = "SELECT name, email, role, phone_number, student_id 
              FROM users 
              WHERE user_id = $id";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
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
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $role = $conn->real_escape_string($_POST['role']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $student_id = $conn->real_escape_string($_POST['student_id']);

    $update_user_query = "UPDATE users 
                          SET name='$name', email='$email', role='$role', 
                              phone_number='$phone_number', student_id='$student_id' 
                          WHERE user_id = $id";

    if ($conn->query($update_user_query) === TRUE) {
   
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
        <form action="edit_users.php?id=<?php echo $id; ?>" method="post">
            <div class="input-box">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="input-box">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="input-box">
                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="User" <?php echo ($user['role'] == 'User') ? 'selected' : ''; ?>>User</option>
                    <option value="Cafeteria_Manager" <?php echo ($user['role'] == 'Cafeteria_Manager') ? 'selected' : ''; ?>>Cafeteria Manager</option>
                    <option value="Deliverer" <?php echo ($user['role'] == 'Deliverer') ? 'selected' : ''; ?>>Deliverer</option>
                    <option value="Admin" <?php echo ($user['role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>
            <div class="input-box">
                <label for="phone_number">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
            </div>
            <div class="input-box">
                <label for="student_id">Student ID:</label>
                <input type="text" id="student_id" name="student_id" value="<?php echo htmlspecialchars($user['student_id']); ?>" required>
            </div>
            <div>
                <button type="submit" class="btn">Update</button>
            </div>
        </form>
    </div>
</body>
</html>
