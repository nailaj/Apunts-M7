
<?php
$categoria = $_GET['userId'] ?? null;
if (!$categoria) {
    echo "No hi ha categoria especificada";
    exit;
}

$url = "https://jsonplaceholder.typicode.com/posts?userId=" . urlencode($categoria);
$resposta = file_get_contents($url);
$productes = json_decode($resposta);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Posts de l'usuari - <?= htmlspecialchars(ucfirst($categoria)) ?></title>
</head>
<body>
    <h1>Posts de l'usuari: <?= htmlspecialchars(ucfirst($categoria)) ?></h1>
    <ul>
        <?php if ($productes && is_array($productes)): ?>
            <?php foreach ($productes as $post): ?>
                <li>
                    <strong><?= htmlspecialchars($post->title) ?></strong><br>
                    <p><?= htmlspecialchars($post->body) ?></p><br>
                    <a href = "comments.php?postId=<?= urlencode($post->id) ?>"Afegir comentari</a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No hi ha posts per aquest usuari.</li>
        <?php endif; ?>
    </ul>
    <p><a href="index.php">← Tornar a usuaris</a></p>
</body>
</html>
