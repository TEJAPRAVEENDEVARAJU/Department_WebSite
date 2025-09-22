<?php
session_start();

// Database connection
$host = 'localhost';
$user = 'root';
$password_db = ''; // Your database password
$dbname = 'IDCC';
$port = '4306';

$conn = new mysqli($host, $user, $password_db, $dbname,$port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Query to get the password for the given username
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];

        // Check if the stored password is hashed or plain text
        if (password_verify($password, $storedPassword)) {
            // Password is correct (hashed password)
            $_SESSION['username'] = $username;
            header("Location: IDCC_student.php");
            exit();
        } else {
            // Check if it's a plain-text password match
            if ($password === $storedPassword) {
                // Password is correct (plain text)
                $_SESSION['username'] = $username;
                header("Location: IDCC_student.php");
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        }
    } else {
        $error = "Invalid username or password.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('IDCC.png'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 40vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.96); /* Optional: Adds a slight background color for readability */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
 
    <div class="container mt-5">
        <h2 class="text-center">Student Login</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>
