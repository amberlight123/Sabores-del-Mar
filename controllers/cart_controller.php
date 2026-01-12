<?php
session_start();
require_once __DIR__ . "/../models/product_model.php";

$accion  = $_GET["accion"] ?? "";
$id      = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}
$cart =& $_SESSION["cart"];

if ($accion === "agregar" || $accion === "sumar") {
    if ($id > 0) {
        if (!isset($cart[$id])) {
            $p = product_find($id);
            if ($p) {
                $cart[$id] = [
                    "product"  => $p,
                    "cantidad" => 1
                ];
            }
        } else {
            $cart[$id]["cantidad"]++;
        }
    }
} elseif ($accion === "restar") {
    if ($id > 0 && isset($cart[$id])) {
        if ($cart[$id]["cantidad"] > 1) {
            $cart[$id]["cantidad"]--;
        } else {
            unset($cart[$id]);
        }
    }
} elseif ($accion === "eliminar") {
    if ($id > 0 && isset($cart[$id])) {
        unset($cart[$id]);
    }
} elseif ($accion === "vaciar") {
    $cart = [];
}

if ($accion === "agregar") {
    header("Location: ../views/products.php?added=1");
} else {
    header("Location: ../views/cart.php");
}
exit;
