<?php
session_start();
$nombre = $_SESSION["user_name"]  ?? "";
$email  = $_SESSION["user_email"] ?? "";
$contact_error = $_SESSION["contact_error"] ?? "";
$contact_ok    = $_SESSION["contact_ok"] ?? "";
unset($_SESSION["contact_error"], $_SESSION["contact_ok"]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Contacto | Sabores del Mar</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="page">
<header class="navbar">
  <div class="nav-inner">
    <a class="brand" href="../index.php">
      <img src="https://i.ibb.co/4wyVHKgC/logo-design-for-a-seafood-restaura nt-cal-XYj-F-a-Cm-Sb-WXLZBTb90f-PQ-DURWMUv7-Qty39u-LFM-rrbg.jpg" alt="Sabores del Mar">
      <span>SABORES DEL MAR</span>
    </a>
    <nav class="nav-links">
      <a class="nav-link" href="../index.php">Inicio</a>
      <a class="nav-link" href="products.php">Menú</a>
      <a class="nav-link active" href="contact.php">Contacto</a>
      <a class="nav-link" href="cart.php">Carrito</a>
      <?php if (!empty($_SESSION["user_id"])): ?>
        <span class="nav-link">Hola, <?php echo htmlspecialchars($_SESSION["user_name"]); ?></span>
        <a class="nav-link" href="../controllers/auth_controller.php?action=logout">Salir</a>
      <?php else: ?>
        <a class="nav-link" href="login.html">Iniciar sesión</a>
      <?php endif; ?>
    </nav>
  </div>
</header>

  <main class="main">
    <section class="section">
      <div class="section-header">
        <p class="section-kicker">Contacto</p>
        <h1 class="section-title">Hablemos sobre tu visita</h1>
        <p class="section-subtitle">
         ¡Cualquier comentario con gusto lo leeremos!
      </div>

      <div class="form-shell" style="max-width:640px;margin:0 auto;">
        <?php if ($contact_error): ?>
          <div style="margin-bottom:0.75rem;font-size:0.9rem;color:#fecaca;background:rgba(220,38,38,0.18);border-radius:0.9rem;padding:0.6rem 0.8rem;">
            <?php echo htmlspecialchars($contact_error); ?>
          </div>
        <?php endif; ?>
        <?php if ($contact_ok): ?>
          <div style="margin-bottom:0.75rem;font-size:0.9rem;color:#bbf7d0;background:rgba(22,163,74,0.18);border-radius:0.9rem;padding:0.6rem 0.8rem;">
            <?php echo htmlspecialchars($contact_ok); ?>
          </div>
        <?php endif; ?>

        <?php if (empty($_SESSION["user_id"])): ?>
          <div class="form-card">
            <p class="section-subtitle" style="margin-bottom:1rem;">
              Debe iniciar sesión o registrarse para enviar un mensaje de contacto.
            </p>
            <div class="btn-row">
              <a class="btn btn-primary" href="login.html">Iniciar sesión</a>
              <a class="btn btn-outline" href="register.html">Registrarse</a>
            </div>
          </div>
        <?php else: ?>
          <form class="form-card" method="POST" action="../controllers/contact_controller.php">
            <div class="form-row form-row--2">
              <div>
                <label class="label" for="nombre">Nombre</label>
                <input class="input" type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($nombre); ?>">
              </div>
              <div>
                <label class="label" for="email">Correo</label>
                <input class="input" type="email" id="email" name="email" required value="<?php echo htmlspecialchars($email); ?>">
              </div>
            </div>

            <div class="form-row" style="margin-top:1rem;">
              <div>
                <label class="label" for="asunto">Asunto</label>
                <input class="input" type="text" id="asunto" name="asunto" placeholder="Reserva, evento, consulta...">
              </div>
            </div>

            <div class="form-row" style="margin-top:1rem;">
              <div>
                <label class="label" for="mensaje">Mensaje</label>
                <textarea class="textarea" id="mensaje" name="mensaje" required></textarea>
              </div>
            </div>

            <div style="margin-top:1.4rem;display:flex;justify-content:flex-end;">
              <button class="btn btn-primary" type="submit">
                Enviar mensaje
              </button>
            </div>
          </form>
        <?php endif; ?>
      </div>
    </section>
  </main>

  <footer class="footer">
    <span>Sabores del Mar</span>
  </footer>
</div>
</body>
</html>
