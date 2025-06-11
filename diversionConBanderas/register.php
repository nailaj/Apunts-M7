<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new PDO('sqlite:partides.db');
    $nom = $_POST['nom'];
    $password = $_POST['password'];

    // Verificar si l'usuari ja existeix
    $stmt = $db->prepare("SELECT id FROM usuaris WHERE nom = ?");
    $stmt->execute([$nom]);
    if ($stmt->rowCount() > 0) {
        echo "Error: Aquest usuari ja existeix.";
    } else {
        // Crear un usuari nou
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO usuaris (nom, password) VALUES (?, ?)");
        $stmt->execute([$nom, $hashed_password]);
        echo "Usuari registrat correctament!";
    }
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Registre d'usuari</title>
</head>
<body>
    <h2>Registrar-se</h2>
    <form method="POST">
        Nom d'usuari: <input type="text" name="nom" required><br>
        Contrasenya: <input type="password" name="password" required><br>
        <input type="submit" value="Registrar">
    </form>
</body>
</html>