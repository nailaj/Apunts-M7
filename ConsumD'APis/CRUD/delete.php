<?php
// Verificamos si el 'id' está presente en la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Configuramos la URL para eliminar la broma
    $url = "https://api101.up.railway.app/joke/$id";

    // Inicializamos CURL para hacer el DELETE
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");  // Método DELETE

    // Establecemos el tipo de contenido (Content-Type: application/json)
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    // Indicamos que queremos la respuesta en lugar de que se imprima directamente
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Ejecutamos la solicitud
    $response = curl_exec($ch);

    // Verificamos si hubo algún error en la solicitud CURL
    if (curl_errno($ch)) {
        echo "Error al eliminar la broma: " . curl_error($ch);
    } else {
        // Decodificamos la respuesta JSON
        $json_response = json_decode($response, true);

        // Verificamos si la API indicó que la eliminación fue exitosa
        if ($json_response['success']) {
            echo "Broma eliminada con éxito.";
            echo "<br><a href='index.php'>← Volver a la lista de bromas</a>";
        } else {
            echo "No se pudo eliminar la broma.";
            echo "<br><a href='index.php'>← Volver a la lista de bromas</a>";
        }
    }

    // Cerramos la sesión de CURL
    curl_close($ch);
} else {
    echo "No se ha especificado un ID de broma.";
    echo "<br><a href='index.php'>← Volver a la lista de bromas</a>";
}
?>
