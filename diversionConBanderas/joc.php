
<?php
session_start();
include('functions.php');

if (!isset($_SESSION['pregunta'])) {
    $_SESSION['pregunta'] = 0;
    $_SESSION['encerts'] = 0;
}

if (!isset($_SESSION['usuari_id'])) {
    header('Location: login.php');
    exit();
}

$countries = getCountriesData();
$correct = $countries[array_rand($countries)];
$nomCorrecte = $correct['name']['common'];
$bandera = $correct['flags']['png'];

$opcions = [$nomCorrecte];
while (count($opcions) < 4) {
    $aleatori = $countries[array_rand($countries)];
    $nom = $aleatori['name']['common'];
    if (!in_array($nom, $opcions)) {
        $opcions[] = $nom;
    }
}

shuffle($opcions);
$_SESSION['resposta_correcta'] = $nomCorrecte;
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Pregunta <?= $_SESSION['pregunta'] + 1 ?>/10</title>
</head>
<body>
    <h2>Pregunta <?= $_SESSION['pregunta'] + 1 ?> de 10</h2>
    <img src="<?= $bandera ?>" alt="Bandera" width="150"><br><br>

    <form action="joc_resposta.php" method="post">
        <?php foreach ($opcions as $opcio): ?>
            <button type="submit" name="resposta" value="<?= htmlspecialchars($opcio) ?>">
                <?= htmlspecialchars($opcio) ?>
            </button><br><br>
        <?php endforeach; ?>
    </form>
</body>
</html>
