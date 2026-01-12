<?php
session_start();
require_once __DIR__ . "/../models/user_model.php";

$action = $_GET["action"] ?? "";

if ($action === "login") {
    auth_login();
} elseif ($action === "register") {
    auth_register();
} elseif ($action === "logout") {
    auth_logout();
} else {
    header("Location: ../index.php");
    exit;
}

function auth_login(): void {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: ../views/login.html");
        exit;
    }

    $email = trim($_POST["email"] ?? "");
    $pass  = trim($_POST["password"] ?? "");

    if ($email === "" || $pass === "") {
        $_SESSION["login_error"] = "Ingrese correo y contraseña.";
        header("Location: ../views/login.html");
        exit;
    }

    $user = user_find_by_email($email);

    if (!$user || !password_verify($pass, $user["password_hash"])) {
        $_SESSION["login_error"] = "Credenciales inválidas.";
        header("Location: ../views/login.html");
        exit;
    }

    $_SESSION["user_id"]    = $user["id"];
    $_SESSION["user_name"]  = $user["nombre"];
    $_SESSION["user_email"] = $user["email"];
    $_SESSION["user_role"]  = $user["rol"];

    setcookie("nombre_visitante", $user["nombre"], time() + 7 * 24 * 60 * 60, "/");

    header("Location: ../index.php");
    exit;
}

function auth_register(): void {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: ../views/register.html");
        exit;
    }

    $nombre = trim($_POST["nombre"] ?? "");
    $email  = trim($_POST["email"] ?? "");
    $pass   = trim($_POST["password"] ?? "");
    $pass2  = trim($_POST["password2"] ?? "");

    if ($nombre === "" || $email === "" || $pass === "" || $pass2 === "") {
        $_SESSION["register_error"] = "Todos los campos son obligatorios.";
        header("Location: ../views/register.html");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["register_error"] = "Correo no válido.";
        header("Location: ../views/register.html");
        exit;
    }

    if ($pass !== $pass2) {
        $_SESSION["register_error"] = "Las contraseñas no coinciden.";
        header("Location: ../views/register.html");
        exit;
    }

    $res = user_create($nombre, $email, $pass);

    if (!$res["ok"]) {
        $_SESSION["register_error"] = $res["msg"];
        header("Location: ../views/register.html");
        exit;
    }

    $_SESSION["register_ok"] = "Usuario creado. Inicie sesión.";
    header("Location: ../views/login.html");
    exit;
}

function auth_logout(): void {
    session_unset();
    session_destroy();
    setcookie("nombre_visitante", "", time() - 3600, "/");
    header("Location: ../index.php");
    exit;
}
