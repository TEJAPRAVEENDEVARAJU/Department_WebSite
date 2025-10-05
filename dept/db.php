<?php
$host = 'sql211.infinityfree.com';
$user = 'if0_39030192';
$password = 'sUheL4DCaoSn';
$dbname = 'if0_39030192_infomatrix';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
