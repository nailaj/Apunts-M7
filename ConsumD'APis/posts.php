<?php
$categoria = $_GET['userId'] ?? null;

if (!$categoria) {
    echo "<p><strong>Error:</strong> No s'ha especificat cap usuari.</p>";
    echo "<p><a href='index.php'>← Tornar</a></p>";
    exit;
}

$url = "https://jsonplaceholder.typicode.com/posts?userId=" . urlencode($categoria);
$productes = json_decode(file_get_contents($url)) ?? [];
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Posts de l'usuari <?= htmlspecialchars($categoria) ?></title>
</head>
<body>
    <h1>Posts de l'usuari <?= htmlspecialchars($categoria) ?></h1>
    <ul>
        <?php if (!empty($productes)): ?>
            <?php foreach ($productes as $post): ?>
                <li>
                    <strong><?= htmlspecialchars($post->title) ?></strong><br>
                    <p><?= htmlspecialchars($post->body) ?></p>
                    <a href="comments.php?postId=<?= urlencode($post->id) ?>">Afegir comentari</a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No hi ha posts per aquest usuari.</li>
        <?php endif; ?>
    </ul>
    <p><a href="index.php">← Tornar a usuaris</a></p>
</body>
</html>
