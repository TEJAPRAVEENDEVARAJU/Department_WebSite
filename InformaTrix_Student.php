<?php
session_start();

// Redirect to student login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: InformaTrix_student_login.php");
    exit();
}

$host = 'localhost';
$user = 'root';
$password = ''; // Use your database password
$dbname = 'informatrix';
$port = '4306';

$conn = new mysqli($host, $user, $password, $dbname,$port);	

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'], $_POST['name'], $_POST['email'], $_POST['phone_number'])) {
    $student_id = htmlspecialchars($_POST['student_id']);
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone_number = htmlspecialchars($_POST['phone_number']);

    // Check if the student ID already exists
    $check_query = "SELECT id FROM students WHERE id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Student ID already exists
        $message = "Student ID already exists. Please use a different ID.";
        $popup_message = "Exam already taken. Please contact the administrator for assistance.";
    } else {
        // Insert student details into the database
        $insert_query = "INSERT INTO students (id, name, email, phone_number) 
                         VALUES (?, ?, ?, ?)";
    
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ssss", $student_id, $name, $email, $phone_number);
    
        if ($stmt->execute()) {
            // Fetch exam duration
            $exam_settings_query = "SELECT exam_duration FROM exam_settings WHERE id = 1";
            $exam_settings_result = $conn->query($exam_settings_query);
            $exam_settings = $exam_settings_result->fetch_assoc();
            $exam_duration = $exam_settings['exam_duration']; // In minutes
    
            // Fetch questions and options
            $questions_query = "SELECT q.id AS question_id, q.question_title, o.id AS option_id, o.option_text 
                                FROM questions q 
                                JOIN options o ON q.id = o.question_id 
                                ORDER BY q.id";
            $result = $conn->query($questions_query);
    
            $questions = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $questions[$row['question_id']]['title'] = $row['question_title'];
                    $questions[$row['question_id']]['options'][] = [
                        'id' => $row['option_id'],
                        'text' => $row['option_text']
                    ];
                }
            }
        } else {
            $message = "Error inserting student details: " . $stmt->error;
        }
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
    <title>Student Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .watermark {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            font-size: 2rem;
            color: #009;
            pointer-events: none;
        }
    </style>
    <script>
        var examDuration = <?php echo isset($exam_duration) ? $exam_duration * 60 : 0; ?>;
        var timer;

        function startTimer() {
            var countdownDisplay = document.getElementById('countdown');
            var minutes, seconds;

            timer = setInterval(function() {
                minutes = Math.floor(examDuration / 60);
                seconds = examDuration % 60;

                countdownDisplay.textContent = minutes + "m " + seconds + "s";

                if (examDuration <= 0) {
                    clearInterval(timer);
                    document.getElementById('examForm').submit(); // Auto-submit the form when time's up
                } else {
                    examDuration--;
                }
            }, 1000);
        }

        window.onload = startTimer; // Start the timer when the page loads
    </script>
</head>
<body>
    <header class="bg-primary text-white text-center py-3">
        <h1><i class="fas fa-user-graduate"></i> Student Page</h1>
    </header>
    <main class="container mt-4">
        <?php if (!isset($student_id)): ?>
            <section class="card p-4">
                <h2 class="card-title text-center mb-4">Enter Student Details</h2>
                <?php if (isset($message)): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

                <form method="POST" action="InformaTrix_Student.php">
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Student ID:</label>
                        <input type="text" id="student_id" name="student_id" class="form-control" placeholder="Enter your Student ID" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter your Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number:</label>
                        <input type="text" id="phone_number" name="phone_number" class="form-control" placeholder="Enter your Phone Number" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </form>
            </section>
        <?php else: ?>
            <section class="card p-4">
                <h2 class="card-title text-center mb-4">Answer Questions</h2>

                <div class="text-center mb-4">
                    <h4>Time Remaining: <span id="countdown"><?php echo $exam_duration; ?>m 0s</span></h4>
                </div>

                <div class="watermark"><?php echo $student_id; ?></div>

                <form method="POST" action="InformaTrix_submit_answers.php" id="examForm">
                    <!-- Student ID -->
                    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">

                    <!-- Questions and Options -->
                    <?php foreach ($questions as $question_id => $question): ?>
                        <div class="mb-4">
                            <h5><?php echo $question['title']; ?></h5>
                            <?php foreach ($question['options'] as $option): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="answers[<?php echo $question_id; ?>]" id="option_<?php echo $option['id']; ?>" value="<?php echo $option['text']; ?>" required>
                                    <label class="form-check-label" for="option_<?php echo $option['id']; ?>">
                                        <?php echo $option['text']; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>

                    <button type="submit" name="submit_answers" class="btn btn-primary w-100">Submit Answers</button>
                </form>
            </section>
        <?php endif; ?>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <?php if (isset($popup_message)): ?>
    <script>
        window.onload = function() {
            alert("<?php echo $popup_message; ?>");
            window.location.href = "student_login.php";
        };
    </script>
<?php endif; ?>

</body>
</html>
