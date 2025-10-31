<?php
$page_title = 'Админка — «Аккорд»';
require_once __DIR__ . '/../config.php';
require_admin();
$concerts_count = $pdo->query("SELECT COUNT(*) c FROM concerts")->fetch()['c'];
$performers_count = $pdo->query("SELECT COUNT(*) c FROM performers")->fetch()['c'];
$orders_count = $pdo->query("SELECT COUNT(*) c FROM orders")->fetch()['c'];
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($page_title) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="/philharmonia/admin/dashboard.php">Админка «Аккорд»</a>
    <div>
      <a href="/philharmonia/index.php" class="btn btn-sm btn-outline-light me-2">На сайт</a>
      <a href="/philharmonia/admin/logout.php" class="btn btn-sm btn-warning">Выход</a>
    </div>
  </div>
</nav>
<div class="container">
  <h1 class="mb-4">Панель администратора</h1>
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card border-primary"><div class="card-body">
        <h5>Концерты</h5>
        <p class="display-6"><?= $concerts_count ?></p>
        <a href="/philharmonia/admin/concerts_list.php" class="btn btn-sm btn-primary">Управлять</a>
      </div></div>
    </div>
    <div class="col-md-4">
      <div class="card border-success"><div class="card-body">
        <h5>Исполнители</h5>
        <p class="display-6"><?= $performers_count ?></p>
        <a href="/philharmonia/admin/performers_list.php" class="btn btn-sm btn-success">Управлять</a>
      </div></div>
    </div>
    <div class="col-md-4">
      <div class="card border-warning"><div class="card-body">
        <h5>Заказы</h5>
        <p class="display-6"><?= $orders_count ?></p>
        <a href="/philharmonia/admin/orders_list.php" class="btn btn-sm btn-warning">Смотреть</a>
      </div></div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
