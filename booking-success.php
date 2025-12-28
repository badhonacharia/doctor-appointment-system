<?php
include 'config/db.php';
include 'includes/header.php';

$appointment_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$appointment = $conn->query("
    SELECT 
        appointments.*,
        doctors.name AS doctor_name,
        specialties.name AS specialty,
        time_slots.slot_date,
        time_slots.slot_time
    FROM appointments
    JOIN doctors ON appointments.doctor_id = doctors.id
    JOIN specialties ON doctors.specialty_id = specialties.id
    JOIN time_slots ON appointments.slot_id = time_slots.id
    WHERE appointments.id = $appointment_id
")->fetch_assoc();

if (!$appointment) {
    echo '<div class="text-center mt-20 text-red-600">Invalid booking.</div>';
    include 'includes/footer.php';
    exit;
}
?>

<div class="max-w-xl mx-auto mt-16 bg-white p-8 rounded-xl shadow text-center">

  <div class="text-green-600 text-4xl mb-4">✔</div>

  <h1 class="text-2xl font-bold mb-2">Booking Successful</h1>

  <p class="text-gray-600 mb-6">
    Your appointment request has been received successfully.
  </p>

  <div class="text-left bg-gray-50 p-4 rounded-lg space-y-2 mb-6">
    <p><strong>Doctor:</strong> <?= $appointment['doctor_name'] ?></p>
    <p><strong>Specialty:</strong> <?= $appointment['specialty'] ?></p>
    <p><strong>Date:</strong> <?= $appointment['slot_date'] ?></p>
    <p><strong>Time:</strong> <?= date("h:i A", strtotime($appointment['slot_time'])) ?></p>
    <p><strong>Status:</strong> <span class="text-yellow-600 font-semibold">Pending</span></p>
  </div>

  <p class="text-sm text-gray-500 mb-6">
    Our team will contact you shortly to confirm your appointment.
  </p>

  <a href="index.php"
     class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg">
     Book Another Appointment
  </a>

</div>

<?php include 'includes/footer.php'; ?>