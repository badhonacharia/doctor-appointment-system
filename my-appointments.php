<?php
include 'user-auth.php';
include 'config/db.php';
include 'includes/header.php';

$user_id = $_SESSION['user_id'];

$result = $conn->query("
    SELECT 
        appointments.*,
        doctors.name AS doctor_name,
        time_slots.slot_date,
        time_slots.slot_time
    FROM appointments
    JOIN doctors ON appointments.doctor_id = doctors.id
    JOIN time_slots ON appointments.slot_id = time_slots.id
    WHERE appointments.user_id = $user_id
    ORDER BY appointments.created_at DESC
");
?>

<div class="max-w-4xl mx-auto p-6">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold">My Appointments</h2>
    <a href="logout.php" class="text-red-600">Logout</a>
  </div>

  <div class="bg-white rounded-xl shadow overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-gray-200">
        <tr>
          <th class="p-3">Doctor</th>
          <th class="p-3">Date</th>
          <th class="p-3">Time</th>
          <th class="p-3">Status</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr class="border-t">
          <td class="p-3"><?= $row['doctor_name'] ?></td>
          <td class="p-3"><?= $row['slot_date'] ?></td>
          <td class="p-3"><?= date("h:i A", strtotime($row['slot_time'])) ?></td>
          <td class="p-3 font-semibold"><?= ucfirst($row['status']) ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'includes/footer.php'; ?>