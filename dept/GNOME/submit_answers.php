<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: student_login.php");
    exit();
}

// Database connection
$host = 'sql211.infinityfree.com';
$user = 'if0_39030192';
$password = 'sUheL4DCaoSn';
$dbname = 'if0_39030192_gnome';
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$message = "";
$success = false;

// Check POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'], $_POST['answers'])) {
    $student_id = htmlspecialchars($_POST['student_id']);
    $answers = $_POST['answers']; // question_id => selected_option

    // Check if student exists
    $stmt = $conn->prepare("SELECT id FROM students WHERE id=?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $message = "Student not found. Please register first.";
        $success = false;
    } else {
        // Check if already submitted
        $check_result = $conn->prepare("SELECT id FROM results WHERE student_id=?");
        $check_result->bind_param("s", $student_id);
        $check_result->execute();
        $check_result->store_result();

        if ($check_result->num_rows > 0) {
            $message = "You have already submitted the exam.";
            $success = false;
        } else {
            $score = 0;

            // Insert student answers and calculate score
            foreach ($answers as $qid => $opt) {
                $qid = (int)$qid;
                $opt = htmlspecialchars($opt);

                // Insert answer
                $insert = $conn->prepare("INSERT INTO student_answers (student_id, question_id, selected_option) VALUES (?, ?, ?)");
                $insert->bind_param("sis", $student_id, $qid, $opt);
                $insert->execute();
                $insert->close();

                // Get correct answer
                $correct_stmt = $conn->prepare("SELECT correct_answer FROM questions WHERE id=?");
                $correct_stmt->bind_param("i", $qid);
                $correct_stmt->execute();
                $correct_stmt->bind_result($correct_answer);
                $correct_stmt->fetch();
                $correct_stmt->close();

                if ($opt === $correct_answer) $score++;
            }

            // Save result
            $res_insert = $conn->prepare("INSERT INTO results (student_id, score) VALUES (?, ?)");
            $res_insert->bind_param("si", $student_id, $score);
            $res_insert->execute();
            $res_insert->close();

            $message = "Exam submitted successfully! Your score: $score / ".count($answers);
            $success = true;
        }
        $check_result->close();
    }
    $stmt->close();
} else {
    $message = "Invalid request. Please fill all answers.";
    $success = false;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Exam Submission</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="alert <?php echo $success ? 'alert-success' : 'alert-danger'; ?>">
        <?php echo $message; ?>
    </div>
    <a href="student_login.php" class="btn btn-primary">Return to Login</a>
</div>
</body>
</html>
