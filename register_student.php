<?php
session_start();

// Ensure the user is logged in (optional)
if (!isset($_SESSION['employee_name'])) {
    header("Location: admin_login.php"); // Adjusted for admin login
    exit();
}

// Database connection setup
$host = 'localhost';
$user = 'root';
$password = ''; // Use your database password
$dbname = 'informatrix';
$port='4306';

$conn = new mysqli($host, $user, $password, $dbname,$port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle student registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_student'])) {
    $student_id = htmlspecialchars($_POST['student_id']);
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);

    // Validate inputs
    if (!empty($student_id) && !empty($name) && !empty($email) && !empty($phone)) {
        // Insert student into the students table
        $stmt = $conn->prepare("INSERT INTO students (id, name, email, phone_number) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $student_id, $name, $email, $phone);

        if ($stmt->execute()) {
            $message = "Student registered successfully!";
        } else {
            $message = "Error registering student. Please try again.";
        }
        $stmt->close();
    } else {
        $message = "Please fill in all fields.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-user-plus"></i> Student Registration</h2>
            <button class="btn btn-secondary" onclick="goToAdminPanel()">
                <i class="fas fa-arrow-left"></i> Go to Admin Panel
            </button>
        </div>
        <?php if (isset($message)): ?>
            <div class="alert <?php echo strpos($message, 'successfully') !== false ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="student_id" class="form-label"><i class="fas fa-id-card"></i> Student ID</label>
                <input type="text" class="form-control" id="student_id" name="student_id" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label"><i class="fas fa-user"></i> Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label"><i class="fas fa-phone"></i> Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <button type="submit" name="register_student" class="btn btn-primary"><i class="fas fa-save"></i> Register Student</button>
        </form>
    </div>

    <!-- JavaScript -->
    <script>
        function goToAdminPanel() {
            console.log('Navigating to Admin Panel');
            window.location.href = "admin.php"; // Correct path to admin panel
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
