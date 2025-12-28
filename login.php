<?php
session_start();
include 'config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = trim($_POST['phone']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: my-appointments.php");
        exit;
    } else {
        $error = "Phone number not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-xl shadow w-full max-w-sm">
  <h2 class="text-2xl font-bold mb-6 text-center">User Login</h2>

  <?php if ($error): ?>
    <p class="text-red-600 mb-4"><?= $error ?></p>
  <?php endif; ?>

  <form method="POST" class="space-y-4">
    <input name="phone" placeholder="Enter phone number" required
           class="w-full p-3 border rounded-lg">

    <button class="w-full bg-blue-600 text-white py-3 rounded-lg">
      Login
    </button>
  </form>
</div>

</body>
</html>