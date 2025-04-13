<?php
include 'db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "Employee ID not provided!";
    exit;
}

$stmt = $conn->prepare("SELECT * FROM employees WHERE id = :id");
$stmt->execute([':id' => $id]);
$employee = $stmt->fetch();

if (!$employee) {
    echo "Employee not found!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employee</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Employee Details</h1>
    </header>
    <main class="container">
        <div class="card">
            <p><strong>Full Name:</strong> <?= $employee['first_name'] . ' ' . $employee['last_name'] ?></p>
            <p><strong>Department:</strong> <?= $employee['department'] ?></p>
            <p><strong>Position:</strong> <?= $employee['position'] ?></p>
            <p><strong>Status:</strong> <?= $employee['status'] ?></p>
            <a href="index.php" class="btn">Back to List</a>
        </div>
    </main>
</body>
</html>