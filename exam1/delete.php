<?php
include 'includes/dbConnect.proc.php';
include 'includes/ErrorHandler.proc.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $stmt = $db->prepare("DELETE FROM corredors WHERE cor_id = :cor_id");
    $stmt->bindValue(':cor_id', $id, SQLITE3_INTEGER);
    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Error en eliminar el ciclista.";
    }
} else {
    $error = "ID de ciclista no vàlid.";
}
?>

<?php include 'includes/head.html'; ?>

<h1>Eliminar Ciclista</h1>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<p><a href="index.php">Tornar a la llista</a></p>

<?php include 'includes/foot.html'; ?>