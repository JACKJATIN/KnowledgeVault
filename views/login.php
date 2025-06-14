<div class="auth-container">
  <h1>Login</h1>
  <?php if (isset($_GET['success'])): ?>
      <div class="success-message"><?= htmlspecialchars($_GET['success']) ?></div>
  <?php endif; ?>
  <?php if (isset($error) && !empty($error)): ?>
      <div class="error-message"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form action="index.php?action=login" method="post">
      <label for="username">Username:</label>
      <input type="text" name="username" id="username" required>
      
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required>
      
      <button type="submit">Login</button>
  </form>
  <p>Don't have an account? <a href="index.php?action=signup">Sign Up</a></p>
</div>
