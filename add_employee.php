<?php
include 'db.php';

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

    $insertQuery = "
        INSERT INTO employees (last_name, first_name, middle_name, dob, address, contact, email, department, position, type, status, date_hired)
        VALUES (:last_name, :first_name, :middle_name, :dob, :address, :contact, :email, :department, :position, :type, :status, :date_hired)
    ";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bindParam(':last_name', $lastName);
    $stmt->bindParam(':first_name', $firstName);
    $stmt->bindParam(':middle_name', $middleName);
    $stmt->bindParam(':dob', $dob);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':contact', $contact);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':department', $department);
    $stmt->bindParam(':position', $position);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':date_hired', $dateHired);

    if ($stmt->execute()) {
        header('Location: index.php');
        exit;
    } else {
        echo 'Failed to add employee.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add Employee</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

  <header>
    <h1>Employee Management System</h1>
  </header>

  <main class="container">
    <section class="card">
      <h2>Add New Employee</h2>
      <form action="" method="POST" class="grid-form">
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="middle_name" placeholder="Middle Name">
        <input type="date" name="dob" required>
        <input type="text" name="address" placeholder="Address" required>
        <input type="text" name="contact" placeholder="Contact Number" required>
        <input type="email" name="email" placeholder="Email Address" required>

        <!-- Dropdown styled as boxes -->
        <select name="department" required>
          <option value="">Select Department</option>
          <option value="IT">IT</option>
          <option value="HR">HR</option>
          <option value="Finance">Finance</option>
        </select>

        <select name="position" required>
          <option value="">Select Position</option>
          <option value="Manager">Manager</option>
          <option value="Developer">Developer</option>
          <option value="Accountant">Accountant</option>
        </select>

        <select name="type" required>
          <option value="">Select Type</option>
          <option value="Full-Time">Full-Time</option>
          <option value="Part-Time">Part-Time</option>
        </select>

        <select name="status" required>
          <option value="">Select Status</option>
          <option value="Active">Active</option>
          <option value="Inactive">Inactive</option>
        </select>

        <input type="date" name="date_hired" required>
        <button type="submit">Add Employee</button>
      </form>
    </section>
  </main>

</body>
</html>