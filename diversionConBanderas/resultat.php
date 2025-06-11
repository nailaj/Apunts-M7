
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Resultat</title>
</head>
<body>
    <h1>Has encertat <?= $_SESSION['encerts'] ?> de 10!</h1>
    <form action="guardar.php" method="post">
        Introdueix el teu nom:
        <input type="text" name="nom" required>
        <button type="submit">Guardar puntuació</button>
    </form>
</body>
</html>
