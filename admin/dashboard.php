<?php
include 'auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<div class="max-w-4xl mx-auto p-6">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Admin Dashboard</h1>
    <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded-lg">
      Logout
    </a>
  </div>

  <div class="bg-white p-6 rounded-xl shadow">
    <p class="text-lg">
      Welcome, <strong><?= $_SESSION['admin_username']; ?></strong>
    </p>

    <div class="mt-6 space-y-2">
      <a href="doctors.php" class="block text-blue-600">Manage Doctors</a>
      <a href="time-slots.php" class="block text-blue-600">Manage Time Slots</a>
      <a href="appointments.php" class="block text-blue-600">View Appointments</a>
    </div>
  </div>
</div>

</body>
</html>