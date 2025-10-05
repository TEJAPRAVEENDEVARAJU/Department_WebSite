<?php
session_start();
include 'SimpleXLSX.php';

// ✅ Check login
if (!isset($_SESSION['employee_name'])) {
    header("Location: login.php");
    exit();
}

$host = 'sql211.infinityfree.com';
$udbname'if0_39030192';
$password = 'sUheL4DCaoSn'; // Use your database password
$dbname = 'if0_39030192_idcc';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file']['tmp_name'];
    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

    $rows = [];

    if ($ext === 'csv') {
        if (($handle = fopen($file, "r")) !== false) {
            $first = true;
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if ($first) { $first = false; continue; } // skip header
                $rows[] = $data;
            }
            fclose($handle);
        }
    } elseif (in_array($ext, ['xlsx','xls'])) {
        if ($xlsx = SimpleXLSX::parse($file)) {
            $allRows = $xlsx->rows();
            $rows = array_slice($allRows, 1); // skip header
        } else {
            $_SESSION['message'] = "Error reading Excel: ".SimpleXLSX::parseError();
            header("Location: Admin_board.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Invalid file format! Only CSV or Excel allowed.";
        header("Location: Admin_board.php");
        exit();
    }

    // ✅ Insert questions into DB
    foreach ($rows as $r) {
        $type = $r[0];            // Column A: Question Type (MCQ, TrueFalse, Coding)
        $title = $r[1];           // Column B: Question Title / Code snippet
        $correct = $r[2];         // Column C: Correct Answer
        $options = array_slice($r, 3, 4); // Column D-G: Options (for MCQ)

        $stmt = $conn->prepare("INSERT INTO questions (question_title, correct_answer, type) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $correct, $type);
        if ($stmt->execute()) {
            $qid = $stmt->insert_id;
            $stmt->close();
           if($type == 'MCQ' || $type == 'Coding MCQ') {  // Include Coding type
    $stmt = $conn->prepare("INSERT INTO options (question_id, option_text) VALUES (?, ?)");
    foreach ($options as $opt) {
        if(trim($opt) != '') {  // Skip empty options
            $stmt->bind_param("is", $qid, $opt);
            $stmt->execute();
        }
    }
    $stmt->close();
}

        }
    }

    $_SESSION['message'] = "Questions uploaded successfully!";
    header("Location: Admin_board.php");
    exit();
} else {
    $_SESSION['message'] = "No file selected!";
    header("Location: Admin_board.php");
    exit();
}

$conn->close();
