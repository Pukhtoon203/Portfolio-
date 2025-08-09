<?php
require 'includes/db.php';

$success = "";
$error = "";

if (isset($_POST['register'])) {
    // Sanitize inputs
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role = $_POST['role'] ?? '';

    // Simple validation
    if (!$name || !$email || !$password || !$confirm_password || !$role) {
        $error = "❌ All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "❌ Invalid email address.";
    } elseif ($password !== $confirm_password) {
        $error = "❌ Passwords do not match.";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "❌ Email is already registered.";
        } else {
            // Hash password and insert user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $hashed_password, $role);
            if ($stmt->execute()) {
                $success = "✅ Registered successfully. You can login now.";
            } else {
                $error = "❌ Registration failed: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>User Registration</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    :root {
      --bg: #121217;
      --text: #e1e1e6;
      --accent: #ffb400;
      --accent2: #d0a628;
      --shadow: 0 6px 30px rgba(0, 170, 255, 0.1);
      --card-bg: rgba(30, 30, 38, 0.85);
      --input-bg: #1e1e27;
      --input-border: #333344;
      --font-family: 'Montserrat', Arial, sans-serif;
    }

    body {
      font-family: var(--font-family);
      background: var(--bg);
      color: var(--text);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      padding: 20px;
    }

    .register-form {
      background: var(--card-bg);
      padding: 30px 40px;
      border-radius: 18px;
      box-shadow: var(--shadow);
      width: 100%;
      max-width: 400px;
      box-sizing: border-box;
    }

    .register-form h2 {
      margin-bottom: 25px;
      font-size: 2rem;
      color: var(--accent);
      text-align: center;
      user-select: none;
    }

    .register-form input,
    .register-form select {
      width: 100%;
      padding: 12px 15px;
      margin-bottom: 18px;
      border-radius: 12px;
      border: 1.5px solid var(--input-border);
      background: var(--input-bg);
      color: var(--text);
      font-size: 1rem;
      transition: border-color 0.3s;
      box-sizing: border-box;
    }

    .register-form input:focus,
    .register-form select:focus {
      border-color: var(--accent);
      outline: none;
      box-shadow: 0 0 8px var(--accent);
    }

    .register-form button {
      width: 100%;
      background: var(--accent);
      color: #121217;
      padding: 14px 0;
      border: none;
      border-radius: 32px;
      font-weight: 700;
      font-size: 1.1rem;
      cursor: pointer;
      transition: background 0.3s ease, box-shadow 0.3s ease;
      user-select: none;
    }

    .register-form button:hover,
    .register-form button:focus {
      background: var(--accent2);
      box-shadow: 0 0 20px var(--accent2);
      outline: none;
      color: #121217;
    }

    .message {
      margin-top: 20px;
      font-weight: 700;
      text-align: center;
      user-select: none;
    }

    .message.success {
      color: #80ff80;
    }

    .message.error {
      color: #ff8080;
    }
  </style>
</head>
<body>

  <form class="register-form" method="POST" action="" novalidate>
    <h2>Register</h2>

    <input type="text" name="name" placeholder="Name" required autocomplete="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" />
    <input type="email" name="email" placeholder="Email" required autocomplete="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />
    <input type="password" name="password" placeholder="Password" required autocomplete="new-password" />
    <input type="password" name="confirm_password" placeholder="Confirm Password" required autocomplete="new-password" />

    <select name="role" required>
      <option value="" disabled <?= empty($_POST['role']) ? 'selected' : '' ?>>Select Role</option>
      <option value="editor" <?= (($_POST['role'] ?? '') === 'editor') ? 'selected' : '' ?>>Editor</option>
      <option value="moderator" <?= (($_POST['role'] ?? '') === 'moderator') ? 'selected' : '' ?>>Moderator</option>
      <option value="admin" <?= (($_POST['role'] ?? '') === 'admin') ? 'selected' : '' ?>>Admin</option>
    </select>

    <button type="submit" name="register">Register</button>

    <?php if ($success): ?>
      <p class="message success"><?= $success ?></p>
    <?php elseif ($error): ?>
      <p class="message error"><?= $error ?></p>
    <?php endif; ?>
  </form>

</body>
</html>
