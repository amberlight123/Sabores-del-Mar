<?php
// Ejecutar desde CLI antes de desplegar; no exponer versiones por HTTP.
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

$minimumVersions = [802 => 80235, 803 => 80336, 804 => 80427, 805 => 80512];
$branch = intdiv(PHP_VERSION_ID, 100);
if (!isset($minimumVersions[$branch]) || PHP_VERSION_ID < $minimumVersions[$branch]) {
    fwrite(STDERR, "PHP sin validar: actualice a 8.2.35, 8.3.36, 8.4.27 o 8.5.12 (o parches posteriores de esas ramas).\n");
    exit(1);
}

fwrite(STDOUT, "PHP " . PHP_VERSION . " cumple los mínimos del aviso del 21-10-2026.\n");
