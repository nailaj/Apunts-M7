<?php
include 'includes/dbConnect.proc.php';
include 'includes/ErrorHandler.proc.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$ciclista = $db->querySingle("SELECT * FROM corredors WHERE cor_id = $id", true);

if (!$ciclista) {
    $error = "Ciclista no trobat.";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['cor_nom'] ?? '';
    $cognoms = $_POST['cor_cognoms'] ?? '';
    $equip = $_POST['cor_equip'] ?? '';
    $nacionalitat = $_POST['cor_nacionalitat'] ?? '';
    $edat = $_POST['cor_edat'] ?? '';
    $foto = $_POST['cor_foto'] ?? null;

    if ($nom && $cognoms && $equip && $nacionalitat && $edat) {
        $stmt = $db->prepare("UPDATE corredors SET cor_nom = :cor_nom, cor_cognoms = :cor_cognoms, cor_equip = :cor_equip, cor_nacionalitat = :cor_nacionalitat, cor_edat = :cor_edat, cor_foto = :cor_foto WHERE cor_id = :cor_id");
        $stmt->bindValue(':cor_nom', $nom, SQLITE3_TEXT);
        $stmt->bindValue(':cor_cognoms', $cognoms, SQLITE3_TEXT);
        $stmt->bindValue(':cor_equip', $equip, SQLITE3_TEXT);
        $stmt->bindValue(':cor_nacionalitat', $nacionalitat, SQLITE3_TEXT);
        $stmt->bindValue(':cor_edat', $edat, SQLITE3_INTEGER);
        $stmt->bindValue(':cor_foto', $foto, SQLITE3_TEXT);
        $stmt->bindValue(':cor_id', $id, SQLITE3_INTEGER);
        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Error en actualitzar el ciclista.";
        }
    } else {
        $error = "Tots els camps obligatoris han de ser omplerts.";
    }
}
?>

<?php include 'includes/head.html'; ?>

<h1>Modificar Ciclista</h1>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<?php if ($ciclista): ?>
<form method="POST" action="update.php?id=<?php echo $id; ?>">
    <div>
        <label for="cor_nom">Nom:</label>
        <input type="text" id="cor_nom" name="cor_nom" value="<?php echo htmlspecialchars($ciclista['cor_nom']); ?>" required />
    </div>
    <div>
        <label for="cor_cognoms">Cognoms:</label>
        <input type="text" id="cor_cognoms" name="cor_cognoms" value="<?php echo htmlspecialchars($ciclista['cor_cognoms']); ?>" required />
    </div>
    <div>
        <label for="cor_equip">Equip:</label>
        <input type="text" id="cor_equip" name="cor_equip" value="<?php echo htmlspecialchars($ciclista['cor_equip']); ?>" required />
    </div>
    <div>
        <label for="cor_nacionalitat">Nacionalitat:</label>
        <input type="text" idammo
        <input type="text" id="cor_nacionalitat" name="cor_nacionalitat" value="<?php echo htmlspecialchars($ciclista['cor_nacionalitat']); ?>" required />
    </div>
    <div>
        <label for="cor_edat">Edat:</label>
        <input type="number" id="cor_edat" name="cor_edat" value="<?php echo $ciclista['cor_edat']; ?>" required min="18" max="99" />
    </div>
    <div>
        <label for="cor_foto">URL de la foto:</label>
        <input type="url" id="cor_foto" name="cor_foto" value="<?php echo htmlspecialchars($ciclista['cor_foto'] ?? ''); ?>" placeholder="https://exemple.com/foto.jpg" />
    </div>
    <button type="submit">Desar</button>
    <a href="index.php">Cancel·lar</a>
</form>
<?php else: ?>
<p>No s'ha trobat el ciclista.</p>
<p><a href="index.php">Tornar</a></p>
<?php endif; ?>

<?php
$db->close();
include 'includes/foot.html';
?>