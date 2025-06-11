<?php
session_start();

// Mostrar todos los errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
try {
    $db = new PDO('sqlite:partides.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Comprobar si el correo electrónico y la contraseña han sido enviados
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Recoger los datos del formulario
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        // Depuración: Verificar si el correo electrónico es correcto
        echo "Correo electrónico recibido: " . htmlspecialchars($email) . "<br>";

        // Consultar la base de datos por el email del usuario
        $stmt = $db->prepare("SELECT id, password FROM usuaris WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Depuración: Verificar si la consulta ha devuelto un usuario
        if ($user) {
            echo "Usuario encontrado: <br>";
            var_dump($user);
        } else {
            echo "No se ha encontrado el usuario en la base de datos.<br>";
        }

        if ($user) {
            // Verificar la contraseña con password_verify
            if (password_verify($password, $user['password'])) {
                // Guardar el id del usuario en la sesión para mantener el estado de login
                $_SESSION['usuari_id'] = $user['id'];
                $_SESSION['email'] = $email;

                // Redirigir al usuario a la página principal o dashboard
                header('Location: joc.php');
                exit();
            } else {
                echo "Usuari o contrasenya incorrecta!";
            }
        } else {
            echo "Usuari o contrasenya incorrecta!";
        }
    } else {
        echo "Por favor, rellena todos los campos del formulario.";
    }
}
?>

<!-- HTML del formulario de login -->
<h2>Iniciar Sessió</h2>
<form method="POST">
    Correu electrònic: <input type="text" name="email" required><br>
    Contrasenya: <input type="password" name="password" required><br>
    <input type="submit" value="Iniciar sessió">
</form>