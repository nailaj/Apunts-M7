
<?php
session_start();
include('functions.php'); // Incloem funcions comunes com getCountriesData()

// Mostrem el país del dia
$countries = getCountriesData();
$countryOfTheDay = $countries[array_rand($countries)];

$countryName = $countryOfTheDay['name']['common'];
$flag = $countryOfTheDay['flags']['png'];
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Pàgina Principal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>El país del dia: <?= htmlspecialchars($countryName) ?></h2>
    <img src="<?= htmlspecialchars($flag) ?>" alt="Bandera" width="150">
    <p><a href="joc.php">Iniciar el joc</a></p>
    <p><a href="ranking.php">Veure el rànquing</a></p>
    <p><a href="login.php">Iniciar sessió</a></p>
</body>
</html>
