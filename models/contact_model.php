<?php
require_once __DIR__ . "/../config/db.php";

function contact_save(string $nombre, string $email, string $asunto, string $mensaje): bool {
    global $mysqli;

    $stmt = $mysqli->prepare("CALL sp_insert_contacto(?, ?, ?, ?)");
    if (!$stmt) {
        return false;
    }

    $stmt->bind_param("ssss", $nombre, $email, $asunto, $mensaje);
    $ok = $stmt->execute();
    $stmt->close();

    while ($mysqli->more_results() && $mysqli->next_result()) {}

    return $ok;
}
