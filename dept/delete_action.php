<?php
session_start();

$host = 'host';
$user = 'user';
$password = 'password';
$dbname = 'dbname';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'DB Connection Failed']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = $conn->real_escape_string($_POST['id'] ?? '');

    if ($action === 'delete_result' && !empty($id)) {
        $conn->query("DELETE FROM results WHERE student_id='$id'");
        $conn->query("DELETE FROM student_answers WHERE student_id='$id'");
        $conn->query("DELETE FROM students WHERE id='$id'");
        echo json_encode(['status' => 'success', 'message' => 'Result deleted']);
    } 
    elseif ($action === 'delete_question' && !empty($id)) {
        $conn->query("DELETE FROM options WHERE question_id='$id'");
        $conn->query("DELETE FROM questions WHERE id='$id'");
        echo json_encode(['status' => 'success', 'message' => 'Question deleted']);
    }
    else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    }
}

$conn->close();
?>
