<?php
session_start();
$added = isset($_GET["added"]);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Menú | Sabores del Mar</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header class="navbar">
  <div class="nav-inner">
    <a class="brand" href="../index.php">
      <img src="https://i.ibb.co/4wyVHKgC/logo-design-for-a-seafood-restaura nt-cal-XYj-F-a-Cm-Sb-WXLZBTb90f-PQ-DURWMUv7-Qty39u-LFM-rrbg.jpg" alt="Sabores del Mar">
      <span>SABORES DEL MAR</span>
    </a>
    <nav class="nav-links">
      <a class="nav-link" href="../index.php">Inicio</a>
      <a class="nav-link active" href="products.php">Menú</a>
      <a class="nav-link" href="contact.php">Contacto</a>
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
        <p class="section-kicker">Carta</p>
        <h1 class="section-title">Sabores del Pacífico y Caribe</h1>
        <p class="section-subtitle">
          Descubre los sabores auténticos del mar en cada plato, preparados con los ingredientes más frescos y las mejores técnicas culinarias.
        </p>
      </div>

<?php if ($added): ?>
  <div class="form-card" style="max-width:480px;margin:0 auto 1.5rem;">
    <p class="section-subtitle" style="margin-bottom:0.75rem;">
      Producto agregado al carrito.
    </p>
    <div class="btn-row" style="justify-content:flex-end;">
      <a class="btn btn-outline" href="products.php">Seguir comprando</a>
      <a class="btn btn-primary" href="cart.php">Ir al carrito</a>
    </div>
  </div>
<?php endif; ?>

      <div class="grid-3">
        <article class="card">
          <div class="card-tag">Entrada</div>
          <h2 class="card-title">Ceviche de corvina</h2>
          <p class="card-desc">
            Corvina fresca marinada en limón, culantro y cebolla morada, servida con patacones crujientes.
          </p>
          <div class="card-meta">
            <span class="card-price">B/. 8.50</span>
            <a class="btn btn-primary" href="../controllers/cart_controller.php?accion=agregar&id=1">
              Agregar
            </a>
          </div>
        </article>

        <article class="card">
          <div class="card-tag">Plato fuerte</div>
          <h2 class="card-title">Pulpo a la parrilla</h2>
          <p class="card-desc">
            Pulpo marinado, sellado a la parrilla sobre puré rústico de papas y vegetales salteados.
          </p>
          <div class="card-meta">
            <span class="card-price">B/. 15.00</span>
            <a class="btn btn-primary" href="../controllers/cart_controller.php?accion=agregar&id=2">
              Agregar
            </a>
          </div>
        </article>

        <article class="card">
          <div class="card-tag">Plato fuerte</div>
          <h2 class="card-title">Filete de pescado al ajillo</h2>
          <p class="card-desc">
            Filete del día en salsa de ajo y perejil, acompañado de arroz con coco y ensalada fresca.
          </p>
          <div class="card-meta">
            <span class="card-price">B/. 12.00</span>
            <a class="btn btn-primary" href="../controllers/cart_controller.php?accion=agregar&id=3">
              Agregar
            </a>
          </div>
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
