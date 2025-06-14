<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title ?? 'Knowledge Vault / InfoSphere') ?></title>
    <link rel="icon" href="assets/logo.png" type="image/png">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <?= $content ?? '' ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>