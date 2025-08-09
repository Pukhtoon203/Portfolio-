<?php require 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage All Records</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    :root {
      --bg: #121217;
      --text: #e1e1e6;
      --accent: #ffb400;
      --accent2: #d0a628;
      --shadow: 0 6px 30px rgba(0, 170, 255, 0.1);
      --card-bg: rgba(30, 30, 38, 0.85);
      --border: #22222a;
      --input-bg: #1e1e27;
      --input-border: #333344;
      --font-family: 'Montserrat', Arial, sans-serif;
    }

    /* Base styles */
    body {
      font-family: var(--font-family);
      background: var(--bg);
      color: var(--text);
      padding: 40px 20px;
      margin: 0;
      min-height: 100vh;
    }

    h2 {
      text-align: center;
      color: var(--accent);
      padding: 14px 20px;
      border-radius: 8px;
      margin-top: 50px;
      box-shadow: var(--shadow);
      font-weight: 700;
      font-size: 2rem;
      user-select: none;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: var(--card-bg);
      border: 1px solid var(--border);
      box-shadow: var(--shadow);
      border-radius: 12px;
      overflow: hidden;
    }

    th, td {
      padding: 14px 16px;
      text-align: left;
      border-bottom: 1px solid var(--border);
      vertical-align: middle;
      color: var(--text);
      font-size: 1rem;
    }

    th {
      background: var(--accent2);
      color: #000;
      font-weight: 700;
      user-select: none;
    }

    th:last-child,
    td:last-child {
      text-align: right;
    }

    /* Images in table */
    td img {
      max-height: 60px;
      border-radius: 5px;
      object-fit: cover;
      display: block;
      max-width: 100px;
    }

    /* Actions container */
    .actions {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      flex-wrap: wrap;
    }

    /* Action buttons */
     /* Action buttons (Edit, etc.) */
.action {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 10px 20px;
  font-size: 0.9rem;
  font-weight: 700;
  border-radius: 32px;
  text-decoration: none;
  background: var(--accent);
  color: #121217; /* Dark text for contrast */
  box-shadow: 0 6px 24px var(--accent)88;
  transition: background 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
  user-select: none;
  cursor: pointer;
  border: none;
}

.action:hover,
.action:focus {
  background: var(--accent2);
  box-shadow: 0 12px 32px var(--accent2)cc;
  outline: none;
  color: #121217;
  transform: translateY(-3px);
}

/* Delete buttons */
.delete {
  background: #e74c3c;
  color: #fff;
  box-shadow: 0 6px 24px rgba(231, 76, 60, 0.7);
  border-radius: 32px;
  padding: 10px 20px;
  font-weight: 700;
  font-size: 0.9rem;
  cursor: pointer;
  border: none;
  transition: background 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
  user-select: none;
}

.delete:hover,
.delete:focus {
  background: #c0392b;
  box-shadow: 0 12px 32px rgba(192, 57, 43, 0.9);
  outline: none;
  transform: translateY(-3px);
  color: #fff;
}


    /* Responsive adjustments */
    @media (max-width: 992px) {
      th, td {
        font-size: 0.9rem;
        padding: 10px 12px;
      }
      td img {
        max-width: 80px;
      }
    }

    @media (max-width: 600px) {
      body {
        padding: 20px 10px;
      }
      table {
        font-size: 0.85rem;
      }
      th, td {
        padding: 8px 10px;
      }
      td img {
        max-width: 60px;
      }
      .actions {
        justify-content: center;
      }
      .action {
        padding: 6px 10px;
        font-size: 0.75rem;
      }
    }
  </style>
</head>
<body>

  <!-- BLOGS -->
  <h2>All Blogs</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th><th>Title</th><th>Image</th><th>Date</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $result = $conn->query("SELECT * FROM blogs ORDER BY id DESC");
      while ($row = $result->fetch_assoc()):
      ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['title']) ?></td>
          <td><img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="Blog Image"></td>
          <td><?= $row['created_at'] ?></td>
          <td>
            <div class="actions">
              <a class="action" href="blog/edit.php?id=<?= $row['id'] ?>">Edit</a>
              <a class="action delete" href="blog/delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this blog?')">Delete</a>
            </div>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <!-- PROJECTS -->
  <h2>All Projects</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th><th>Title</th><th>Image</th><th>Date</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $result = $conn->query("SELECT * FROM projects ORDER BY id DESC");
      while ($row = $result->fetch_assoc()):
      ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['title']) ?></td>
          <td><img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="Project Image"></td>
          <td><?= $row['created_at'] ?></td>
          <td>
            <div class="actions">
              <a class="action" href="project/edit.php?id=<?= $row['id'] ?>">Edit</a>
              <a class="action delete" href="project/delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this project?')">Delete</a>
            </div>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <!-- SKILLS -->
  <h2>All Skills</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th><th>Name</th><th>Level</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $result = $conn->query("SELECT * FROM skills ORDER BY id DESC");
      while ($row = $result->fetch_assoc()):
      ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['level']) ?></td>
          <td>
            <div class="actions">
              <a class="action" href="skills/edit.php?id=<?= $row['id'] ?>">Edit</a>
              <a class="action delete" href="skills/delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this skill?')">Delete</a>
            </div>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <!-- SERVICES -->
  <h2>All Services</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th><th>Title</th><th>Description</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $result = $conn->query("SELECT * FROM services ORDER BY id DESC");
      while ($row = $result->fetch_assoc()):
      ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['title']) ?></td>
          <td><?= htmlspecialchars($row['description']) ?></td>
          <td>
            <div class="actions">
              <a class="action" href="services/edit.php?id=<?= $row['id'] ?>">Edit</a> <br>
              <a class="action delete" href="services/delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this service?')">Delete</a>
            </div>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <!-- REVIEWS -->
  <h2>All Reviews</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th><th>Name</th><th>Message</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $result = $conn->query("SELECT * FROM reviews ORDER BY id DESC");
      while ($row = $result->fetch_assoc()):
      ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['name'] ?? '') ?></td>
          <td><?= htmlspecialchars($row['content']) ?></td>
          <td>
            <div class="actions">
              <a class="action" href="reviews/edit.php?id=<?= $row['id'] ?>">Edit</a>
              <a class="action delete" href="reviews/delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this review?')">Delete</a>
            </div>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

</body>
</html>
