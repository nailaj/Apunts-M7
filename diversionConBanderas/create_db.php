
<?php
// Mostrar todos los errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Crear la base de datos SQLite y las tablas necesarias
try {
    $db = new PDO('sqlite:partides.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Crear tabla 'usuaris'
    $db->exec("CREATE TABLE IF NOT EXISTS usuaris (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nom TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL
    );");

    // Crear tabla 'partides'
    $db->exec("CREATE TABLE IF NOT EXISTS partides (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        usuari_id INTEGER NOT NULL,
        puntuacio INTEGER NOT NULL,
        data TEXT DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuari_id) REFERENCES usuaris(id)
    );");

    // Crear tabla 'puntuacions'
    $db->exec("CREATE TABLE IF NOT EXISTS puntuacions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        usuari_id INTEGER NOT NULL,
        puntuacio INTEGER NOT NULL,
        data TEXT DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuari_id) REFERENCES usuaris(id)
    );");

    echo "Base de dades creada amb èxit!<br>";

    // Crear un usuari per defecte si no existeix
    $stmt = $db->prepare("SELECT id FROM usuaris WHERE email = ?");
    $stmt->execute(['admin@example.com']);
    if ($stmt->rowCount() == 0) {
        // Contrasenya encriptada
        $password = password_hash('admin123', PASSWORD_DEFAULT);

        // Inserir l'usuari administratiu
        $stmt = $db->prepare("INSERT INTO usuaris (nom, email, password) VALUES (?, ?, ?)");
        $stmt->execute(['Administrador', 'admin@example.com', $password]);
        echo "Usuari administrador creat amb èxit!<br>";
    } else {
        echo "L'usuari administrador ja existeix.<br>";
    }

} catch (PDOException $e) {
    die("Error de connexió: " . $e->getMessage());
}
?>
