<?php
include 'auth.php';
include '../config/db.php';

$specialties = $conn->query("SELECT * FROM specialties");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("
        INSERT INTO doctors 
        (name, specialty_id, qualification, experience_years, consultation_fee, status)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "sisids",
        $_POST['name'],
        $_POST['specialty_id'],
        $_POST['qualification'],
        $_POST['experience'],
        $_POST['fee'],
        $_POST['status']
    );

    $stmt->execute();
    header("Location: doctors.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Doctor</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-xl mx-auto p-6 bg-white rounded-xl shadow mt-10">
  <h2 class="text-xl font-bold mb-4">Add Doctor</h2>

  <form method="POST" class="space-y-4">
    <input name="name" placeholder="Doctor Name" required class="w-full p-3 border rounded-lg">

    <select name="specialty_id" required class="w-full p-3 border rounded-lg">
      <option value="">Select Specialty</option>
      <?php while ($sp = $specialties->fetch_assoc()) { ?>
        <option value="<?= $sp['id'] ?>"><?= $sp['name'] ?></option>
      <?php } ?>
    </select>

    <input name="qualification" placeholder="Qualification" class="w-full p-3 border rounded-lg">
    <input type="number" name="experience" placeholder="Experience (Years)" class="w-full p-3 border rounded-lg">
    <input type="number" name="fee" placeholder="Consultation Fee" class="w-full p-3 border rounded-lg">

    <select name="status" class="w-full p-3 border rounded-lg">
      <option value="active">Active</option>
      <option value="inactive">Inactive</option>
    </select>

    <button class="w-full bg-green-600 text-white py-3 rounded-lg">
      Save Doctor
    </button>
  </form>
</div>

</body>
</html>