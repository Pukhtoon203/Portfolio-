<?php
require 'includes/db.php'; // ✅ correct path to DB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];

  // Prepare & insert query
  $stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $name, $email, $subject, $message);

  if ($stmt->execute()) {
    echo "<script>alert('✅ Message sent successfully!'); window.location.href='myportfolio.php#contact';</script>";
  } else {
    echo "<script>alert('❌ Failed to send message'); window.location.href='myportfolio.php#contact';</script>";
  }

  $stmt->close();
}
?>
