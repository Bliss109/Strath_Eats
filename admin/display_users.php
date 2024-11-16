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

$query = "SELECT u.user_id, u.name, u.email, ut.role, u.password, u.phone_number, u.student_id
          FROM users u
          JOIN user_types ut ON u.id = ut.user_id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $users = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $users = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Information</title>
    <link rel="stylesheet" href="display_users.css">
</head>
<body>
    <header id="header">
    </header>
    
    <h1>Users Information</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Password</th>
                <th>Phone Number</th>
                <th>Profile Picture</th>
                <th>Student ID</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($users) > 0): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td><?php echo htmlspecialchars($user['password']); ?></td>
                        <td><?php echo htmlspecialchars($user['phone_number']); ?></td>
                        <?php if (!empty($user['profile_picture'])): ?>
                                <img src="Uploads/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" style="width:25px;height:25px;">
                            <?php else: ?>
                                No image
                            <?php endif; ?>
                        <td><?php echo htmlspecialchars($user['student_id']); ?></td>
                        <td>
                            <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a> | 
                            <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
