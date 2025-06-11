<?php
include 'includes/head.html';
include 'includes/dbConnect.proc.php';
include 'includes/ErrorHandler.proc.php';
?>

<h1>Llista de Ciclistes</h1>
<ul>
<?php
$resultats = $db->query("SELECT * FROM corredors");
while ($fila = $resultats->fetchArray(SQLITE3_ASSOC)) {
    echo "<li>";
    echo "<strong>" . htmlspecialchars($fila['cor_nom']) . " " . htmlspecialchars($fila['cor_cognoms']) . "</strong> ";
    echo "(" . htmlspecialchars($fila['cor_nacionalitat']) . ", " . $fila['cor_edat'] . " anys) - ";
    echo htmlspecialchars($fila['cor_equip']);
    if ($fila['cor_foto']) {
        echo "<br><img src='" . htmlspecialchars($fila['cor_foto']) . "' alt='Foto de " . htmlspecialchars($fila['cor_nom']) . "' width='100'>";
    }
    echo "<br><a href='update.php?id=" . $fila['cor_id'] . "'>Modificar</a> ";
    echo "<a href='delete.php?id=" . $fila['cor_id'] . "' style='color:red;'>Eliminar</a>";
    echo "</li>";
}
if ($resultats->numColumns() == 0) {
    echo "<li>No hi ha ciclistes registrats.</li>";
}
?>
</ul>
<p><a href="index.php">Tornar al menú</a></p>

<?php
$db->close();
include 'includes/foot.html';
?>