<?php
include 'db.php';

// Check if ID is provided in the URL
$employeeId = $_GET['id'] ?? 0;

if (!$employeeId) {
    die('Error: Employee ID is required.');
}

// Fetch employee details
$query = "SELECT * FROM employees WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $employeeId, PDO::PARAM_INT);
$stmt->execute();
$employee = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$employee) {
    die('Error: Employee not found or invalid ID.');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lastName = $_POST['last_name'] ?? '';
    $firstName = $_POST['first_name'] ?? '';
    $middleName = $_POST['middle_name'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $address = $_POST['address'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $email = $_POST['email'] ?? '';
    $department = $_POST['department'] ?? '';
    $position = $_POST['position'] ?? '';
    $type = $_POST['type'] ?? '';
    $status = $_POST['status'] ?? '';
    $dateHired = $_POST['date_hired'] ?? '';

    // Update employee details in the database
    $updateQuery = "
        UPDATE employees 
        SET 
            last_name = :last_name,
            first_name = :first_name,
            middle_name = :middle_name,
            dob = :dob,
            address = :address,
            contact = :contact,
            email = :email,
            department = :department,
            position = :position,
            type = :type,
            status = :status,
            date_hired = :date_hired
        WHERE id = :id
    ";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bindParam(':last_name', $lastName);
    $updateStmt->bindParam(':first_name', $firstName);
    $updateStmt->bindParam(':middle_name', $middleName);
    $updateStmt->bindParam(':dob', $dob);
    $updateStmt->bindParam(':address', $address);
    $updateStmt->bindParam(':contact', $contact);
    $updateStmt->bindParam(':email', $email);
    $updateStmt->bindParam(':department', $department);
    $updateStmt->bindParam(':position', $position);
    $updateStmt->bindParam(':type', $type);
    $updateStmt->bindParam(':status', $status);
    $updateStmt->bindParam(':date_hired', $dateHired);
    $updateStmt->bindParam(':id', $employeeId, PDO::PARAM_INT);

    if ($updateStmt->execute()) {
        header('Location: index.php');
        exit;
    } else {
        echo 'Failed to update employee details.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Employee</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

  <header>
    <h1>Employee Management System</h1>
  </header>

  <main class="container">
    <section class="card">
      <h2>Edit Employee Details</h2>
      <form action="" method="POST" class="grid-form">
        <input type="text" name="last_name" placeholder="Last Name" value="<?= htmlspecialchars($employee['last_name'] ?? '') ?>" required>
        <input type="text" name="first_name" placeholder="First Name" value="<?= htmlspecialchars($employee['first_name'] ?? '') ?>" required>
        <input type="text" name="middle_name" placeholder="Middle Name" value="<?= htmlspecialchars($employee['middle_name'] ?? '') ?>">
        <input type="date" name="dob" value="<?= htmlspecialchars($employee['dob'] ?? '') ?>" required>
        <input type="text" name="address" placeholder="Address" value="<?= htmlspecialchars($employee['address'] ?? '') ?>" required>
        <input type="text" name="contact" placeholder="Contact Number" value="<?= htmlspecialchars($employee['contact'] ?? '') ?>" required>
        <input type="email" name="email" placeholder="Email Address" value="<?= htmlspecialchars($employee['email'] ?? '') ?>" required>

        <!-- Dropdown styled as boxes -->
        <select name="department" required>
          <option value="">Select Department</option>
          <option value="IT" <?= ($employee['department'] ?? '') === 'IT' ? 'selected' : '' ?>>IT</option>
          <option value="HR" <?= ($employee['department'] ?? '') === 'HR' ? 'selected' : '' ?>>HR</option>
          <option value="Finance" <?= ($employee['department'] ?? '') === 'Finance' ? 'selected' : '' ?>>Finance</option>
        </select>

        <select name="position" required>
          <option value="">Select Position</option>
          <option value="Manager" <?= ($employee['position'] ?? '') === 'Manager' ? 'selected' : '' ?>>Manager</option>
          <option value="Developer" <?= ($employee['position'] ?? '') === 'Developer' ? 'selected' : '' ?>>Developer</option>
          <option value="Accountant" <?= ($employee['position'] ?? '') === 'Accountant' ? 'selected' : '' ?>>Accountant</option>
        </select>

        <select name="type" required>
          <option value="">Select Type</option>
          <option value="Full-Time" <?= ($employee['type'] ?? '') === 'Full-Time' ? 'selected' : '' ?>>Full-Time</option>
          <option value="Part-Time" <?= ($employee['type'] ?? '') === 'Part-Time' ? 'selected' : '' ?>>Part-Time</option>
        </select>

        <select name="status" required>
          <option value="">Select Status</option>
          <option value="Active" <?= ($employee['status'] ?? '') === 'Active' ? 'selected' : '' ?>>Active</option>
          <option value="Inactive" <?= ($employee['status'] ?? '') === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
        </select>

        <input type="date" name="date_hired" value="<?= htmlspecialchars($employee['date_hired'] ?? '') ?>" required>
        <button type="submit">Update Employee</button>
      </form>
    </section>
  </main>

</body>
</html>