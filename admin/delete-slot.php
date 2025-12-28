<?php
include 'auth.php';
include '../config/db.php';

$id = intval($_GET['id']);
$conn->query("DELETE FROM time_slots WHERE id = $id");

header("Location: time-slots.php");
exit;