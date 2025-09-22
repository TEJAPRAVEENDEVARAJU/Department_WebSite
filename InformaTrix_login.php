<?php
session_start();
$message = "";
//123 asd
// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = htmlspecialchars($_POST['employee_id']);
    $password = htmlspecialchars($_POST['password']);

    // Database connection setup
    $host = "127.0.0.1";
    $user = "root";
    $password_db = ""; // Use your database password
    $dbname = "informatrix";
	$port = '4306';

    $conn = new mysqli($host, $user, $password_db, $dbname,$port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the employee ID exists
    $stmt = $conn->prepare("SELECT * FROM employees WHERE employee_id = ?");
    $stmt->bind_param("s", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Debug: Print the password from the database (optional for debugging)
        // echo "Password from DB: " . $user['password'] . "<br>";
        // echo "Entered password: " . $password . "<br>";

        // Check if the stored password is hashed
        if (password_verify($password, $user['password']) || $password === $user['password']) {
            // Start session and store employee name
            $_SESSION['employee_name'] = $user['name'];
            header("Location: http://localhost/IT_DEPT/InformaTrix_Admin.php");
            exit();
        } else {
            $message = "Incorrect password.";
        }
    } else {
        $message = "Employee ID not found.";
    }

    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
            background-image: url('emp.JPG'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8); /* Optional: Adds a slight background color for readability */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        </style>
</head>
<body>
 
    <div class="container mt-5">
        <h2 class="text-center">Admin Login</h2>

        <?php if ($message): ?>
            <div class="alert alert-danger"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="employee_id" class="form-label">Employee ID:</label>
                <input type="text" id="employee_id" name="employee_id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>
