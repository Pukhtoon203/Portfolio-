<?php
session_start();
require 'includes/db.php';

$error = "";
// Get redirect URL from GET or default to multi_add.php
$redirect = $_GET['redirect'] ?? 'multi_add.php';

if (isset($_POST['login'])) {
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';
  // Use redirect from POST to preserve after form submit
  $redirect = $_POST['redirect'] ?? 'multi_add.php';

  $stmt = $conn->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
      // Set session variables
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_role'] = $user['role'];

      // Redirect to intended page
      header("Location: " . $redirect);
      exit;
    } else {
      $error = "❌ Invalid password.";
    }
  } else {
    $error = "❌ No user found with this email.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>User Login</title>
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

    .login-form {
      background: var(--card-bg);
      padding: 30px 40px;
      border-radius: 18px;
      box-shadow: var(--shadow);
      width: 100%;
      max-width: 400px;
      box-sizing: border-box;
    }

    .login-form h2 {
      margin-bottom: 25px;
      font-size: 2rem;
      color: var(--accent);
      text-align: center;
      user-select: none;
    }

    .login-form input {
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

    .login-form input:focus {
      border-color: var(--accent);
      outline: none;
      box-shadow: 0 0 8px var(--accent);
    }

    .login-form button {
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

    .login-form button:hover,
    .login-form button:focus {
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

    .message.error {
      color: #ff8080;
    }
  </style>
</head>
<body>

  <form class="login-form" method="POST" action="" novalidate>
    <h2>Login</h2>
    <input type="email" name="email" placeholder="Email Address" required autofocus value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />
    <input type="password" name="password" placeholder="Password" required />
    <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">
    <button type="submit" name="login">Login</button>

    <?php if (!empty($error)): ?>
      <p class="message error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
  </form>

</body>
</html>
