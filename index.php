<?php
session_start();
$nombre_visitante = $_COOKIE["nombre_visitante"] ?? "";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inicio | Sabores del Mar</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="page">
<header class="navbar">
  <div class="nav-inner">
    <a class="brand" href="index.php">
      <img src="https://i.ibb.co/4wyVHKgC/logo-design-for-a-seafood-restaura nt-cal-XYj-F-a-Cm-Sb-WXLZBTb90f-PQ-DURWMUv7-Qty39u-LFM-rrbg.jpg" alt="Sabores del Mar">
      <span>SABORES DEL MAR</span>
    </a>
    <nav class="nav-links">
      <a class="nav-link active" href="index.php">Inicio</a>
      <a class="nav-link" href="views/products.php">Menú</a>
      <a class="nav-link" href="views/contact.php">Contacto</a>
      <a class="nav-link" href="views/cart.php">Carrito</a>

      <?php if (!empty($_SESSION["user_id"])): ?>
        <span class="nav-link">Hola, <?php echo htmlspecialchars($_SESSION["user_name"]); ?></span>
        <a class="nav-link" href="controllers/auth_controller.php?action=logout">Salir</a>
      <?php else: ?>
        <a class="nav-link" href="views/login.html">Iniciar sesión</a>
      <?php endif; ?>
    </nav>
  </div>
</header>



  <main class="main">
    <section class="hero section">
      <div class="hero-text">
        <p class="hero-kicker">Restaurante de mariscos</p>
        <h1 class="hero-title">
          Sabores del <span>Mar</span>
        </h1>
        <p>
          <?php if ($nombre_visitante): ?>
            Bienvenido de nuevo, <?php echo htmlspecialchars($nombre_visitante); ?>. Disfruta nuestra carta basada en mariscos frescos del Pacífico y Caribe.
          <?php else: ?>
            Bienvenido a nuestro restaurante de mariscos. Explora la carta, arma tu pedido en el carrito y realiza tus reservas en línea.
          <?php endif; ?>
        </p>

        <div class="hero-actions btn-row">
          <a class="btn btn-primary" href="views/products.php">Ver menú</a>
          <a class="btn btn-outline" href="views/contact.php">Reservar / Contacto</a>
        </div>
      </div>

      <div class="hero-figure"></div>
    </section>

    <section class="section">
      <div class="section-header">
        <p class="section-kicker">Creada en 1995</p>
        <h2 class="section-title">La tradición marinera en cada plato</h2>
        <p class="section-subtitle">
          La mejor experiencia gastronómica de mariscos en la ciudad
        </p>
      </div>

      <div class="grid-3">
        <article class="card">
          <div class="card-tag">Ubicación</div>
          <p class="card-desc">
            Av. Costera 123. Ciudad Marítima, Panamá
        </article>

        <article class="card">
          <div class="card-tag">Horarios</div>
          <p class="card-desc">
           Lun - Vie: 12:00 - 22:00, Sáb - Dom: 11:00 - 23:00
          </p>
        </article>

        <article class="card">
          <div class="card-tag">Número de Contacto</div>
          <p class="card-desc">
            +507 6000-0000
          </p>
        </article>
      </div>
    </section>
  </main>

  <footer class="footer">
    <span>© Sabores del Mar</span>
    <span>Panamá · Cocina del mar</span>
  </footer>
</div>
</body>
</html>
