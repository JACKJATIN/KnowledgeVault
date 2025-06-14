<?php
// Retrieve BASE_URL from the environment variable; fallback to localhost.
$baseUrl = getenv('BASE_URL') ? rtrim(getenv('BASE_URL'), '/') : 'http://localhost/HOLTEC';
?>
<div class="post-container">
  <div class="post-header">
    <h1>Document Details</h1>
    
  </div>
  <table class="details-table">
  <tr>
    <td><strong>Document ID:</strong> <?= htmlspecialchars($project['id']) ?></td>
    <td><strong>Section:</strong> <?= htmlspecialchars($project['section']) ?></td>
    <td><strong>Description:</strong> <?= htmlspecialchars($project['description']) ?></td>
    <td><strong>Type:</strong> <?= htmlspecialchars($project['type_of_document']) ?></td>
  </tr>
  <tr>
    <td><strong>Source:</strong> <?= htmlspecialchars($project['source_of_information']) ?></td>
    <td><strong>Uploaded By:</strong> <?= htmlspecialchars($project['author']) ?></td>
    <td><strong>Upload Date:</strong> <?= date("d/m/Y", strtotime($project['creation_date'])) ?></td>
    <td><strong>Rating:</strong> <?= number_format($project['rating'], 2) ?> (<?= htmlspecialchars($project['vote_count']) ?> votes)</td>
  </tr>
</table>
<?php
      $file = trim($project['file_path']);
      if (!empty($file)) {
          if (strpos($file, 'http://') !== 0 && strpos($file, 'https://') !== 0) {
              $file = $baseUrl . '/' . ltrim($file, '/');
          }
          echo '<a href="' . htmlspecialchars($file) . '" target="_blank" class="view-btn featured-btn">View File</a>';
      }
    ?>
</div>

<hr>

<h2>Comments</h2>
<?php if (isset($_GET['error'])): ?>
  <div class="error-message"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>
<?php if (isset($_GET['success'])): ?>
  <div class="success-message"><?= htmlspecialchars($_GET['success']) ?></div>
<?php endif; ?>

<div class="comments-section">
  <div class="comments-list">
    <?php if (!empty($comments)): ?>
      <?php foreach ($comments as $comment): ?>
        <div class="comment-block">
          <p class="comment-text"><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
          <div class="comment-meta">
            <span class="comment-author"><?= htmlspecialchars($comment['username']) ?></span>
            <span class="comment-date"><?= date("d/m/Y h:i A", strtotime($comment['creation_date'])) ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="no-comments">No comments yet.</p>
    <?php endif; ?>
  </div>

  <?php if (isset($_SESSION['username'])): ?>
    <div class="add-comment">
      <h3>Add a Comment</h3>
      <form action="index.php?action=addcomment" method="post" class="comment-form">
        <input type="hidden" name="project_id" value="<?= htmlspecialchars($project['id']) ?>">
        <textarea name="comment" id="comment" placeholder="Write your comment here..." required></textarea>
        <button type="submit">Submit Comment</button>
      </form>
    </div>
  <?php else: ?>
    <p class="login-prompt"><a href="index.php?action=login">Log in</a> to add a comment.</p>
  <?php endif; ?>
</div>
