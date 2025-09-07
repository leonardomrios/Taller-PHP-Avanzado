<?php /** @var string $appName */ ?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($appName) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="/"><?= htmlspecialchars($appName) ?></a>
    <div>
      <a class="btn btn-sm btn-outline-light me-2" href="/">Inicio</a>
    </div>
  </div>
</nav>
<main class="container">
  <div class="card shadow-sm">
    <div class="card-body">
      <?php require __DIR__ . '/' . ($view ?? 'home') . '.php'; ?>
    </div>
  </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>