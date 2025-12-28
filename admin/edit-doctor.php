<?php
include 'auth.php';
include '../config/db.php';

$id = $_GET['id'];
$doctor = $conn->query("SELECT * FROM doctors WHERE id = $id")->fetch_assoc();
$specialties = $conn->query("SELECT * FROM specialties");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("
        UPDATE doctors SET
        name=?, specialty_id=?, qualification=?, experience_years=?, consultation_fee=?, status=?
        WHERE id=?
    ");

    $stmt->bind_param(
        "sisidsi",
        $_POST['name'],
        $_POST['specialty_id'],
        $_POST['qualification'],
        $_POST['experience'],
        $_POST['fee'],
        $_POST['status'],
        $id
    );

    $stmt->execute();
    header("Location: doctors.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Doctor</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-xl mx-auto p-6 bg-white rounded-xl shadow mt-10">
  <h2 class="text-xl font-bold mb-4">Edit Doctor</h2>

  <form method="POST" class="space-y-4">
    <input name="name" value="<?= $doctor['name'] ?>" required class="w-full p-3 border rounded-lg">

    <select name="specialty_id" class="w-full p-3 border rounded-lg">
      <?php while ($sp = $specialties->fetch_assoc()) { ?>
        <option value="<?= $sp['id'] ?>" <?= $doctor['specialty_id'] == $sp['id'] ? 'selected' : '' ?>>
          <?= $sp['name'] ?>
        </option>
      <?php } ?>
    </select>

    <input name="qualification" value="<?= $doctor['qualification'] ?>" class="w-full p-3 border rounded-lg">
    <input name="experience" value="<?= $doctor['experience_years'] ?>" class="w-full p-3 border rounded-lg">
    <input name="fee" value="<?= $doctor['consultation_fee'] ?>" class="w-full p-3 border rounded-lg">

    <select name="status" class="w-full p-3 border rounded-lg">
      <option value="active" <?= $doctor['status']=='active'?'selected':'' ?>>Active</option>
      <option value="inactive" <?= $doctor['status']=='inactive'?'selected':'' ?>>Inactive</option>
    </select>

    <button class="w-full bg-blue-600 text-white py-3 rounded-lg">
      Update Doctor
    </button>
  </form>
</div>

</body>
</html>