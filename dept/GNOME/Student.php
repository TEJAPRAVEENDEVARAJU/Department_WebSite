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

// Initialize variables
$student_id = $name = $email = $phone_number = "";
$questions = [];
$message = "";
$popup_message = "";

// Handle student registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'], $_POST['name'], $_POST['email'], $_POST['phone_number'])) {
    $student_id = htmlspecialchars($_POST['student_id']);
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone_number = htmlspecialchars($_POST['phone_number']);

    // Check if student already exists
    $stmt = $conn->prepare("SELECT id FROM students WHERE id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $popup_message = "Exam already taken. Please contact the administrator.";
    } else {
        // Insert student
        $stmt = $conn->prepare("INSERT INTO students (id, name, email, phone_number) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $student_id, $name, $email, $phone_number);
        $stmt->execute();
        $stmt->close();

        // Fetch exam settings
        $exam_settings = $conn->query("SELECT exam_duration, question_limit FROM exam_settings WHERE id = 1")->fetch_assoc();
        $exam_duration = $exam_settings['exam_duration']; // in minutes
        $question_limit = $exam_settings['question_limit'];

        // Fetch random questions (MCQ, Coding MCQ, True/False)
        $result = $conn->query("SELECT id, question_title, type FROM questions WHERE type IN ('MCQ','Coding MCQ','True/False') ORDER BY RAND() LIMIT $question_limit");
        $question_ids = [];
        while ($row = $result->fetch_assoc()) {
            $qid = (int)$row['id'];
            $questions[$qid] = [
                'title' => $row['question_title'],
                'type' => $row['type'],
                'options' => []
            ];
            $question_ids[] = $qid;
        }

        // Fetch options for MCQ & Coding MCQ
        if (!empty($question_ids)) {
            $ids_str = implode(",", array_map('intval', $question_ids));
            $opt_res = $conn->query("
                SELECT o.question_id, o.option_text
                FROM options o
                JOIN questions q ON o.question_id = q.id
                WHERE o.question_id IN ($ids_str)
                  AND q.type IN ('MCQ', 'Coding MCQ')
            ");
            while ($opt = $opt_res->fetch_assoc()) {
                $qid = (int)$opt['question_id'];
                if (isset($questions[$qid])) {
                    $questions[$qid]['options'][] = $opt['option_text'];
                }
            }
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Exam</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>

<style>
body { background: #f6f9fc; }
pre { background: #f0f0f0; padding: 10px; border-radius: 5px; overflow-x: auto; white-space: pre-wrap; }
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
// Timer & fullscreen settings
let examDuration = <?php echo isset($exam_duration) ? $exam_duration*60 : 0; ?>; // seconds
let fullscreenExitCount = 0;
const maxFullscreenExits = 5;
let timer;

function startTimer() {
    const display = document.getElementById('countdown');
    timer = setInterval(() => {
        let min = Math.floor(examDuration / 60);
        let sec = examDuration % 60;
        display.textContent = `${min}m ${sec}s`;
        if (examDuration <= 0) {
            clearInterval(timer);
            alert("Time's up! Submitting exam...");
            document.getElementById('examForm').submit();
        } else examDuration--;
    }, 1000);
}

// Force fullscreen
function enableFullScreen() {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen().catch(()=>{console.log("Fullscreen required");});
    }
}

document.addEventListener("fullscreenchange", () => {
    if (!document.fullscreenElement) {
        fullscreenExitCount++;
        alert(`Full-screen required! ${maxFullscreenExits - fullscreenExitCount} attempts left.`);
        if (fullscreenExitCount >= maxFullscreenExits) {
            alert("Too many fullscreen exits. Exam terminated.");
            window.location.href = "student_login.php";
        }
    }
});

// Disable copy/paste/context menu/select
['copy','paste','contextmenu','selectstart'].forEach(evt => {
    document.addEventListener(evt, e=>e.preventDefault());
});

window.onload = () => {
    enableFullScreen();
    startTimer();
};
</script>
</head>
<body>
<header class="bg-primary text-white text-center py-3"><h1>Student Exam</h1></header>

<main class="container mt-4">
<?php if(empty($questions)): ?>
<section class="card p-4">
<h2 class="text-center mb-4">Enter Student Details</h2>
<?php if($message): ?><div class="alert alert-danger"><?php echo $message; ?></div><?php endif; ?>
<form method="POST">
<div class="mb-3"><label class="form-label">Student ID</label><input type="text" name="student_id" class="form-control" required></div>
<div class="mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" required></div>
<div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
<div class="mb-3"><label class="form-label">Phone</label><input type="text" name="phone_number" class="form-control" required></div>
<button type="submit" class="btn btn-primary w-100">Start Exam</button>
</form>
</section>
<?php else: ?>
<section class="card p-4">
<h2 class="text-center mb-4">Answer Questions</h2>
<div class="text-center mb-3">
<h4>Time Remaining: <span id="countdown"><?php echo $exam_duration; ?>m 0s</span></h4>
</div>
<div class="watermark"><?php echo $student_id; ?></div>

<form method="POST" action="submit_answers.php" id="examForm">
<input type="hidden" name="student_id" value="<?php echo $student_id; ?>">

<?php $counter=1; foreach($questions as $qid=>$q): ?>
<div class="mb-4">
<h5>Q<?php echo $counter; ?> [<?php echo $q['type']; ?>]:</h5>

<!-- Always show question title -->
<?php if($q['type'] == "Coding MCQ"): ?>
<pre><code class="language-php"><?php echo htmlspecialchars($q['title']); ?></code></pre>
<?php else: ?>
<p><?php echo htmlspecialchars($q['title']); ?></p>
<?php endif; ?>

<!-- Display options for MCQ or Coding MCQ -->
<?php if(!empty($q['options'])): ?>
    <?php foreach($q['options'] as $opt): ?>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="answers[<?php echo $qid; ?>]" value="<?php echo htmlspecialchars($opt); ?>" required>
        <label class="form-check-label"><?php echo htmlspecialchars($opt); ?></label>
    </div>
    <?php endforeach; ?>
<?php elseif($q['type']=="True/False"): ?>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="answers[<?php echo $qid; ?>]" value="True" required>
        <label class="form-check-label">True</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="answers[<?php echo $qid; ?>]" value="False">
        <label class="form-check-label">False</label>
    </div>
<?php endif; ?>

</div>
<?php $counter++; endforeach; ?>


<button type="submit" class="btn btn-primary w-100">Submit Answers</button>
</form>
</section>
<?php endif; ?>
</main>

<?php if($popup_message): ?>
<script>
alert("<?php echo $popup_message; ?>");
window.location.href = "student_login.php";
</script>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
