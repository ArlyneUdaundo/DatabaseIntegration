<?php
include 'db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "Employee ID not provided!";
    exit;
}

$stmt = $conn->prepare("DELETE FROM employees WHERE id = :id");
$stmt->execute([':id' => $id]);

header('Location: index.php');
?>