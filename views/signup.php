<div class="auth-container">
  <h1>Sign Up</h1>
  <?php if (isset($error) && !empty($error)): ?>
      <div class="error-message"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form action="index.php?action=signup" method="post">
      <label for="username">Username:</label>
      <input type="text" name="username" id="username" required>
      
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required>
      
      <button type="submit">Sign Up</button>
  </form>
  <p>Already have an account? <a href="index.php?action=login">Login</a></p>
</div>
