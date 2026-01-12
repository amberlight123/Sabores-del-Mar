<?php
require_once __DIR__ . "/../config/db.php";

function user_find_by_email(string $email): ?array {
    global $mysqli;

    $stmt = $mysqli->prepare("SELECT id, nombre, email, password_hash, rol FROM usuarios WHERE email = ?");
    if (!$stmt) {
        return null;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
    $stmt->close();

    return $user ?: null;
}

function user_create(string $nombre, string $email, string $pass_plain): array {
    global $mysqli;

    $existe = user_find_by_email($email);
    if ($existe) {
        return ["ok" => false, "msg" => "El correo ya está registrado."];
    }

    $hash = password_hash($pass_plain, PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("INSERT INTO usuarios (nombre, email, password_hash, rol) VALUES (?, ?, ?, 'cliente')");
    if (!$stmt) {
        return ["ok" => false, "msg" => "Error al preparar inserción."];
    }

    $stmt->bind_param("sss", $nombre, $email, $hash);
    $ok = $stmt->execute();
    $stmt->close();

    if (!$ok) {
        return ["ok" => false, "msg" => "Error al guardar usuario."];
    }

    return ["ok" => true, "msg" => "Usuario creado."];
}
