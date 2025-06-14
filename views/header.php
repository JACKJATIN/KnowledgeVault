<header class="header">
  <div class="logo">
    <img src="assets/logo.jpg" alt="ABC Logo" class="logo-img">
    <span class="logo-text">ABC Company</span>
  </div>
  <nav class="nav">
    <?php if (isset($_SESSION['username'])): ?>
      <a href="index.php?action=list">View Documents</a>
      <a href="index.php?action=add">Add Document</a>
      <a href="index.php?action=logout">Logout (<?= htmlspecialchars($_SESSION['username']) ?>)</a>
    <?php else: ?>
      <a href="index.php?action=login">Login</a>
      <a href="index.php?action=signup">Sign Up</a>
    <?php endif; ?>
  </nav>
</header>
