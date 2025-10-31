<?php
require_once __DIR__ . '/../config.php';
require_admin();
$orders = $pdo->query("SELECT o.*, u.username, c.title
                       FROM orders o
                       JOIN users u ON o.user_id = u.id
                       JOIN concerts c ON o.concert_id = c.id
                       ORDER BY o.created_at DESC")->fetchAll();
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Заказы — админка</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="/philharmonia/admin/dashboard.php">Админка</a>
  </div>
</nav>
<div class="container">
  <h1 class="mb-3">Заказы</h1>
  <table class="table table-striped table-bordered align-middle">
    <thead>
      <tr>
        <th>ID</th>
        <th>Пользователь</th>
        <th>Концерт</th>
        <th>E-mail</th>
        <th>Кол-во</th>
        <th>Создан</th>
        <th>Действия</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($orders as $o): ?>
        <tr>
          <td><?= $o['id'] ?></td>
          <td><?= htmlspecialchars($o['username']) ?></td>
          <td><?= htmlspecialchars($o['title']) ?></td>
          <td><?= htmlspecialchars($o['email']) ?></td>
          <td><?= (int)$o['quantity'] ?></td>
          <td><?= $o['created_at'] ?></td>
          <td>
            <a href="/philharmonia/admin/order_edit.php?id=<?= $o['id'] ?>" class="btn btn-sm btn-outline-primary">✏️</a>
            <a href="/philharmonia/admin/order_delete.php?id=<?= $o['id'] ?>" onclick="return confirm('Удалить заказ?')" class="btn btn-sm btn-outline-danger">🗑</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <a href="/philharmonia/admin/dashboard.php" class="btn btn-secondary btn-sm">← Назад</a>
</div>
</body>
</html>
