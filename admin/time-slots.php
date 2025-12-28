<?php
include 'auth.php';
include '../config/db.php';

if (isset($_POST['add_slot'])) {
    $stmt = $conn->prepare("
        INSERT INTO time_slots (doctor_id, slot_date, slot_time)
        VALUES (?, ?, ?)
    ");
    $stmt->bind_param("iss", $_POST['doctor_id'], $_POST['slot_date'], $_POST['slot_time']);
    $stmt->execute();
    header("Location: time-slots.php");
    exit;
}

$doctors = $conn->query("SELECT id, name FROM doctors WHERE status='active' ORDER BY name");

$result = $conn->query("
    SELECT time_slots.*, doctors.name AS doctor_name
    FROM time_slots
    JOIN doctors ON time_slots.doctor_id = doctors.id
    ORDER BY slot_date DESC, slot_time ASC
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Time Slots</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-6xl mx-auto p-6">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Manage Time Slots</h1>
    <a href="dashboard.php" class="text-blue-600">← Back</a>
  </div>

  <!-- Add Slot -->
  <div class="bg-white p-6 rounded-xl shadow mb-6">
    <h2 class="text-lg font-semibold mb-4">Add New Time Slot</h2>

    <form method="POST" action="time-slots.php" class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <select name="doctor_id" required class="p-3 border rounded-lg">
        <option value="">Select Doctor</option>
        <?php while ($d = $doctors->fetch_assoc()) { ?>
          <option value="<?= $d['id'] ?>"><?= $d['name'] ?></option>
        <?php } ?>
      </select>

      <input type="date" name="slot_date" required class="p-3 border rounded-lg">
      <input type="text" name="slot_time" placeholder="10:00 AM - 10:30 AM" required class="p-3 border rounded-lg">

      <button name="add_slot" class="bg-green-600 text-white rounded-lg">
        Add Slot
      </button>
    </form>
  </div>

  <!-- Slot List -->
  <div class="bg-white rounded-xl shadow overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-gray-200">
        <tr>
          <th class="p-3">Doctor</th>
          <th class="p-3">Date</th>
          <th class="p-3">Time</th>
          <th class="p-3">Status</th>
          <th class="p-3">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr class="border-t">
          <td class="p-3"><?= $row['doctor_name'] ?></td>
          <td class="p-3"><?= $row['slot_date'] ?></td>
          <td class="p-3"><?= $row['slot_time'] ?></td>
          <td class="p-3">
            <?= $row['is_booked'] ? 'Booked' : 'Available' ?>
          </td>
          <td class="p-3">
            <a href="delete-slot.php?id=<?= $row['id'] ?>" 
               onclick="return confirm('Delete this slot?')"
               class="text-red-600">
               Delete
            </a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>