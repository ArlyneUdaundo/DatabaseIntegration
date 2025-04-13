<?php
include 'db.php';

// Search functionality
$search = $_GET['search'] ?? ''; // Get the search query from the URL (if provided)

if (!empty($search)) {
    // If a search query is provided, filter employees based on it
    $query = "SELECT * FROM employees WHERE first_name LIKE :search OR last_name LIKE :search OR id LIKE :search ORDER BY id DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute([':search' => "%$search%"]);
} else {
    // Default query to fetch all employees
    $query = "SELECT * FROM employees ORDER BY id DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
}

$employees = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Management System</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <header>
    <h1>Employee Management System</h1>
  </header>

  <main class="container">
    <!-- Add Employee -->
    <section class="card">
      <form action="add_employee.php" method="POST" class="grid-form">
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="middle_name" placeholder="Middle Name">
        <input type="date" name="dob" required>
        <input type="text" name="address" placeholder="Address" required>
        <input type="text" name="contact" placeholder="Contact Number" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="text" name="department" placeholder="Department" required>
        <input type="text" name="position" placeholder="Position" required>
        <select name="type" required>
          <option value="">-- Type --</option>
          <option value="Full-Time">Full-Time</option>
          <option value="Part-Time">Part-Time</option>
        </select>
        <select name="status" required>
          <option value="">-- Status --</option>
          <option value="Active">Active</option>
          <option value="Inactive">Inactive</option>
        </select>
        <input type="date" name="date_hired" required>
        <button type="submit">Add Employee</button>
      </form>
    </section>

    <!-- Employee List -->
    <section class="card">
      <h2>Employee List</h2>
      
      <!-- Search Form -->
      <div class="filters">
        <form method="GET" action="index.php">
          <input type="text" name="search" placeholder="Search by Name or ID" value="<?= htmlspecialchars($search) ?>">
          <button type="submit">Search</button>
        </form>
      </div>

      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Full Name</th>
              <th>Department</th>
              <th>Position</th>
              <th>Type</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($employees) > 0): ?>
              <?php foreach ($employees as $employee): ?>
                <tr>
                  <!-- Format the ID as a zero-padded number (e.g., 00001) -->
                  <td><?= str_pad((int)$employee['id'], 5, '0', STR_PAD_LEFT) ?></td>
                  <td><?= $employee['first_name'] . ' ' . $employee['last_name'] ?></td>
                  <td><?= $employee['department'] ?></td>
                  <td><?= $employee['position'] ?></td>
                  <td><?= isset($employee['type']) ? $employee['type'] : 'Not Specified' ?></td>
                  <td><?= isset($employee['status']) ? $employee['status'] : 'Not Specified' ?></td>
                  <td>
                    <a href="view_employee.php?id=<?= $employee['id'] ?>" class="btn view">View</a>
                    <a href="edit_employee.php?id=<?= $employee['id'] ?>" class="btn edit">Edit</a>
                    <a href="delete_employee.php?id=<?= $employee['id'] ?>" class="btn delete" onclick="return confirm('Are you sure you want to delete this employee?')">Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7">No employees found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>

</body>
</html>