<?php
require_once 'dbConnect.proc.php';
require_once 'ErrorHandler.proc.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['id'])) {
            $stmt = $db->prepare("SELECT p.*, g.gen_nom FROM pellicules p JOIN generes g ON p.gen_id = g.gen_id WHERE p.pel_id = :id");
            $stmt->bindValue(':id', $_GET['id'], SQLITE3_INTEGER);
            $result = $stmt->execute();
            $pellicula = $result->fetchArray(SQLITE3_ASSOC);
            if ($pellicula) {
                echo json_encode($pellicula);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Pel·lícula no trobada"]);
            }
        } else {
            $result = $db->query("SELECT p.*, g.gen_nom FROM pellicules p JOIN generes g ON p.gen_id = g.gen_id");
            $pellicules = [];
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $pellicules[] = $row;
            }
            echo json_encode($pellicules);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);
        if (isset($input['pel_titol'], $input['pel_director'], $input['pel_protagonista'], $input['pel_any'], $input['pel_puntuacio'], $input['pel_conceptes'], $input['gen_id'])) {
            $stmt = $db->prepare("INSERT INTO pellicules (pel_titol, pel_director, pel_protagonista, pel_any, pel_puntuacio, pel_conceptes, gen_id) VALUES (:pel_titol, :pel_director, :pel_protagonista, :pel_any, :pel_puntuacio, :pel_conceptes, :gen_id)");
            $stmt->bindValue(':pel_titol', $input['pel_titol'], SQLITE3_TEXT);
            $stmt->bindValue(':pel_director', $input['pel_director'], SQLITE3_TEXT);
            $stmt->bindValue(':pel_protagonista', $input['pel_protagonista'], SQLITE3_TEXT);
            $stmt->bindValue(':pel_any', $input['pel_any'], SQLITE3_INTEGER);
            $stmt->bindValue(':pel_puntuacio', $input['pel_puntuacio'], SQLITE3_FLOAT);
            $stmt->bindValue(':pel_conceptes', $input['pel_conceptes'], SQLITE3_INTEGER);
            $stmt->bindValue(':gen_id', $input['gen_id'], SQLITE3_INTEGER);
            if ($stmt->execute()) {
                http_response_code(201);
                echo json_encode(["success" => "Pel·lícula creada correctament"]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Database error"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Petició no vàlida"]);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $input = json_decode(file_get_contents('php://input'), true);
        if (isset($_GET['id'], $input['pel_titol'], $input['pel_director'], $input['pel_protagonista'], $input['pel_any'], $input['pel_puntuacio'], $input['pel_conceptes'], $input['gen_id'])) {
            $stmt = $db->prepare("UPDATE pellicules SET pel_titol = :pel_titol, pel_director = :pel_director, pel_protagonista = :pel_protagonista, pel_any = :pel_any, pel_puntuacio = :pel_puntuacio, pel_conceptes = :pel_conceptes, gen_id = :gen_id WHERE pel_id = :pel_id");
            $stmt->bindValue(':pel_id', $_GET['id'], SQLITE3_INTEGER);
            $stmt->bindValue(':pel_titol', $input['pel_titol'], SQLITE3_TEXT);
            $stmt->bindValue(':pel_director', $input['pel_director'], SQLITE3_TEXT);
            $stmt->bindValue(':pel_protagonista', $input['pel_protagonista'], SQLITE3_TEXT);
            $stmt->bindValue(':pel_any', $input['pel_any'], SQLITE3_INTEGER);
            $stmt->bindValue(':pel_puntuacio', $input['pel_puntuacio'], SQLITE3_FLOAT);
            $stmt->bindValue(':pel_conceptes', $input['pel_conceptes'], SQLITE3_INTEGER);
            $stmt->bindValue(':gen_id', $input['gen_id'], SQLITE3_INTEGER);
            if ($stmt->execute()) {
                echo json_encode(["success" => "Pel·lícula actualitzada correctament"]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Database error"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Petició no vàlida"]);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        if (isset($_GET['id'])) {
            $stmt = $db->prepare("DELETE FROM pellicules WHERE pel_id = :pel_id");
            $stmt->bindValue(':pel_id', $_GET['id'], SQLITE3_INTEGER);
            if ($stmt->execute()) {
                echo json_encode(["success" => "Pel·lícula eliminada correctament"]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Database error"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Petició no vàlida"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Petició no acceptada"]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error"]);
}
?>