<?php
session_start();

$cart = $_SESSION["cart"] ?? [];

$total = 0;
foreach ($cart as $item) {
    $total += $item["product"]["precio"] * $item["cantidad"];
}

$mensaje_pago = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["accion_pago"]) && $_POST["accion_pago"] === "pagar") {
    if (empty($_SESSION["user_id"])) {
        $mensaje_pago = "Debe iniciar sesión para realizar el pago.";
    } elseif (!empty($cart) && $total > 0) {
        require_once __DIR__ . "/../config/db.php";

        $usuarioId = (int)$_SESSION["user_id"];

        $stmtPedido = $mysqli->prepare("INSERT INTO pedidos (usuario_id, total, estado) VALUES (?, ?, 'pagado')");
        if ($stmtPedido) {
            $stmtPedido->bind_param("id", $usuarioId, $total);
            $stmtPedido->execute();
            $pedidoId = $mysqli->insert_id;
            $stmtPedido->close();

            if ($pedidoId > 0) {
                foreach ($cart as $item) {
                    $stmtItem = $mysqli->prepare("INSERT INTO pedido_items (pedido_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
                    if ($stmtItem) {
                        $productoId     = (int)$item["product"]["id"];
                        $cantidad       = (int)$item["cantidad"];
                        $precioUnitario = (float)$item["product"]["precio"];
                        $stmtItem->bind_param("iiid", $pedidoId, $productoId, $cantidad, $precioUnitario);
                        $stmtItem->execute();
                        $stmtItem->close();
                    }
                }
                $_SESSION["cart"] = [];
                $cart = [];
                $total = 0;
                $mensaje_pago = "Pago registrado. Código de pedido #" . $pedidoId . ".";
            } else {
                $mensaje_pago = "Hubo un problema al registrar el pedido.";
            }
        } else {
            $mensaje_pago = "No se pudo registrar el pago en la base de datos.";
        }
    } else {
        $mensaje_pago = "No hay productos en el carrito.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Carrito | Sabores del Mar</title>
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
      <a class="nav-link" href="contact.php">Contacto</a>
      <a class="nav-link active" href="cart.php">Carrito</a>
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
        <p class="section-kicker">Carrito</p>
        <h1 class="section-title">Tu pedido actual</h1>
        <p class="section-subtitle">
          Todos tus pedidos se mostrarán en este carrito.
        </p>
      </div>

      <div class="table-shell">
        <table class="cart-table">
          <thead>
            <tr>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Precio</th>
              <th>Subtotal</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
          <?php if (empty($cart)): ?>
            <tr>
              <td colspan="5">No hay productos en el carrito.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($cart as $id => $item):
              $sub = $item["product"]["precio"] * $item["cantidad"]; ?>
              <tr>
                <td><?php echo htmlspecialchars($item["product"]["nombre"]); ?></td>
                <td>
                  <a href="../controllers/cart_controller.php?accion=restar&id=<?php echo $id; ?>">-</a>
                  <?php echo $item["cantidad"]; ?>
                  <a href="../controllers/cart_controller.php?accion=sumar&id=<?php echo $id; ?>">+</a>
                </td>
                <td>B/. <?php echo number_format($item["product"]["precio"], 2); ?></td>
                <td>B/. <?php echo number_format($sub, 2); ?></td>
                <td>
                  <a href="../controllers/cart_controller.php?accion=eliminar&id=<?php echo $id; ?>">
                    Quitar
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="cart-total">
        <span>Total:</span>
        <span>B/. <?php echo number_format($total, 2); ?></span>
        <a class="btn btn-outline" href="../controllers/cart_controller.php?accion=vaciar">
          Vaciar carrito
        </a>
      </div>
    </section>

    <section class="section">
      <div style="max-width:480px;margin:0 auto;">
        <?php if ($mensaje_pago !== ""): ?>
          <div style="margin-bottom:0.75rem;font-size:0.9rem;color:#bbf7d0;background:rgba(22,163,74,0.18);border-radius:0.9rem;padding:0.6rem 0.8rem;">
            <?php echo htmlspecialchars($mensaje_pago); ?>
          </div>
        <?php endif; ?>

        <?php if (empty($_SESSION["user_id"])): ?>
          <div class="form-card">
            <h2 class="section-title" style="font-size:1.25rem;margin-bottom:0.5rem;">Pago</h2>
            <p class="section-subtitle" style="margin-bottom:1rem;">
              Debe iniciar sesión o registrarse para acceder a las opciones de pago.
            </p>
            <div class="btn-row">
              <a class="btn btn-primary" href="login.html">Iniciar sesión</a>
              <a class="btn btn-outline" href="register.html">Registrarse</a>
            </div>
          </div>
        <?php else: ?>
          <div class="form-card">
            <h2 class="section-title" style="font-size:1.25rem;margin-bottom:0.5rem;">Pago</h2>
            <p class="section-subtitle" style="margin-bottom:1rem;">
              Selecciona un método de pago para completar tu pedido.
            </p>

            <form method="post" action="cart.php">
              <input type="hidden" name="accion_pago" value="pagar">

              <div class="form-row" style="margin-bottom:1rem;">
                <label class="label">Método de pago</label>

                <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.9rem;margin-top:0.35rem;">
                  <input type="radio" name="metodo" value="tarjeta" checked>
                  Tarjeta de crédito o débito
                </label>

                <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.9rem;margin-top:0.35rem;">
                  <input type="radio" name="metodo" value="paypal">
                  PayPal
                </label>

                <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.9rem;margin-top:0.35rem;">
                  <input type="radio" name="metodo" value="transferencia">
                  Transferencia bancaria
                </label>

                <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.9rem;margin-top:0.35rem;">
                  <input type="radio" name="metodo" value="local">
                  Pago en restaurante
                </label>
              </div>

              <div class="form-row" style="margin-bottom:1rem;">
                <div>
                  <label class="label" for="nombre_pago">Nombre</label>
                  <input class="input" type="text" id="nombre_pago" name="nombre_pago" value="<?php echo htmlspecialchars($_SESSION["user_name"] ?? ""); ?>">
                </div>
              </div>

              <div class="form-row" style="margin-bottom:1rem;">
                <div>
                  <label class="label">Monto a pagar</label>
                  <p style="font-size:0.95rem;color:#e5e7eb;margin-top:0.25rem;">
                    B/. <?php echo number_format($total, 2); ?>
                  </p>
                </div>
              </div>

              <button type="submit" class="btn btn-primary" style="width:100%;margin-top:0.5rem;">
                Confirmar pago
              </button>
            </form>
          </div>
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
