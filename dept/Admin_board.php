<?php
session_start();
$message = "";

// ✅ Check Login
if (!isset($_SESSION['employee_name'])) {
    header("Location: login.php");
    exit();
}

// ✅ Database Connection
$host = 'sql211.infinityfree.com';
$user = 'if0_39030192';
$password = 'sUheL4DCaoSn';
$dbname = 'if0_39030192_infomatrix';
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// ✅ Exam Settings Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_settings'])) {
    $exam_duration = intval($_POST['exam_duration']);
    $question_limit = intval($_POST['question_limit']);
    $stmt = $conn->prepare("UPDATE exam_settings SET exam_duration=?, question_limit=? WHERE id=1");
    $stmt->bind_param("ii", $exam_duration, $question_limit);
    $stmt->execute();
    $_SESSION['message'] = "Exam settings updated successfully!";
    $stmt->close();
}

// ✅ Generate Users
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate_users'])) {
    $user_count = intval($_POST['user_count']);
    $user_data = [];
    if ($user_count > 0) {
        for ($i = 0; $i < $user_count; $i++) {
            $username = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 2)) . strtolower(substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 2));
            $password_plain = strtolower(substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 2)) . rand(10, 99);
            $password_hashed = password_hash($password_plain, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO users (id, username, password, created_at) VALUES (UUID(), ?, ?, CURRENT_TIMESTAMP)");
            $stmt->bind_param("ss", $username, $password_hashed);
            $stmt->execute();
            $stmt->close();
            $user_data[] = [$username, $password_plain];
        }
        $_SESSION['generated_users'] = $user_data;
        $_SESSION['message'] = "Users generated successfully!";
    } else {
        $_SESSION['message'] = "Please enter a valid user count.";
    }
}

// ✅ Delete All Users
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_users'])) {
    $conn->query("DELETE FROM users");
    unset($_SESSION['generated_users']);
    $_SESSION['message'] = "All users deleted successfully!";
}

// ✅ Download Generated Users CSV
if (isset($_GET['download_users_csv'])) {
    if (isset($_SESSION['generated_users'])) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="generated_users.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Username', 'Password']);
        foreach ($_SESSION['generated_users'] as $u) fputcsv($output, $u);
        fclose($output);
        exit();
    } else {
        $_SESSION['message'] = "No users available to download.";
    }
}

// ✅ Add Question Manually
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_question'])) {
    $question_title = $_POST['question_title'];
    $correct_answer = $_POST['correct_answer'];
    $options = $_POST['options'];
    $type = $_POST['question_type'];
    // Insert question
    $stmt = $conn->prepare("INSERT INTO questions (question_title, correct_answer, type) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $question_title, $correct_answer, $type);
    if ($stmt->execute()) {
        $qid = $stmt->insert_id;
        $stmt->close();
       if($type == 'MCQ' || $type == 'Coding MCQ') {
    $stmt = $conn->prepare("INSERT INTO options (question_id, option_text) VALUES (?, ?)");
    foreach ($options as $opt) {
        if(!empty(trim($opt))){ // Skip empty options
            $stmt->bind_param("is", $qid, $opt);
            $stmt->execute();
        }
    }
    $stmt->close();
}

        $_SESSION['message'] = "Question added successfully!";
    } else {
        $_SESSION['message'] = "Error adding question.";
    }
}

// ✅ Delete Single Result (works safely with FK)
if (isset($_GET['delete_result'])) {
    $student_id = $conn->real_escape_string($_GET['delete_result']);

    // Delete from related tables first
    $conn->query("DELETE FROM results WHERE student_id='$student_id'");
    $conn->query("DELETE FROM student_answers WHERE student_id='$student_id'");
    $conn->query("DELETE FROM students WHERE id='$student_id'");

    $_SESSION['message'] = "Student result deleted successfully!";
    header("Location: Admin_board.php");
    exit();
}

// ✅ Delete All Results
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_all_results'])) {
    // Delete child tables first
    $conn->query("DELETE FROM results");
    $conn->query("DELETE FROM student_answers");
    $conn->query("DELETE FROM students");

    $_SESSION['message'] = "All results deleted successfully!";
    header("Location: Admin_board.php");
    exit();
}

// ✅ Download Exam Results CSV
if (isset($_GET['download_csv'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="exam_results.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Student ID', 'Name', 'Phone', 'Email', 'Score']);
    $res = $conn->query("
        SELECT s.id, s.name, s.phone_number, s.email,
        SUM(CASE WHEN sa.selected_option=q.correct_answer THEN 1 ELSE 0 END) AS score
        FROM students s
        LEFT JOIN student_answers sa ON s.id=sa.student_id
        LEFT JOIN questions q ON sa.question_id=q.id
        GROUP BY s.id
    ");
    while ($r = $res->fetch_assoc()) fputcsv($output, $r);
    fclose($output);
    exit();
}

// ✅ Fetch Data
$settings = $conn->query("SELECT * FROM exam_settings WHERE id=1")->fetch_assoc();

// Pagination for questions
$limit = 20;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Question counts
$count_mcq = $conn->query("SELECT COUNT(*) as c FROM questions WHERE type='MCQ'")->fetch_assoc()['c'];
$count_tf = $conn->query("SELECT COUNT(*) as c FROM questions WHERE type='TrueFalse'")->fetch_assoc()['c'];
$count_desc = $conn->query("SELECT COUNT(*) as c FROM questions WHERE type='Descriptive'")->fetch_assoc()['c'];
$count_coding = $conn->query("SELECT COUNT(*) as c FROM questions WHERE type='Coding'")->fetch_assoc()['c'];

// Fetch questions with pagination
$questions = $conn->query("SELECT * FROM questions ORDER BY id DESC LIMIT $limit OFFSET $offset");
$total_questions = $conn->query("SELECT COUNT(*) as c FROM questions")->fetch_assoc()['c'];
$total_pages = ceil($total_questions / $limit);

// ✅ Fetch & Manage Results with Search, Filter, Pagination

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$min_score = isset($_GET['min_score']) ? intval($_GET['min_score']) : 0;
$max_score = isset($_GET['max_score']) ? intval($_GET['max_score']) : 100;
$page = isset($_GET['rpage']) ? intval($_GET['rpage']) : 1;
$r_limit = 15;
$r_offset = ($page - 1) * $r_limit;

// Base query
$query = "
    SELECT s.id, s.name, s.phone_number, s.email,
    SUM(CASE WHEN sa.selected_option=q.correct_answer THEN 1 ELSE 0 END) AS score
    FROM students s
    LEFT JOIN student_answers sa ON s.id=sa.student_id
    LEFT JOIN questions q ON sa.question_id=q.id
";

// Apply search or filter
$where = [];
if ($search !== '') {
    $s = $conn->real_escape_string($search);
    $where[] = "(s.name LIKE '%$s%' OR s.email LIKE '%$s%' OR s.phone_number LIKE '%$s%')";
}
$where_sql = count($where) ? "WHERE " . implode(' AND ', $where) : '';

$query .= " $where_sql GROUP BY s.id HAVING score BETWEEN $min_score AND $max_score";
$total_res = $conn->query($query);
$total_rows = $total_res->num_rows;
$total_pages_r = ceil($total_rows / $r_limit);

$query .= " LIMIT $r_limit OFFSET $r_offset";
$results = $conn->query($query);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_all_questions'])) {
    $conn->query("DELETE FROM options");
    $conn->query("DELETE FROM questions");
    $_SESSION['message'] = "All questions deleted successfully!";
    header("Location: Admin_board.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel - Infomatrix</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
body { background: #f6f9fc; transition: 0.3s; }
header { background: linear-gradient(90deg, #0062E6, #33AEFF); color: white; }
.card { border-radius: 15px; transition: 0.3s; }
.btn-primary { background-color: #007BFF; }
.dark-mode { background: #121212; color: #eee; }
.dark-mode header { background: #1f1f1f; color: #fff; }
.dark-mode .card { background: #1e1e1e; color: #fff; }
.dark-mode .table { color: #fff; }
</style>
</head>
<body>
<header class="p-3 d-flex justify-content-between align-items-center">
    <h3><i class="fas fa-tools"></i> Admin Dashboard</h3>
    <div>
        <button id="toggleDark" class="btn btn-secondary btn-sm me-2"><i class="fas fa-moon"></i> Dark/Light</button>
        <a href="?logout=true" class="btn btn-danger btn-sm"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</header>
<div class="container my-4">

<?php if (isset($_SESSION['message'])): ?>
<div class="alert alert-success"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
<?php endif; ?>

<!-- Exam Settings -->
<section class="card p-4 mb-4 shadow">
<h4><i class="fas fa-cog"></i> Exam Settings</h4>
<form method="POST">
<div class="mb-3">
<label>Exam Duration (mins):</label>
<input type="number" name="exam_duration" class="form-control" value="<?php echo $settings['exam_duration']; ?>" required>
</div>
<div class="mb-3">
<label>Number of Questions:</label>
<input type="number" name="question_limit" class="form-control" value="<?php echo $settings['question_limit']; ?>" required>
</div>
<button type="submit" name="update_settings" class="btn btn-primary w-100">Update Settings</button>
</form>
</section>

<!-- Generate Users -->
<section class="card p-4 mb-4 shadow">
<h4><i class="fas fa-users"></i> Generate Users</h4>
<form method="POST">
<div class="mb-3">
<label>Number of Users:</label>
<input type="number" name="user_count" class="form-control" required>
</div>
<button type="submit" name="generate_users" class="btn btn-success w-100">Generate Users</button>
</form>
<?php if (isset($_SESSION['generated_users'])): ?>
<a href="?download_users_csv=true" class="btn btn-primary mt-3"><i class="fas fa-download"></i> Download User List (CSV)</a>
<?php endif; ?>
<form method="POST" class="mt-3">
<button type="submit" name="delete_users" onclick="return confirm('Delete all users?')" class="btn btn-danger w-100"><i class="fas fa-trash"></i> Delete All Users</button>
</form>
</section>

<!-- Add Question -->
<section class="card p-4 mb-4 shadow">
<h4><i class="fas fa-question-circle"></i> Add Question</h4>
<form method="POST">
<div class="mb-3">
<label>Question Type:</label>
<select name="question_type" class="form-select" required>
<option value="MCQ">MCQ</option>
<option value="True/False">True/False</option>
<option value="Coding MCQ">Coding MCQ</option>
</select>
</div>
<div class="mb-3">
<label>Question Title:</label>
<textarea name="question_title" class="form-control" required></textarea>
</div>
<div class="mb-3">
<label>Correct Answer:</label>
<input type="text" name="correct_answer" class="form-control" required>
</div>
<div id="mcq-options">
<?php for ($i = 1; $i <= 4; $i++): ?>
<div class="input-group mb-2">
    <span class="input-group-text">Option <?php echo $i; ?></span>
    <textarea name="options[]" class="form-control" rows="2"></textarea>
</div>
<?php endfor; ?>
</div>

<button type="submit" name="add_question" class="btn btn-primary w-100">Add Question</button>
</form>
</section>


 
<!-- Upload Questions -->
<section class="card p-4 mb-4 shadow">
<h4><i class="fas fa-upload"></i> Upload Questions (CSV / Excel)</h4>
<form action="upload_questions.php" method="POST" enctype="multipart/form-data">
<div class="mb-3">
<label>Choose File</label>
<input type="file" name="file" class="form-control" accept=".csv,.xlsx,.xls" required>
</div>
<button type="submit" class="btn btn-success w-100"><i class="fas fa-cloud-upload-alt"></i> Upload</button>
</form>
</section>

<!-- Display Questions -->
<section class="card p-4 mb-4 shadow">
<h4><i class="fas fa-list"></i> Questions</h4>
<!-- Question Search & Counts -->
<?php
$search_q = isset($_GET['q_search']) ? $conn->real_escape_string(trim($_GET['q_search'])) : '';

// Correct counts based on DB
$count_mcq = $conn->query("SELECT COUNT(*) as c FROM questions WHERE type='MCQ'")->fetch_assoc()['c'];
$count_tf = $conn->query("SELECT COUNT(*) as c FROM questions WHERE type='True/False'")->fetch_assoc()['c'];
$count_desc = $conn->query("SELECT COUNT(*) as c FROM questions WHERE type='Descriptive'")->fetch_assoc()['c'];
$count_coding = $conn->query("SELECT COUNT(*) as c FROM questions WHERE type='Coding MCQ'")->fetch_assoc()['c'];
$total_questions = $conn->query("SELECT COUNT(*) as c FROM questions")->fetch_assoc()['c'];
?>

<form method="GET" class="d-flex mb-2">
    <input type="text" name="q_search" value="<?php echo htmlspecialchars($search_q); ?>" class="form-control form-control-sm me-2" placeholder="Search by question title">
    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
</form>

<p class="mb-2">Total Questions: <?php echo $total_questions; ?> | MCQ: <?php echo $count_mcq; ?> | True/False: <?php echo $count_tf; ?> |   | Coding: <?php echo $count_coding; ?></p>

<?php
// Adjust the query for search
$q_where = $search_q ? "WHERE question_title LIKE '%$search_q%'" : "";
$questions = $conn->query("SELECT * FROM questions $q_where ORDER BY id DESC LIMIT $limit OFFSET $offset");
$total_questions = $conn->query("SELECT COUNT(*) as c FROM questions $q_where")->fetch_assoc()['c'];
$total_pages = ceil($total_questions / $limit);
?>

 <form method="POST" class="mb-4">
<button type="submit" name="delete_all_questions" onclick="return confirm('Delete all questions?')" class="btn btn-danger w-100">
<i class="fas fa-trash"></i> Delete All Questions
</button>
</form>

<table class="table table-striped">
<thead><tr><th>ID</th><th>Type</th><th>Question</th><th>Answer</th><th>Actions</th></tr></thead>
<tbody>
<?php 
$start_serial = ($page - 1) * $limit + 1; // Calculate S.No for current page
?>
<?php while ($q = $questions->fetch_assoc()): ?>
<tr>
<td><?php echo $start_serial++; ?></td> <!-- S.No -->
<td><?php echo $q['type']; ?></td>
<td><?php echo $q['question_title']; ?></td>
<td><?php echo $q['correct_answer']; ?></td>
<td>
<button class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $q['id']; ?>" data-type="question">
    <i class="fas fa-trash"></i>
</button>
</td>
</tr>
<?php endwhile; ?>

</tbody>
</table>
<!-- Pagination -->
<nav>
<ul class="pagination">
<?php for($p=1;$p<=$total_pages;$p++): ?>
<li class="page-item <?php if($p==$page) echo 'active'; ?>"><a class="page-link" href="?page=<?php echo $p; ?>"><?php echo $p; ?></a></li>
<?php endfor; ?>
</ul>
</nav>
</section>

<!-- Student Results -->
<section class="card p-4 mb-4 shadow">
<h4><i class="fas fa-chart-bar"></i> Exam Results</h4>

<!-- Search and Filter -->
<form method="GET" class="row g-3 mb-3">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Search by name, email, or phone" value="<?php echo htmlspecialchars($search); ?>">
    </div>
    <div class="col-md-3">
        <input type="number" name="min_score" class="form-control" placeholder="Min Score" value="<?php echo $min_score; ?>">
    </div>
    <div class="col-md-3">
        <input type="number" name="max_score" class="form-control" placeholder="Max Score" value="<?php echo $max_score; ?>">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Search</button>
    </div>
</form>

<form method="POST" class="mb-3">
    <button type="submit" name="delete_all_results" onclick="return confirm('Are you sure you want to delete ALL results?')" class="btn btn-danger w-100">
        <i class="fas fa-trash"></i> Delete All Results
    </button>
</form>

<table class="table table-bordered table-striped">
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Phone</th>
<th>Email</th>
<th>Score</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php if ($results->num_rows > 0): ?>
<?php 
$start_serial_r = ($page - 1) * $r_limit + 1; // Calculate S.No for results pagination
?>
<?php while ($r = $results->fetch_assoc()): ?>
<tr>
<td><?php echo $start_serial_r++; ?></td> <!-- S.No -->
<td><?php echo htmlspecialchars($r['name']); ?></td>
<td><?php echo htmlspecialchars($r['phone_number']); ?></td>
<td><?php echo htmlspecialchars($r['email']); ?></td>
<td><?php echo $r['score']; ?></td>
<td>
   <button class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $r['id']; ?>" data-type="result">
    <i class="fas fa-trash"></i>
</button>
</td>
</tr>
<?php endwhile; ?>

<?php else: ?>
<tr><td colspan="6" class="text-center">No results found.</td></tr>
<?php endif; ?>
</tbody>
</table>

<!-- Pagination -->
<nav>
<ul class="pagination">
<?php for ($rp = 1; $rp <= $total_pages_r; $rp++): ?>
<li class="page-item <?php if ($rp == $page) echo 'active'; ?>">
    <a class="page-link" href="?rpage=<?php echo $rp; ?>&search=<?php echo urlencode($search); ?>&min_score=<?php echo $min_score; ?>&max_score=<?php echo $max_score; ?>">
        <?php echo $rp; ?>
    </a>
</li>
<?php endfor; ?>
</ul>
</nav>

<!-- Export Buttons -->
<div class="mt-3 d-flex gap-2">
    <a href="?download_csv=true" class="btn btn-primary"><i class="fas fa-download"></i> CSV</a>
     
</div>
</section>


</div>

<script>
const toggleBtn = document.getElementById('toggleDark');
toggleBtn.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
});

// ✅ AJAX Delete for Questions and Results
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', async e => {
        if (!confirm('Are you sure you want to delete this item?')) return;
        
        const id = btn.dataset.id;
        const type = btn.dataset.type;

        try {
            const response = await fetch('delete_action.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: new URLSearchParams({ 
                    id: id, 
                    action: type === 'result' ? 'delete_result' : 'delete_question' 
                })
            });
            const data = await response.json();

            if (data.status === 'success') {
                btn.closest('tr').remove();
                alert(data.message);
            } else {
                alert(data.message);
            }
        } catch (err) {
            alert('Error deleting item.');
        }
    });
});
</script>
</body>
</html>

</body>
</html>
<?php $conn->close(); ?>  