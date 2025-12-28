<?php
session_start();
include 'config/db.php';
require 'includes/send-email.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name  = trim($_POST['patient_name']);
    $phone = trim($_POST['patient_phone']);
    $email = trim($_POST['patient_email']);


    // Check or create user
    $stmt = $conn->prepare("SELECT id FROM users WHERE phone = ? OR email = ?");
    $stmt->bind_param("ss", $phone, $email);
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (!$user) {
        $stmt = $conn->prepare("INSERT INTO users (name, phone, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $phone, $email);
        $stmt->execute();
        $user_id = $conn->insert_id;
    } else {
        $user_id = $user['id'];
    }

    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_name'] = $name;

    $doctor_id = intval($_POST['doctor_id']);
    $slot_id   = intval($_POST['slot_id']);

    // Save appointment
    $stmt = $conn->prepare("
        INSERT INTO appointments (user_id, patient_name, patient_phone, patient_email, doctor_id, slot_id)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("isssii", $user_id, $name, $phone, $email, $doctor_id, $slot_id);
    $stmt->execute();

    $appointment_id = $conn->insert_id;

    // Mark slot as booked
    $conn->query("UPDATE time_slots SET is_booked = 1 WHERE id = $slot_id");

    // ✅ SEND EMAIL BEFORE REDIRECT
    
    $emailBody = '
<div style="font-family: Arial, sans-serif; background:#f9fafb; padding:20px;">
  <h2 style="color:#1f2937;">Appointment Confirmation</h2>

  <div style="background:#ffffff; padding:16px; border-radius:8px;">
    <p><strong>Doctor:</strong> ' . $appointment['doctor_name'] . '</p>
    <p><strong>Specialty:</strong> ' . $appointment['specialty'] . '</p>
    <p><strong>Date:</strong> ' . $appointment['slot_date'] . '</p>
    <p><strong>Time:</strong> ' . date("h:i A", strtotime($appointment['slot_time'])) . '</p>
    <p><strong>Status:</strong> 
      <span style="color:#ca8a04; font-weight:bold;">Pending</span>
    </p>
  </div>

  <p style="margin-top:16px; color:#374151;">
    Our team will review your appointment and notify you once it is approved.
  </p>
</div>
';
    sendBookingEmail(
    $appointment['patient_email'],
    'Appointment Booking Confirmation',
    $emailBody
);



    // Redirect after everything is done
    header("Location: booking-success.php?id=$appointment_id");
    exit;
}