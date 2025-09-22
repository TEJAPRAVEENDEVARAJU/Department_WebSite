<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['employee_name'])) {
    header("Location: login.php");
    exit();
}
// Start the session and set cache headers
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
// Handle logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: Main.php");
    exit();
}

// Database connection setup
$host = 'localhost';
$user = 'root';
$password = ''; // Use your database password
$dbname = 'informatrix';
$port = '4306';

$conn = new mysqli($host, $user, $password, $dbname,$port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Fetch Results
$results = $conn->query("
    SELECT s.id AS student_id, s.name, s.phone_number, s.email,
    SUM(CASE WHEN sa.selected_option = q.correct_answer THEN 1 ELSE 0 END) AS score
    FROM students s
    LEFT JOIN student_answers sa ON s.id = sa.student_id
    LEFT JOIN questions q ON sa.question_id = q.id
    GROUP BY s.id
");

// Handle CSV Download
if (isset($_GET['download_csv'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="exam_results.csv"');
    $output = fopen('php://output', 'w');

    // Add headers
    fputcsv($output, ['Student ID', 'Name', 'Phone Number', 'Email', 'Score']);

    // Add rows
    while ($row = $results->fetch_assoc()) {
        fputcsv($output, [$row['student_id'], $row['name'], $row['phone_number'], $row['email'], $row['score']]);
    }

    fclose($output);
    exit();
}
// Add a user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Hash the password for security

    if (!empty($username) && !empty($password)) {
        // Check if the user already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "User already exists!";
        } else {
            // Add the user if not exists
            $stmt = $conn->prepare("INSERT INTO users (id, username, password, created_at) VALUES (UUID(), ?, ?, CURRENT_TIMESTAMP)");
            $stmt->bind_param("ss", $username, $hashed_password);
            if ($stmt->execute()) {
                $message = "User added successfully!";
            } else {
                $message = "Error adding user.";
            }
            $stmt->close();
        }
    } else {
        $message = "Please fill in all fields.";
    }
}



// Add a question
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_question'])) {
    $question_title = htmlspecialchars($_POST['question_title']);
    $correct_answer = htmlspecialchars($_POST['correct_answer']);
    $options = $_POST['options'];

    if (!empty($question_title) && !empty($correct_answer) && count($options) == 4) {
        $stmt = $conn->prepare("INSERT INTO questions (question_title, correct_answer) VALUES (?, ?)");
        $stmt->bind_param("ss", $question_title, $correct_answer);
        if ($stmt->execute()) {
            $question_id = $stmt->insert_id;
            $stmt->close();

            $stmt = $conn->prepare("INSERT INTO options (question_id, option_text) VALUES (?, ?)");
            foreach ($options as $option) {
                $stmt->bind_param("is", $question_id, $option);
                $stmt->execute();
            }
            $stmt->close();
            $message = "Question added successfully!";
        } else {
            $message = "Error adding question.";
        }
    } else {
        $message = "Please fill in all fields correctly.";
    }
}

// Update exam settings
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_settings'])) {
    $exam_duration = intval($_POST['exam_duration']);
    $question_limit = intval($_POST['question_limit']);

    $stmt = $conn->prepare("UPDATE exam_settings SET exam_duration = ?, question_limit = ? WHERE id = 1");
    $stmt->bind_param("ii", $exam_duration, $question_limit);
    if ($stmt->execute()) {
        $message = "Settings updated successfully!";
    } else {
        $message = "Error updating settings.";
    }
    $stmt->close();
}

// Delete a question
if (isset($_GET['delete_question'])) {
    $question_id = intval($_GET['delete_question']);
    $stmt = $conn->prepare("DELETE FROM options WHERE question_id = ?");
    $stmt->bind_param("i", $question_id);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM questions WHERE id = ?");
    $stmt->bind_param("i", $question_id);
    $stmt->execute();

    $message = "Question deleted successfully!";
}

// Fetch data
$settings = $conn->query("SELECT * FROM exam_settings WHERE id = 1")->fetch_assoc();
$questions = $conn->query("SELECT * FROM questions");
$users = $conn->query("SELECT * FROM users");
$results = $conn->query("
    SELECT s.id AS student_id, s.name, s.phone_number, s.email,
    SUM(CASE WHEN sa.selected_option = q.correct_answer THEN 1 ELSE 0 END) AS score
    FROM students s
    LEFT JOIN student_answers sa ON s.id = sa.student_id
    LEFT JOIN questions q ON sa.question_id = q.id
    GROUP BY s.id
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-primary text-white d-flex justify-content-between px-3 py-3">
        <h1 class="m-0"><i class="fas fa-tools"></i> Admin Panel</h1>
        <a href="?logout=true" class="btn btn-danger btn-sm">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </header>
    <main class="container mt-4">
        <?php if (isset($message)): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Exam Settings -->
        <section class="card p-4 mb-4">
            <h2 class="card-title text-center mb-4"><i class="fas fa-cog"></i> Exam Settings</h2>
            <form method="POST">
                <div class="mb-3">
                    <label for="exam_duration" class="form-label">Exam Duration (minutes):</label>
                    <input type="number" id="exam_duration" name="exam_duration" class="form-control" value="<?php echo $settings['exam_duration']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="question_limit" class="form-label">Number of Questions:</label>
                    <input type="number" id="question_limit" name="question_limit" class="form-control" value="<?php echo $settings['question_limit']; ?>" required>
                </div>
                <button type="submit" name="update_settings" class="btn btn-primary w-100">Save Settings</button>
            </form>
        </section>

        <!-- Add User -->
<section class="card p-4 mb-4">
    <h2 class="card-title text-center mb-4"><i class="fas fa-user-plus"></i> Add User</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <button type="submit" name="add_user" class="btn btn-primary w-100">Add User</button>
    </form>
</section>


        <!-- Add Question -->
        <section class="card p-4 mb-4">
            <h2 class="card-title text-center mb-4"><i class="fas fa-question-circle"></i> Add Question</h2>
            <form method="POST">
                <div class="mb-3">
                    <label for="question_title" class="form-label">Question Title:</label>
                    <textarea id="question_title" name="question_title" class="form-control" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="correct_answer" class="form-label">Correct Answer:</label>
                    <input type="text" id="correct_answer" name="correct_answer" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Options:</label>
                    <div class="input-group mb-2">
                        <span class="input-group-text">Option 1</span>
                        <input type="text" name="options[]" class="form-control" required>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text">Option 2</span>
                        <input type="text" name="options[]" class="form-control" required>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text">Option 3</span>
                        <input type="text" name="options[]" class="form-control" required>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text">Option 4</span>
                        <input type="text" name="options[]" class="form-control" required>
                    </div>
                </div>
                <button type="submit" name="add_question" class="btn btn-primary w-100">Add Question</button>
            </form>
        </section>

        <!-- Manage Questions -->
        <section class="card p-4 mb-4">
            <h2 class="card-title text-center mb-4"><i class="fas fa-list"></i> Manage Questions</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Question</th>
                        <th>Correct Answer</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $questions->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['question_title']; ?></td>
                            <td><?php echo $row['correct_answer']; ?></td>
                            <td>
                                <a href="?delete_question=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
        <!-- result -->
        <section class="card p-4 mb-4">
            <h2 class="card-title text-center mb-4"><i class="fas fa-chart-bar"></i> Exam Results</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><i class="fas fa-id-badge"></i> Student ID</th>
                        <th><i class="fas fa-user"></i> Name</th>
                        <th><i class="fas fa-phone"></i> Phone Number</th>
                        <th><i class="fas fa-envelope"></i> Email</th>
                        <th><i class="fas fa-star"></i> Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $results->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['student_id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['phone_number']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['score']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <a href="?download_csv=true" class="btn btn-primary mt-3">
                <i class="fas fa-download"></i> Download CSV
            </a>
        </section>
    </main>
</body>
<script>
    // Show a popup if there's a message from the server
    <?php if (isset($message)): ?>
        alert("<?php echo $message; ?>");
    <?php endif; ?>
</script>
</html>

<?php $conn->close(); ?>
