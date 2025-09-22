<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_answers'])) {
    $student_id = htmlspecialchars($_POST['student_id']);
    $answers = $_POST['answers']; // Array of question_id => selected_option

    // Validate inputs
    if (!empty($student_id) && !empty($answers)) {
        $success = true;
        $score = 0;

        // Check if the student_id exists in the students table
        $check_student_query = $conn->prepare("SELECT id FROM students WHERE id = ?");
        $check_student_query->bind_param("s", $student_id);
        $check_student_query->execute();
        $check_student_query->store_result();

        if ($check_student_query->num_rows === 0) {
            $success = false;
            $message = "Student ID does not exist. Please register the student first.";
        }

        $check_student_query->close();

        // Insert or update the answers in the student_answers table if the student exists
        if ($success) {
            foreach ($answers as $question_id => $selected_option) {
                // Insert or update the answer in the database
                $stmt = $conn->prepare("
                    INSERT INTO student_answers (student_id, question_id, selected_option)
                    VALUES (?, ?, ?)
                    ON DUPLICATE KEY UPDATE selected_option = VALUES(selected_option)
                ");

                if (!$stmt) {
                    $success = false;
                    break;
                }

                $stmt->bind_param("sis", $student_id, $question_id, $selected_option);
                if (!$stmt->execute()) {
                    $success = false;
                    break;
                }
                $stmt->close();

                // Check if the answer is correct and calculate the score
                $correct_answer_query = $conn->prepare("SELECT correct_answer FROM questions WHERE id = ?");
                $correct_answer_query->bind_param("i", $question_id);
                $correct_answer_query->execute();
                $correct_answer_query->bind_result($correct_answer);
                $correct_answer_query->fetch();
                $correct_answer_query->close();

                if ($selected_option === $correct_answer) {
                    $score++;
                }
            }

            // Store the result in the results table if the student exists
            if ($success) {
                $stmt = $conn->prepare("INSERT INTO results (student_id, score) VALUES (?, ?)");
                $stmt->bind_param("si", $student_id, $score);
                if (!$stmt->execute()) {
                    $success = false;
                }
                $stmt->close();

                // Provide feedback to the user
                if ($success) {
                    $message = "Thank You for taking the test! Your answers have been submitted successfully.Our team will get in touch with you for the futher steps.";
                } else {
                    $message = "An error occurred while submitting your answers. Please try again.";
                }
            }
        }
    } else {
        $message = "Please provide your Student ID and answer all questions.";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Answers</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <?php if (isset($message)): ?>
            <div class="alert <?php echo $success ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <a href="InformaTrix_logout.php" class="btn btn-primary">Logout</a>
    </div>
</body> 
</html>
