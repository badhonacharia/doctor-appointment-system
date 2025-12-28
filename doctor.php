<?php
include 'config/db.php';
include 'includes/header.php';

$doctor_id = intval($_GET['id']);

$doctor = $conn->query("
    SELECT doctors.*, specialties.name AS specialty
    FROM doctors
    JOIN specialties ON doctors.specialty_id = specialties.id
    WHERE doctors.id = $doctor_id
")->fetch_assoc();

$slots = $conn->query("
    SELECT * FROM time_slots
    WHERE doctor_id = $doctor_id AND is_booked = 0
    ORDER BY slot_date, slot_time
");
?>

<div class="max-w-xl mx-auto p-6 bg-white rounded-xl shadow mt-10">
  <h2 class="text-xl font-bold mb-2"><?= $doctor['name'] ?></h2>
  <p class="text-gray-600 mb-4"><?= $doctor['specialty'] ?></p>

  <form method="POST" action="book.php" class="space-y-4">
    <input type="hidden" name="doctor_id" value="<?= $doctor_id ?>">

    <input name="patient_name" placeholder="Your Name" required
           class="w-full p-3 border rounded-lg">

    <input name="patient_phone" placeholder="Phone Number" required
           class="w-full p-3 border rounded-lg">

    <input type="email" name="patient_email" placeholder="Email Address" required
       class="w-full p-3 border rounded-lg">
       
    <select name="slot_id" required class="w-full p-3 border rounded-lg">
      <option value="">Select Time Slot</option>
      <?php while ($s = $slots->fetch_assoc()) { ?>
        <option value="<?= $s['id'] ?>">
          <?= $s['slot_date'] ?> | <?= date("h:i A", strtotime($s['slot_time'])) ?>
        </option>
      <?php } ?>
    </select>

    <button class="w-full bg-green-600 text-white py-3 rounded-lg">
      Confirm Appointment
    </button>
  </form>
</div>

<?php include 'includes/footer.php'; ?>