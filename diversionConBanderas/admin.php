<?php
session_start();
require_once 'auth.php';
require_once 'db.php';

// Comprovar si l'usuari és administrador
if ($_SESSION['usuari_id'] != 1) { // Suposant que l'ID de l'administrador és 1
    header("Location: index.php");
    exit;
}

// Obtenir el rànquing complet
$stmt = $db->query("SELECT usuaris.nom, puntuacions.puntuacio FROM puntuacions JOIN usuaris ON puntuacions.usuari_id = usuaris.id ORDER BY puntuacions.puntuacio DESC");
$ranking = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Gestió del Rànquing (Administrador)</h2>
<table>
    <tr>
        <th>Nom</th>
        <th>Puntuació</th>
    </tr>
    <?php foreach ($ranking as $r): ?>
        <tr>
            <td><?= htmlspecialchars($r['nom']) ?></td>
            <td><?= htmlspecialchars($r['puntuacio']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>