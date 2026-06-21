<?php
/**
 * Calculadora ROI (Retorno de Inversión)
 * Calcula el ROI y el periodo de recuperación.
 */
header('Content-Type: text/html; charset=utf-8');

$roi = null; $ganancia = null; $periodo = null;
$inversion = $ingresos = $costos = $tiempo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inversion = (float)($_POST['inversion'] ?? 0);
    $ingresos  = (float)($_POST['ingresos'] ?? 0);
    $costos    = (float)($_POST['costos'] ?? 0);
    $tiempo    = (float)($_POST['tiempo'] ?? 12);

    if ($inversion > 0) {
        $gananciaNeta = $ingresos - $costos - $inversion;
        $ganancia = $gananciaNeta;
        $roi = $inversion > 0 ? round(($gananciaNeta / $inversion) * 100, 2) : 0;
        $flujoAnual = $ingresos - $costos;
        $periodo = $flujoAnual > 0 ? round($inversion / ($flujoAnual / $tiempo), 1) : null;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Calculadora ROI Retorno de Inversión Online | ConfiguroWeb</title>
<meta name="description" content="Calcula el ROI (Retorno de Inversión) de tus proyectos. Descubre cuánto ganas y en cuánto tiempo recuperas la inversión. Gratis en ConfiguroWeb.">
<meta name="keywords" content="calculadora roi, retorno de inversion, roi calculator, rentabilidad, periodo recuperacion">
<meta property="og:type" content="website">
<meta property="og:title" content="Calculadora ROI Retorno de Inversión Online">
<meta property="og:description" content="Calcula el ROI y el periodo de recuperación de tus proyectos.">
<link rel="canonical" href="https://demoscweb.com/github/php-calculadora-roi/">
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"WebApplication","name":"Calculadora ROI","applicationCategory":"FinanceApplication","operatingSystem":"Any","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"},"author":{"@type":"Person","name":"ConfiguroWeb","url":"https://configuroweb.com"}}
</script>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header>
  <h1>📈 Calculadora ROI (Retorno de Inversión)</h1>
  <p class="subtitle">Descubre la rentabilidad de tus proyectos.</p>
</header>
<main>
  <form method="POST">
    <label for="inversion">Inversión inicial ($)</label>
    <input type="number" name="inversion" id="inversion" step="0.01" value="<?php echo htmlspecialchars($inversion); ?>" placeholder="10000" required>

    <label for="ingresos">Ingresos generados ($)</label>
    <input type="number" name="ingresos" id="ingresos" step="0.01" value="<?php echo htmlspecialchars($ingresos); ?>" placeholder="18000">

    <label for="costos">Costos operativos ($)</label>
    <input type="number" name="costos" id="costos" step="0.01" value="<?php echo htmlspecialchars($costos); ?>" placeholder="3000">

    <label for="tiempo">Periodo (meses)</label>
    <input type="number" name="tiempo" id="tiempo" step="1" value="<?php echo htmlspecialchars($tiempo ?: 12); ?>" placeholder="12">

    <button type="submit" class="btn-primary">📊 Calcular ROI</button>
  </form>

  <?php if ($roi !== null): ?>
  <div class="resultados">
    <h2>Resultados</h2>
    <div class="tarjeta <?php echo $roi >= 0 ? 'positivo' : 'negativo'; ?>">
      <span class="etiqueta">ROI</span>
      <span class="valor"><?php echo $roi; ?>%</span>
    </div>
    <div class="grid-2">
      <div class="tarjeta-sm">
        <span class="etiqueta">Ganancia Neta</span>
        <span class="valor-sm <?php echo $ganancia >= 0 ? 'pos' : 'neg'; ?>">$<?php echo number_format($ganancia, 2); ?></span>
      </div>
      <?php if ($periodo !== null): ?>
      <div class="tarjeta-sm">
        <span class="etiqueta">Recuperación</span>
        <span class="valor-sm"><?php echo $periodo; ?> meses</span>
      </div>
      <?php endif; ?>
    </div>
    <p class="interpretacion">
      <?php if ($roi > 0): ?>
        ✅ Tu inversión es <strong>rentable</strong>. Por cada $1 invertido ganas <strong>$<?php echo number_format($ganancia/$inversion, 2); ?></strong>.
      <?php elseif ($roi === 0): ?>
        ➖ Estás en <strong>punto de equilibrio</strong>. No hay ganancia ni pérdida.
      <?php else: ?>
        ❌ Tu inversión tiene <strong>pérdidas</strong>. Revisa tu modelo de negocio.
      <?php endif; ?>
    </p>
  </div>
  <?php endif; ?>

  <section class="info">
    <h2>¿Cómo se calcula el ROI?</h2>
    <p>La fórmula del ROI es:</p>
    <p class="formula">ROI = (Ganancia Neta / Inversión) × 100</p>
    <p>Donde <strong>Ganancia Neta = Ingresos - Costos - Inversión</strong>.</p>
  </section>
</main>
<footer>
  <p>Desarrollado por <a href="https://configuroweb.com" target="_blank">ConfiguroWeb</a> ·
     <a href="https://appscweb.com/citas/" target="_blank">Sistema de Citas</a> ·
     <a href="https://appscweb.com/negocios/" target="_blank">Gestión de Negocios</a></p>
  <p>&copy; <?php echo date('Y'); ?> ConfiguroWeb</p>
</footer>
<script src="assets/script.js"></script>
</body>
</html>