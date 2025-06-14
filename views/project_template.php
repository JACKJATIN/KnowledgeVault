<?php
// Retrieve BASE_URL from the environment variable; fallback to localhost.
$baseUrl = getenv('BASE_URL') ? rtrim(getenv('BASE_URL'), '/') : 'http://localhost/HOLTEC';

// Helper function to generate sortable column header links.
function sortLink($column, $label) {
    $currentSortBy = $_GET['sort_by'] ?? '';
    $currentSortOrder = strtoupper($_GET['sort_order'] ?? 'DESC');
    $newOrder = 'ASC';
    if ($currentSortBy === $column) {
        $newOrder = ($currentSortOrder === 'ASC') ? 'DESC' : 'ASC';
    }
    $url = "index.php?action=list&sort_by=" . urlencode($column) . "&sort_order=" . urlencode($newOrder);
    return '<a href="' . $url . '">' . htmlspecialchars($label) . '</a>';
}
?>

<h1>Knowledge Vault / InfoSphere </h1>

<!-- Search & Filter Form -->
<form action="index.php" method="get" class="search-filters">
  <input type="hidden" name="action" value="list">
  
  <div class="filter-item">
    <label for="search">Search:</label>
    <input type="text" name="search" id="search" placeholder="Enter description, ID, author or date" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
  </div>
  
  <div class="filter-item">
    <label for="category">Section:</label>
    <select name="category" id="category">
      <option value="">All Sections</option>
      <option value="Mechanical" <?= (isset($_GET['category']) && $_GET['category'] == 'Mechanical') ? 'selected' : '' ?>>Mechanical</option>
      <option value="E&I" <?= (isset($_GET['category']) && $_GET['category'] == 'E&I') ? 'selected' : '' ?>>E&I</option>
      <option value="Raw Material" <?= (isset($_GET['category']) && $_GET['category'] == 'Raw Material') ? 'selected' : '' ?>>Raw Material</option>
      <option value="Business Consulting" <?= (isset($_GET['category']) && $_GET['category'] == 'Business Consulting') ? 'selected' : '' ?>>Business Consulting</option>
      <option value="Roads and Highway" <?= (isset($_GET['category']) && $_GET['category'] == 'Roads and Highway') ? 'selected' : '' ?>>Roads and Highway</option>
      <option value="Project" <?= (isset($_GET['category']) && $_GET['category'] == 'Project') ? 'selected' : '' ?>>Project</option>
      <option value="Power" <?= (isset($_GET['category']) && $_GET['category'] == 'Power') ? 'selected' : '' ?>>Power</option>
      <option value="Process" <?= (isset($_GET['category']) && $_GET['category'] == 'Process') ? 'selected' : '' ?>>Process</option>
      <option value="Other" <?= (isset($_GET['category']) && $_GET['category'] == 'Other') ? 'selected' : '' ?>>Other</option>
    </select>
  </div>
  
  <div class="filter-item filter-button">
    <button type="submit">Search</button>
  </div>
</form>

<div class="table-responsive">
    <table class="projects-table">
        <thead>
            <tr>
                <th><?= sortLink('id', 'ID') ?></th>
                <th><?= sortLink('section', 'Section') ?></th>
                <th><?= sortLink('description', 'Description') ?></th>
                <th><?= sortLink('type_of_document', 'Doc-Type') ?></th>
                <th><?= sortLink('source_of_information', 'Info-Source') ?></th>
                <!-- Combined column: Uploaded By and Upload Date -->
                <th>Uploaded By / Date</th>
                <th><?= sortLink('rating', 'Rating (Avg)') ?></th>
                <th>Files</th>
                <th>Usefulness</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($projects)): ?>
                <?php foreach ($projects as $project): 
                    $rating = isset($project['rating']) ? $project['rating'] : 0;
                    
                    // Process the file path.
                    $file = trim($project['file_path']);
                    if (!empty($file)) {
                        if (strpos($file, 'http://') !== 0 && strpos($file, 'https://') !== 0) {
                            $file = $baseUrl . '/' . ltrim($file, '/');
                        }
                        $fileLink = '<a href="' . htmlspecialchars($file) . '" target="_blank" class="view-btn">View File</a>';
                    } else {
                        $fileLink = "";
                    }
                    
                    // Format creation date as dd/mm/yyyy.
                    $uploadDate = date("d/m/Y", strtotime($project['creation_date']));
                ?>
                <tr>
                    <td><?= htmlspecialchars($project['id']) ?></td>
                    <td><?= htmlspecialchars($project['section']) ?></td>
                    <td><?= htmlspecialchars($project['description']) ?></td>
                    <td><?= htmlspecialchars($project['type_of_document']) ?></td>
                    <td><?= htmlspecialchars($project['source_of_information']) ?></td>
                    <!-- Combine Uploaded By and Creation Date -->
                    <td>
                      <?= htmlspecialchars($project['author']) ?><br>
                      <?= $uploadDate ?>
                    </td>
                    <td><?= number_format($rating, 2) ?></td>
                    <td class="files-column"><?= $fileLink ?></td>
                    <td>
                        <!-- Star-based rating links -->
                        <a href="index.php?action=rate&id=<?= htmlspecialchars($project['id']) ?>&stars=5" class="upvote-btn">5★</a>
                        <a href="index.php?action=rate&id=<?= htmlspecialchars($project['id']) ?>&stars=4" class="upvote-btn">4★</a>
                        <a href="index.php?action=rate&id=<?= htmlspecialchars($project['id']) ?>&stars=3" class="upvote-btn">3★</a>
                        <a href="index.php?action=rate&id=<?= htmlspecialchars($project['id']) ?>&stars=2" class="upvote-btn">2★</a>
                        <a href="index.php?action=rate&id=<?= htmlspecialchars($project['id']) ?>&stars=1" class="downvote-btn">1★</a>
                        <br>
                        <!-- Link to dedicated project page for comments -->
                        <a href="index.php?action=project&id=<?= htmlspecialchars($project['id']) ?>">Add/View Comments</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No documents found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
