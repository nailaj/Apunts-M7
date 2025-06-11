
<?php
session_start();
require_once 'auth.php'; // Comprovar si l'usuari està autenticat

// Obtenir les partides de l'usuari
$stmt = $db->prepare("SELECT partides.puntuacio, partides.data FROM partides WHERE partides.usuari_id = ?");
$stmt->execute([$_SESSION['usuari_id']]);
$partides = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Les teves partides</h2>
<table>
    <tr>
        <th>Puntuació</th>
        <th>Data</th>
    </tr>
    <?php foreach ($partides as $partida): ?>
        <tr>
            <td><?= htmlspecialchars($partida['puntuacio']) ?></td>
            <td><?= htmlspecialchars($partida['data']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
