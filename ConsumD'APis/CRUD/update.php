<?php
// Verificamos si el 'id' está presente en la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtenemos la broma actual de la API
    $url = "https://api101.up.railway.app/joke/$id";
    $response = file_get_contents($url);
    $data = json_decode($response);

    // Si el formulario ha sido enviado (POST)
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $author = $_POST['author'];
        $joke = $_POST['joke'];
        $source = $_POST['source'] ?? '';  // Si no se proporciona "source", se asigna vacío

        // Datos que vamos a enviar para actualizar la broma
        $updateData = array(
            'id' => $id,
            'author' => $author,
            'joke' => $joke,
            'source' => $source
        );

        // Inicializamos CURL para hacer el PUT
        $url = "https://api101.up.railway.app/joke";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        
        // Establecemos el tipo de contenido (Content-Type: application/json)
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        
        // Enviamos los datos en formato JSON
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($updateData));

        // Indicamos que queremos la respuesta en lugar de que se imprima directamente
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Ejecutamos la solicitud
        $response = curl_exec($ch);

        // Verificamos si hubo algún error en la solicitud CURL
        if (curl_errno($ch)) {
            echo "Error al editar la broma: " . curl_error($ch);
        } else {
            // Decodificamos la respuesta JSON
            $json_response = json_decode($response, true);
            echo "¡Broma actualizada con éxito! ID: " . $json_response['id'];
            echo "<br><a href='index.php'>← Volver a la página principal</a>";
            exit();
        }
    }
} else {
    echo "No se ha encontrado la broma.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Editar Broma</title>
</head>
<body>
    <h1>Editar la Broma</h1>
    <form action="edit.php?id=<?= $id ?>" method="POST">
        <label for="author">Autor:</label><br>
        <input type="text" name="author" value="<?= htmlspecialchars($data->author) ?>" required><br><br>

        <label for="joke">Broma:</label><br>
        <textarea name="joke" required><?= htmlspecialchars($data->joke) ?></textarea><br><br>

        <label for="source">Fuente (opcional):</label><br>
        <input type="text" name="source" value="<?= htmlspecialchars($data->source) ?>"><br><br>

        <input type="submit" value="Actualizar Broma">
    </form>
    <br>
    <a href="index.php">← Volver a la lista de bromas</a>
</body>
</html>
