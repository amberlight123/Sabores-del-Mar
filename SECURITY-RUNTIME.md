# Actualización de seguridad de PHP — 21 de octubre de 2026

Aviso oficial (CVE-2026-109618 y CVE-2026-109619):
https://www.php.net/archive/2026.php#2026-10-21-5

Se requiere PHP 8.2.35, 8.3.36, 8.4.27 o 8.5.12, o un parche posterior
de la misma rama. `.php-version` selecciona 8.2.35 para mantener compatibilidad
con XAMPP 8.2. Este archivo por sí solo no instala PHP ni configura XAMPP.
La rama 8.2 termina su soporte el 31 de diciembre de 2026; planificar una
migración probada a una rama con soporte antes de esa fecha.

## Verificación antes de ejecutar o desplegar

1. Actualizar los binarios de PHP desde el proveedor oficial, conservando una
   copia recuperable y la configuración. Para Apache en Windows, usar TS,
   x64 y un compilador compatible; no mezclar extensiones de otra rama.
2. En XAMPP, comprobar `C:\xampp\php\php.exe -v` y ejecutar
   `C:\xampp\php\php.exe scripts/check-php-security.php` desde el proyecto.
3. Ejecutar `C:\xampp\apache\bin\httpd.exe -t` y reiniciar todos los
   procesos Apache/PHP tras sustituir los binarios. Verificar también la
   versión de PHP del servidor web; la CLI puede usar otra instalación.
4. Probar inicio de sesión, base de datos, formularios y carrito en el entorno
   local antes de publicar. La CI comprueba versión y sintaxis, sin conectarse
   a la base de datos ni ejecutar operaciones de la aplicación.

El comprobador es una barrera previa al despliegue, no una mitigación de una
petición que ya entró al motor vulnerable. No se debe sustituir el parche por
`ini_set()` ni por cambios dentro de la aplicación. Las distribuciones que
mantienen parches retroportados requieren verificar el paquete con su proveedor;
este comprobador conservador solo acepta versiones oficiales reconocidas.

No hay dependencias Composer declaradas en este repositorio. Esta corrección
del motor no equivale a una auditoría de todo el código o del resto de XAMPP.
