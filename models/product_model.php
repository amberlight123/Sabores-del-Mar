<?php
require_once __DIR__ . "/../config/db.php";

function product_all_active(): array {
    global $mysqli;

    $sql = "SELECT id, nombre, descripcion, precio, imagen, categoria 
            FROM productos 
            WHERE activo = 1";
    $res = $mysqli->query($sql);

    $items = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $items[] = $row;
        }
    }
    return $items;
}

function product_find(int $id): ?array {
    global $mysqli;

    $stmt = $mysqli->prepare(
        "SELECT id, nombre, descripcion, precio, imagen, categoria 
         FROM productos 
         WHERE id = ? AND activo = 1"
    );
    if (!$stmt) {
        return null;
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $p = $res->fetch_assoc();
    $stmt->close();

    return $p ?: null;
}
