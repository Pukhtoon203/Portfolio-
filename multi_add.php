<?php
require 'includes/db.php';
$success_message = '';
$error_message = '';
/*
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
} 
*/
// Handle Blog Add
if (isset($_POST['add_blog'])) {
  $title = $_POST['blog_title'] ?? '';
  $content = $_POST['blog_content'] ?? '';
  $image = '';

  if (isset($_FILES['blog_image']) && $_FILES['blog_image']['error'] === UPLOAD_ERR_OK) {
    $image = basename($_FILES['blog_image']['name']);
    $tmp = $_FILES['blog_image']['tmp_name'];
    $uploadDir = __DIR__ . "/uploads/";
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0755, true);
    }
    $targetFile = $uploadDir . $image;
    if (!move_uploaded_file($tmp, $targetFile)) {
      $error_message = "⚠️ Failed to upload blog image.";
      $image = '';
    }
  }

  if (!$error_message) {
    $stmt = $conn->prepare("INSERT INTO blogs (title, content, image, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $title, $content, $image);
    if ($stmt->execute()) {
      $success_message = "✅ Blog Added Successfully!";
    } else {
      $error_message = "Error adding blog: " . $stmt->error;
    }
    $stmt->close();
  }
}

// Handle Project Add
if (isset($_POST['add_project'])) {
  $title = $_POST['project_title'] ?? '';
  $description = $_POST['project_description'] ?? '';
  $link = $_POST['project_link'] ?? '';
  $image = '';

  if (isset($_FILES['project_image']) && $_FILES['project_image']['error'] === UPLOAD_ERR_OK) {
    $image = basename($_FILES['project_image']['name']);
    $tmp = $_FILES['project_image']['tmp_name'];
    $uploadDir = __DIR__ . "/uploads/";
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0755, true);
    }
    $targetFile = $uploadDir . $image;
    if (!move_uploaded_file($tmp, $targetFile)) {
      $error_message = "⚠️ Failed to upload project image.";
      $image = '';
    }
  }

  if (!$error_message) {
    $stmt = $conn->prepare("INSERT INTO projects (title, description, link, image, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssss", $title, $description, $link, $image);
    if ($stmt->execute()) {
      $success_message = "✅ Project Added Successfully!";
    } else {
      $error_message = "Error adding project: " . $stmt->error;
    }
    $stmt->close();
  }
}

// Handle Skill Add
if (isset($_POST['add_skill'])) {
  $name = $_POST['skill_name'] ?? '';
  $level = $_POST['skill_level'] ?? '';
  $stmt = $conn->prepare("INSERT INTO skills (name, level) VALUES (?, ?)");
  $stmt->bind_param("ss", $name, $level);
  if ($stmt->execute()) {
    $success_message = "✅ Skill Added Successfully!";
  } else {
    $error_message = "Error adding skill: " . $stmt->error;
  }
  $stmt->close();
}

// Handle Service Add
if (isset($_POST['add_service'])) {
  $title = $_POST['service_title'] ?? '';
  $description = $_POST['service_description'] ?? '';
  $stmt = $conn->prepare("INSERT INTO services (title, description) VALUES (?, ?)");
  $stmt->bind_param("ss", $title, $description);
  if ($stmt->execute()) {
    $success_message = "✅ Service Added Successfully!";
  } else {
    $error_message = "Error adding service: " . $stmt->error;
  }
  $stmt->close();
}

// Handle Review Add
if (isset($_POST['add_review'])) {
  $name = $_POST['reviewer_name'] ?? '';
  $content = $_POST['review_content'] ?? '';
  $stmt = $conn->prepare("INSERT INTO reviews (name, content) VALUES (?, ?)");
  $stmt->bind_param("ss", $name, $content);
  if ($stmt->execute()) {
    $success_message = "✅ Review Added Successfully!";
  } else {
    $error_message = "Error adding review: " . $stmt->error;
  }
  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Multi Add Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

    :root {
      --bg: #121217;
      --bg-glass: rgba(18, 18, 23, 0.7);
      --text: #e1e1e6;
      --accent: #ffb400;
      --accent2: #d0a628;
      --shadow: 0 6px 30px rgba(0, 170, 255, 0.1);
      --card-bg: rgba(30, 30, 38, 0.85);
      --border: #22222a;
      --input-bg: #1e1e27;
      --input-border: #333344;
    }

    body {
      background: var(--bg);
      color: var(--text);
      font-family: 'Montserrat', Arial, sans-serif;
      padding: 40px 20px;
      margin: 0;
      min-height: 100vh;
    }

    h2 {
      text-align: center;
      color: var(--accent);
      margin-bottom: 30px;
      font-weight: 700;
      font-size: 2rem;
      user-select: none;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      text-shadow: 0 0 8px var(--accent2);
    }

    select#content-type {
      width: 100%;
      max-width: 400px;
      padding: 14px 18px;
      border: 1px solid var(--input-border);
      border-radius: 10px;
      font-weight: 700;
      color: var(--text);
      background-color: var(--card-bg);
      background-image: url("data:image/svg+xml,%3Csvg%20width%3D%22292%22%20height%3D%22292%22%20viewBox%3D%220%200%20292%20292%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cpath%20d%3D%22M287%2069.4L269.6%2052%20146%20175.6%2022.4%2052%205%2069.4l141%20141z%22%20fill%3D%22%23ffb400%22/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 18px center;
      background-size: 14px;
      appearance: none;
      cursor: pointer;
      margin: 0 auto 30px;
      display: block;
      transition: box-shadow 0.3s ease;
    }

    select#content-type:focus {
      outline: none;
      box-shadow: 0 0 0 3px var(--accent2);
    }

    /* Form sections with smooth fade and slide */
    .form-section {
      opacity: 0;
      max-height: 0;
      overflow: hidden;
      pointer-events: none;
      transition: opacity 0.4s ease, max-height 0.5s ease;
      background: var(--card-bg);
      padding: 0 30px;
      border-radius: 16px;
      box-shadow: var(--shadow);
      border: 1px solid var(--border);
      max-width: 600px;
      margin: 0 auto 40px;
      box-sizing: border-box;
    }

    .form-section.active {
      opacity: 1;
      max-height: 1000px; /* enough to show full form */
      pointer-events: auto;
      padding: 25px 30px;
    }

    input, textarea, button {
      width: 100%;
      margin-top: 12px;
      padding: 14px 16px;
      background: var(--input-bg);
      border: 1.5px solid var(--input-border);
      color: var(--text);
      border-radius: 10px;
      font-size: 1rem;
      font-family: 'Montserrat', Arial, sans-serif;
      transition: border-color 0.3s ease;
      resize: vertical;
      box-sizing: border-box;
    }

    input:focus, textarea:focus {
      border-color: var(--accent);
      outline: none;
      box-shadow: 0 0 10px var(--accent);
    }
    button {
  display: block;
  color: white;
  font-weight: 700;
  font-size: 1.2rem;
  padding: 0.85rem 1.2rem;
  border-radius: 32px;
  box-shadow: 0 6px 24px var(--accent)88;
  font-size: 0.8rem;
  text-decoration: none;
  letter-spacing: 0.06em;
  border: 2px solid var(--accent);
  background: transparent;
  width: fit-content;
  margin-left: auto;
  margin-right: auto;
  transition: background 0.3s, box-shadow 0.3s, color 0.3s;
}

button:hover,
button:focus {
  background: var(--accent);
  box-shadow: 0 12px 32px var(--accent2)cc;
  outline: none;
  color: var(--bg);
}
 
    h3 {
      color: var(--accent2);
      margin-bottom: 15px;
      font-weight: 700;
      font-size: 1.6rem;
      text-align: center;
    }

    .success {
      background: #1e2e1e;
      color: #80ff80;
      padding: 12px 20px;
      border-left: 5px solid #00cc00;
      border-radius: 10px;
      margin: 20px auto;
      max-width: 600px;
      font-weight: 600;
      text-align: center;
      box-shadow: 0 0 10px #00cc00aa;
    }

    .error {
      background: #2e1e1e;
      color: #ff8080;
      padding: 12px 20px;
      border-left: 5px solid #cc0000;
      border-radius: 10px;
      margin: 20px auto;
      max-width: 600px;
      font-weight: 600;
      text-align: center;
      box-shadow: 0 0 10px #cc0000aa;
    }

    /* Responsive */
    @media (max-width: 640px) {
      body {
        padding: 20px 12px;
      }
      select#content-type {
        max-width: 100%;
      }
      .form-section {
        padding: 20px;
        max-width: 100%;
      }
      button {
        font-size: 1rem;
        padding: 12px 0;
      }
    }
  </style>
</head>
<body>

<h2>➕ Add New Content</h2>

<?php if ($success_message): ?>
  <div class="success"><?= htmlspecialchars($success_message) ?></div>
<?php elseif ($error_message): ?>
  <div class="error"><?= htmlspecialchars($error_message) ?></div>
<?php endif; ?>

<select id="content-type" aria-label="Select content type to add">
  <option value="">-- Select What to Add --</option>
  <option value="blog">Blog</option>
  <option value="project">Project</option>
  <option value="skill">Skill</option>
  <option value="service">Service</option>
  <option value="review">Review</option>
</select>

<!-- Blog Form -->
<form class="form-section" id="blog-form" method="POST" enctype="multipart/form-data" novalidate>
  <h3>Add Blog</h3>
  <input type="text" name="blog_title" placeholder="Blog Title" required>
  <textarea name="blog_content" placeholder="Blog Content" rows="5" required></textarea>
  <input type="file" name="blog_image" accept="image/*">
  <button type="submit" name="add_blog">Add Blog</button>
</form>

<!-- Project Form -->
<form class="form-section" id="project-form" method="POST" enctype="multipart/form-data" novalidate>
  <h3>Add Project</h3>
  <input type="text" name="project_title" placeholder="Project Title" required>
  <textarea name="project_description" placeholder="Project Description" rows="5" required></textarea>
  <input type="file" name="project_image" accept="image/*">
  <input type="text" name="project_link" placeholder="Project Link (optional)">
  <button type="submit" name="add_project">Add Project</button>
</form>

<!-- Skill Form -->
<form class="form-section" id="skill-form" method="POST" novalidate>
  <h3>Add Skill</h3>
  <input type="text" name="skill_name" placeholder="Skill Name" required>
  <input type="text" name="skill_level" placeholder="Skill Level (e.g. 90%)" required>
  <button type="submit" name="add_skill">Add Skill</button>
</form>

<!-- Service Form -->
<form class="form-section" id="service-form" method="POST" novalidate>
  <h3>Add Service</h3>
  <input type="text" name="service_title" placeholder="Service Title" required>
  <textarea name="service_description" placeholder="Service Description" rows="5" required></textarea>
  <button type="submit" name="add_service">Add Service</button>
</form>

<!-- Review Form -->
<form class="form-section" id="review-form" method="POST" novalidate>
  <h3>Add Review</h3>
  <input type="text" name="reviewer_name" placeholder="Reviewer Name" required>
  <textarea name="review_content" placeholder="Review Content" rows="4" required></textarea>
  <button type="submit" name="add_review">Add Review</button>
</form>

<script>
  // Show only the selected form with smooth fade
  document.getElementById('content-type').addEventListener('change', function () {
    document.querySelectorAll('.form-section').forEach(form => form.classList.remove('active'));
    const selected = this.value;
    if (selected) {
      const activeForm = document.getElementById(selected + '-form');
      if (activeForm) {
        activeForm.classList.add('active');
        // Focus first input for accessibility
        const firstInput = activeForm.querySelector('input, textarea, select, button');
        if (firstInput) firstInput.focus();
      }
    }
  });
</script>

</body>
</html>
