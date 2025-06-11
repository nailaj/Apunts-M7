
<?php
session_start();

// Comprovar si l'usuari està autenticat
if (!isset($_SESSION['usuari_id'])) {
    header("Location: login.php");
    exit();
}
?>
