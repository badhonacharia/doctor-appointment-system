<?php
include 'config/db.php';
include 'includes/header.php';

$doctors = $conn->query("
    SELECT doctors.*, specialties.name AS specialty
    FROM doctors
    JOIN specialties ON doctors.specialty_id = specialties.id
    WHERE doctors.status='active'
    ORDER BY doctors.name
");
?>

<div class="max-w-6xl mx-auto p-6">
  <h1 class="text-2xl font-bold mb-6 text-center">Book a Doctor Appointment</h1>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <?php while ($doc = $doctors->fetch_assoc()) { ?>
      <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-lg font-semibold"><?= $doc['name'] ?></h2>
        <p class="text-sm text-gray-600"><?= $doc['specialty'] ?></p>
        <p class="text-sm">Experience: <?= $doc['experience_years'] ?> years</p>
        <p class="text-sm">Fee: ৳<?= $doc['consultation_fee'] ?></p>

        <a href="doctor.php?id=<?= $doc['id'] ?>"
           class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg">
           Book Appointment
        </a>
      </div>
    <?php } ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>