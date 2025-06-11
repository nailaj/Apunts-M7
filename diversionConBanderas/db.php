
<?php
// Conexió a la base de dades SQLite
try {
    $db = new PDO('sqlite:partides.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de connexió: " . $e->getMessage());
}
?>
