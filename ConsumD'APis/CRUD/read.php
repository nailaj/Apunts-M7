<?php
$url = "https://api101.up.railway.app/joke";

$response = file_get_contents($url);

$data = json_decode($response); 
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Jokes</title>
</head>
<body>
    <h1>Llista de Bromes</h1>
    <ul>
        <?php if($data && is_array($data)): ?>
            <?php foreach($data as $joke): ?>
                    <li>
                        <strong>Autor:</strong> <?= htmlspecialchars($joke->author) ?><br>
                        <strong>Broma:</strong> <?= htmlspecialchars($joke->joke) ?><br>
                        <a href="edit.php?id=<?= $joke->id ?>">Editar</a> |
                        <a href="delete.php?id=<?= $joke->id ?>" onclick="return confirm('Segur que vols eliminar aquesta broma?')"> Eliminar</a>
                    </li><br>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Error al carregar les bromes</li>
        <?php endif; ?>
    </ul>
    <br>
    <a href="create.php"> Afegir nova broma</a>
</body>
</html>
