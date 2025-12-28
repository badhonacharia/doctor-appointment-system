<?php
session_start();
include '../config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $admin = $stmt->get_result()->fetch_assoc();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-xl shadow-md w-full max-w-sm">
  <h2 class="text-2xl font-bold mb-6 text-center">Admin Login</h2>

  <?php if ($error): ?>
    <p class="text-red-600 text-sm mb-4"><?= $error ?></p>
  <?php endif; ?>

  <form method="POST" class="space-y-4">
    <input type="text" name="username" placeholder="Username" required
           class="w-full p-3 border rounded-lg">

    <input type="password" name="password" placeholder="Password" required
           class="w-full p-3 border rounded-lg">

    <button class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">
      Login
    </button>
  </form>
</div>

</body>
</html>