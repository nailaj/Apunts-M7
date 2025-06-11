
<?php
session_start();
require_once 'db.php';

// Obtenir el rànquing (10 millors puntuacions)
$stmt = $db->query("SELECT usuaris.nom, puntuacions.puntuacio FROM puntuacions JOIN usuaris ON puntuacions.usuari_id = usuaris.id ORDER BY puntuacions.puntuacio DESC LIMIT 10");
$ranking = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Rànquing de puntuacions</h2>
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
