<?php
require_once 'dbConnect.proc.php';
require_once 'ErrorHandler.proc.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $result = $db->query("SELECT * FROM generes");
        $generes = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $generes[] = $row;
        }
        echo json_encode($generes);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Petició no acceptada"]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error"]);
}
?>