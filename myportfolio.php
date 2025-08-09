<!DOCTYPE html>
<html lang="en">
<head>
  <?php require 'includes/db.php'; ?>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>IUD Portfolio</title>
  <meta name="description" content="Ijaz Ullah's portfolio: web development, projects, services, and contact." />
  <link rel="stylesheet" href="myportfolio.css" />
  <link rel="icon" href="images/iud.jpg" type="image/jpeg" />
  
</head>
<body>

  <!-- HEADER & NAVIGATION -->
  <header>
    <div class="logo">
      <img src="images/ijaz.png" alt="Ijaz Ullah Logo" />
    </div>
    <nav class="nav-links" aria-label="Main Navigation">
      <ul>
        <li><a href="#home">HOME</a></li>
        <li><a href="#blog">BLOG</a></li>
        <li><a href="#project">PROJECTS</a></li>
        <li><a href="#services">SERVICES</a></li>
        <li><a href="#reviews">REVIEWS</a></li>
        <li><a href="#about">ABOUT</a></li>
        <li><a href="#contact">CONTACT</a></li>
      </ul>
    </nav>
  </header>

  <main>

    <!-- HOME SECTION -->
    <section id="home" class="intro container">
      <div class="left">
        <h1>I’m Ijaz Ullah</h1>
        <div class="typing-container">
        <h1><span class="prefix">Web 
        <span id="dynamic-text" class="dynamic-text"></span></span></h1></div> <br>
        <p>I create fast, responsive, and SEO-friendly websites to help businesses grow online.</p>
        <a href="cv/IjazUllahCV.pdf" class="download-btn" download>Download CV</a>
      </div>
      <div class="right">
        <img src="images/ejaz.jpg" alt="Ijaz Ullah" />
      </div>
    </section>

    <!-- ABOUT SECTION -->
    <section id="about" class="about-section">
      <div class="section-title">
        <h2>About Me</h2>
        <p>Get to know me</p>
      </div>
      <div class="about-content">
        <div class="about-text">
          <p>
            Hi! I’m Ijaz Ullah, a passionate web developer with a knack for creating modern, user-friendly websites and apps. With years of experience in frontend and backend technologies, I help businesses and individuals bring their digital visions to life.
          </p>
          <ul>
            <li>2+ years in web development</li>
            <li>Specialized in Database, HTML5, and Java</li>
            <li>Committed to quality, speed, and client satisfaction</li>
          </ul>
        </div>
      </div>
    </section>

    <!-- SERVICES SECTION -->
     <section id="services" class="services-section">
  <h2>Services & Skills</h2>
  <p>What I Offer & What I’m Good At</p>

  <div class="services-grid">
    <?php
    // Fetch exactly 3 services
    $result = $conn->query("SELECT * FROM services ORDER BY id DESC LIMIT 3");
    if ($result && $result->num_rows > 0):
      while ($row = $result->fetch_assoc()):
    ?>
      <div class="service-card">
        <h4><?= htmlspecialchars($row['title']) ?></h4>
        <p><?= htmlspecialchars($row['description']) ?></p>
      </div>
    <?php
      endwhile;
    endif;
    ?>
  </div>

  <div class="skills-box">
    <h3>My Skills</h3>
    <ul class="skills-list">
      <?php
      // Fetch exactly 5 skills
      $result = $conn->query("SELECT * FROM skills ORDER BY id DESC LIMIT 5");
      if ($result && $result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
      ?>
        <li><?= htmlspecialchars($row['name']) ?> — <?= htmlspecialchars($row['level']) ?></li>
      <?php
        endwhile;
      endif;
      ?>
    </ul>
  </div>
</section>
    <!-- PROJECTS SECTION -->
    <section id="project" class="blog-section">
      <div class="section-title">
        <h3>Recent Projects</h3>
        <p>Check out the latest projects posts. <style>color: #ffffff </style></p>
      </div>
      <div class="blog-grid">
        <?php
        $sql = "SELECT * FROM projects ORDER BY created_at DESC LIMIT 3";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0):
          while ($row = $result->fetch_assoc()):
        ?>
          <div class="project-item">
            <a href="project/project.php?id=<?= urlencode($row['id']); ?>">
              <img src="uploads/<?= htmlspecialchars($row['image']); ?>" alt="<?= htmlspecialchars($row['title']); ?>">
            </a>
            <h3>
              <a href="project/project.php?id=<?= urlencode($row['id']); ?>" style="color:#ffb400;text-decoration:none;">
                <?= htmlspecialchars($row['title']); ?>
              </a>
            </h3>
          </div>
        <?php
          endwhile;
        endif;
        ?>
      </div>
    </section>

    <!-- BLOG SECTION -->
    <section id="blog" class="blog-section">
      <div class="section-title">
        <h2>Recent Blogs</h2>
        <p>Check out the latest blog posts.</p>
      </div>
      <div class="blog-grid">
        <?php
        $sql = "SELECT * FROM blogs ORDER BY created_at DESC LIMIT 3";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0):
          while ($row = $result->fetch_assoc()):
        ?>
          <div class="blog-item">
            <a href="blog/blog.php?id=<?= urlencode($row['id']); ?>">
              <img src="uploads/<?= htmlspecialchars($row['image']); ?>" alt="<?= htmlspecialchars($row['title']); ?>">
            </a>
            <h3>
              <a href="blog/blog.php?id=<?= urlencode($row['id']); ?>" style="color:#ffb400;text-decoration:none;">
                <?= htmlspecialchars($row['title']); ?>
              </a>
            </h3>
          </div>
        <?php
          endwhile;
        endif;
        ?>
      </div>
    </section>

    <!-- REVIEWS SECTION -->
     <?php
// Determine current page from query parameter, default to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$reviewsPerPage = 3;
$offset = ($page - 1) * $reviewsPerPage;

// Get total number of reviews
$totalResult = $conn->query("SELECT COUNT(*) as total FROM reviews");
$totalReviews = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalReviews / $reviewsPerPage);

// Fetch reviews for current page
$query = $conn->query("SELECT * FROM reviews ORDER BY id DESC LIMIT $offset, $reviewsPerPage");
?>

<section class="reviews" id="reviews">
  <h2 class="section-title">Client Reviews</h2>
  <p>Real words from those I've worked with</p>

  <div class="review-wrapper">
    <?php if ($query && $query->num_rows > 0): ?>
      <?php while ($row = $query->fetch_assoc()): ?>
        <div class="review-card" tabindex="0">
          <p>“<?= htmlspecialchars($row['content']) ?>”</p>
          <span >- <?= htmlspecialchars($row['name'] ?? 'Anonymous')  ?></span>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No reviews found.</p>
    <?php endif; ?>
  </div>

  <!-- Pagination -->
  <nav class="pagination" aria-label="Reviews Pagination">
    <?php if ($page > 1): ?>
      <a href="?page=<?= $page - 1 ?>" class="pagination-link">&laquo; Previous</a>
    <?php endif; ?>

    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
      <?php if ($p == $page): ?>
        <span class="pagination-current"><?= $p ?></span>
      <?php else: ?>
        <a href="?page=<?= $p ?>" class="pagination-link"><?= $p ?></a>
      <?php endif; ?>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
      <a href="?page=<?= $page + 1 ?>" class="pagination-link">Next &raquo;</a>
    <?php endif; ?>
  </nav>
</section>

    <!-- CONTACT SECTION -->
    <section id="contact" class="contact-section">
      <div class="contact-container">
        <div class="contact-right">
          <h2>Get In Touch</h2>
          <form action="contact.php" method="POST" class="contact-form" autocomplete="off">
            <!-- Example CSRF token (implement in contact.php) -->
            <!-- <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>"> -->
            <div class="form-row">
              <input type="text" name="name" placeholder="Full Name" required />
            </div>
            <div class="form-row">
              <input type="email" name="email" placeholder="Email Address" required />
            </div>
            <div class="form-row">
              <input type="text" name="subject" placeholder="Subject" required />
            </div>
            <div class="form-row">
              <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
            </div>
            <button type="submit" class="submit-btn">Submit</button>
          </form>
        </div>
      </div>
    </section>

  </main>

  <footer>
    <p><small>&copy; 2025 Ijaz Ullah. All rights reserved.</small></p>
  </footer>

   <script>
    const words = ['Developer', 'Designer'];
    const typingSpeed = 140; // milliseconds per character
    const erasingSpeed = 80;
    const delayBetweenWords = 1500; // delay before typing next word

    let wordIndex = 0;
    let charIndex = 0;
    const dynamicText = document.getElementById('dynamic-text');

    function type() {
      if (charIndex < words[wordIndex].length) {
        dynamicText.textContent += words[wordIndex].charAt(charIndex);
        charIndex++;
        setTimeout(type, typingSpeed);
      } else {
        setTimeout(erase, delayBetweenWords);
      }
    }

    function erase() {
      if (charIndex > 0) {
        dynamicText.textContent = words[wordIndex].substring(0, charIndex - 1);
        charIndex--;
        setTimeout(erase, erasingSpeed);
      } else {
        wordIndex++;
        if (wordIndex >= words.length) wordIndex = 0;
        setTimeout(type, typingSpeed);
      }
    }

    // Start the typing effect on page load
    document.addEventListener('DOMContentLoaded', () => {
      setTimeout(type, delayBetweenWords);
    });
  </script>

</body>
</html>