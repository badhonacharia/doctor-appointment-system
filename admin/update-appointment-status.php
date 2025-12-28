<?php
include 'auth.php';
require '../config/db.php';
require '../includes/send-sms.php';

// Get data from request
$appointment_id = intval($_GET['id']);
$new_status     = $_GET['status']; // approved / cancelled

// Update appointment status
$stmt = $conn->prepare("
    UPDATE appointments 
    SET status = ? 
    WHERE id = ?
");
$stmt->bind_param("si", $new_status, $appointment_id);
$stmt->execute();

// Fetch appointment details for SMS
$stmt = $conn->prepare("
    SELECT 
        appointments.patient_phone,
        doctors.name AS doctor_name,
        time_slots.slot_date,
        time_slots.slot_time
    FROM appointments
    JOIN doctors ON appointments.doctor_id = doctors.id
    JOIN time_slots ON appointments.slot_id = time_slots.id
    WHERE appointments.id = ?
");
$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$appointment = $stmt->get_result()->fetch_assoc();

// Send SMS ONLY if approved
if ($new_status === 'approved' && $appointment) {

    $phone = $appointment['patient_phone'];

    // Ensure +880 format if needed
    if (strpos($phone, '+') !== 0) {
        $phone = '+880' . ltrim($phone, '0');
    }

    $message = "Your appointment is CONFIRMED!\n"
             . "Doctor: {$appointment['doctor_name']}\n"
             . "Date: {$appointment['slot_date']}\n"
             . "Time: " . date("h:i A", strtotime($appointment['slot_time'])) . "\n"
             . "Thank you.";

    sendSMS($phone, $message);
}

// Redirect back
header("Location: appointments.php");
exit;