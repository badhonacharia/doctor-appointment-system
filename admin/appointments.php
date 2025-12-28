<?php
include 'auth.php';
include '../config/db.php';

/* Handle status update */
if (isset($_GET['action'], $_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if (in_array($action, ['approved', 'cancelled'])) {
        $stmt = $conn->prepare("UPDATE appointments SET status=? WHERE id=?");
        $stmt->bind_param("si", $action, $id);
        $stmt->execute();

        // If cancelled, free the slot
        if ($action === 'cancelled') {
            $conn->query("
                UPDATE time_slots 
                SET is_booked = 0 
                WHERE id = (SELECT slot_id FROM appointments WHERE id = $id)
            ");
        }
    }

    header("Location: appointments.php");
    exit;
}

$result = $conn->query("
    SELECT 
        appointments.*,
        doctors.name AS doctor_name,
        time_slots.slot_date,
        time_slots.slot_time
    FROM appointments
    JOIN doctors ON appointments.doctor_id = doctors.id
    JOIN time_slots ON appointments.slot_id = time_slots.id
    ORDER BY appointments.created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Appointments</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-6xl mx-auto p-6">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Appointments</h1>
    <a href="dashboard.php" class="text-blue-600">← Back</a>
  </div>

  <div class="bg-white rounded-xl shadow overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-gray-200">
        <tr>
          <th class="p-3">Patient</th>
          <th class="p-3">Phone</th>
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
          <td class="p-3"><?= $row['patient_name'] ?></td>
          <td class="p-3"><?= $row['patient_phone'] ?></td>
          <td class="p-3"><?= $row['doctor_name'] ?></td>
          <td class="p-3"><?= $row['slot_date'] ?></td>
          <td class="p-3"><?= date("h:i A", strtotime($row['slot_time'])) ?></td>
          <td class="p-3 font-semibold"><?= ucfirst($row['status']) ?></td>
          <td class="p-3 space-x-2">
            <?php if ($row['status'] === 'pending') { ?>
              <a href="update-appointment-status.php?id=<?= $row['id'] ?>&status=approved"
                class="bg-green-600 text-white px-3 py-1 rounded">
                Approve
              </a>
            <a href="update-appointment-status.php?id=<?= $row['id'] ?>&status=cancelled"
              class="bg-red-600 text-white px-3 py-1 rounded">
              Cancel
            </a>
            <?php } else { ?>
              —
            <?php } ?>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>