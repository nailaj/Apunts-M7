
<?php
session_start();

// Conectar a la base de datos
try {
    $db = new PDO('sqlite:partides.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Comprobar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['nom']) && isset($_SESSION['encerts'])) {
        // Recoger el nombre del jugador y la puntuación
        $nom = $_POST['nom'];
        $punts = $_SESSION['encerts']; // Puntuación del jugador

        // Insertar la puntuación en la base de datos
        $stmt = $db->prepare("INSERT INTO puntuacions (usuari_id, puntuacio) VALUES (?, ?)");
        $stmt->execute([$_SESSION['usuari_id'], $punts]);

        echo "Puntuació guardada!<br>";
        echo "<a href='index.php'>Tornar a l'inici</a>";
    }
}
?>
