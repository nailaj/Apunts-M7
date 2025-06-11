
<?php
// Obtenir dades de l'API de REST Countries
function getCountriesData() {
    $json = file_get_contents('https://restcountries.com/v3.1/all?fields=name,flags');
    return json_decode($json, true);
}
?>
