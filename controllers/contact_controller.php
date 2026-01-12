<?php
session_start();
require_once __DIR__ . "/../models/contact_model.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../views/contact.php");
    exit;
}

if (empty($_SESSION["user_id"])) {
    $_SESSION["contact_error"] = "Debe iniciar sesión para enviar un mensaje.";
    header("Location: ../views/contact.php");
    exit;
}

$nombre  = trim($_POST["nombre"]  ?? "");
$correo  = trim($_POST["email"]   ?? "");
$asunto  = trim($_POST["asunto"]  ?? "");
$mensaje = trim($_POST["mensaje"] ?? "");

if ($nombre === "" || $correo === "" || $mensaje === "" || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["contact_error"] = "Complete campos obligatorios y use un correo válido.";
    header("Location: ../views/contact.php");
    exit;
}

$ok = contact_save($nombre, $correo, $asunto, $mensaje);

if ($ok) {
    $_SESSION["contact_ok"] = "Mensaje enviado.";
} else {
    $_SESSION["contact_error"] = "Error al guardar el mensaje.";
}

header("Location: ../views/contact.php");
exit;
