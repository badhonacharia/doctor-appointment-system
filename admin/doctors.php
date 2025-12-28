<?php
include 'auth.php';
include '../config/db.php';

$result = $conn->query("
    SELECT doctors.*, specialties.name AS specialty
    FROM doctors
    JOIN specialties ON doctors.specialty_id = specialties.id
    ORDER BY doctors.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Doctors</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-6xl mx-auto p-6">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Manage Doctors</h1>
    <a href="add-doctor.php" class="bg-green-600 text-white px-4 py-2 rounded-lg">
      + Add Doctor
    </a>
  </div>

  <div class="bg-white rounded-xl shadow overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-gray-200">
        <tr>
          <th class="p-3">Name</th>
          <th class="p-3">Specialty</th>
          <th class="p-3">Experience</th>
          <th class="p-3">Fee</th>
          <th class="p-3">Status</th>
          <th class="p-3">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr class="border-t">
          <td class="p-3"><?= $row['name'] ?></td>
          <td class="p-3"><?= $row['specialty'] ?></td>
          <td class="p-3"><?= $row['experience_years'] ?> yrs</td>
          <td class="p-3">৳<?= $row['consultation_fee'] ?></td>
          <td class="p-3"><?= ucfirst($row['status']) ?></td>
          <td class="p-3 space-x-2">
            <a href="edit-doctor.php?id=<?= $row['id'] ?>" class="text-blue-600">Edit</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <a href="dashboard.php" class="block mt-6 text-blue-600">← Back to Dashboard</a>
</div>

</body>
</html>