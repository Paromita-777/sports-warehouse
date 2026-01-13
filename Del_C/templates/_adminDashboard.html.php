<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/utilities.css" />
  <link rel="stylesheet" href="css/styles.css" />
  <link rel="stylesheet" href="css/dashboard.css" />
</head>
<body>
  
<div class="dashboard__header">
  <button class="dashboard__toggle-btn" onclick="toggleSidebar()">☰</button>
  <div class="dashboard__logo">
    <img src="assets/sports-warehouse-logo.png" alt="logo">
  </div>
</div>

  <div class="dashboard dashboard--container">

    <!-- Sidebar -->
    <aside class="dashboard__sidebar" id="sidebar">
      <div class="dashboard__profile">
        <span class="dashboard__username text--font-16">
          Welcome <?= esc($username) ?>!
        </span>
      </div>

      <nav class="dashboard__nav">
        <a href="adminDashboard.php" class="dashboard__nav-link">Dashboard</a>
        <a href="categoryManagement.php" class="dashboard__nav-link">Category Management</a>
        <a href="productManagement.php" class="dashboard__nav-link">Product Management</a>
        <!-- <a href="signUpForm.php" class="dashboard__nav-link">Create User</a> -->
        <a href="updatePasswordForm.php" class="dashboard__nav-link">Update Password</a>
        <a href="logout.php" class="dashboard__nav-link dashboard__nav-link--logout">Logout</a>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="dashboard__main">
      
      <?= $content ?? 'NO CONTENT - $content not defined' ?>
    </main>

  </div>

 <script>
  function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('dashboard__sidebar--active');
  }
</script>
<script src="JS/password-toggle.js"></script>
</body>
</html>
