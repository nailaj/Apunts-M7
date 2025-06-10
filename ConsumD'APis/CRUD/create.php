<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $url = "https://api101.up.railway.app/joke";

    $data = array(
        'author' => 'ITB-NITIN',
        'jokes' => $_POST['joke'],
        'source' => $_POST['source']
    );
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Contect-Type'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);


    if(curl_errno($ch)){
        echo "error el hacer solicitud" . curl_errno($ch);
    }
    else{
        $json_response = json_decode($response, true);
        echo "your joke has be added in the database" . $json_response['id'];
        echo "<br><a href='index.php'><-volver al inicio</a>";
    }

    crul_close($ch);
    exit;
}

?>
<h2>Crear nueva broma</h2>
<form method="POST">
    <label>Broma:</label><br>
    <textarea name="joke" required></textarea><br><br>

    <label>Fuente (opcional):</label><br>
    <input type="text" name="source"><br><br>

    <button type="submit">Guardar</button>
</form>
<a href="index.php">⬅ Volver</a>
