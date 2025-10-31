<?php
require_once __DIR__.'/../config.php';
require_admin();
$perfs=$pdo->query("SELECT * FROM performers ORDER BY name")->fetchAll();
?>
<!doctype html><html lang="ru"><head><meta charset="utf-8"><title>Исполнители</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>
<nav class="navbar navbar-dark bg-dark mb-4"><div class="container"><a class="navbar-brand" href="/philharmonia/admin/dashboard.php">Админка</a></div></nav>
<div class="container">
  <div class="d-flex justify-content-between mb-3">
    <h1 class="h3">Исполнители</h1>
    <a href="/philharmonia/admin/performer_edit.php" class="btn btn-success btn-sm">+ Добавить</a>
  </div>
  <table class="table table-striped table-bordered">
    <thead><tr><th>ID</th><th>Имя</th><th>Жанр</th><th>Фото</th><th>Действия</th></tr></thead>
    <tbody>
      <?php foreach($perfs as $p): ?>
      <tr>
        <td><?= $p['id'] ?></td>
        <td><?= htmlspecialchars($p['name']) ?></td>
        <td><?= htmlspecialchars($p['genre']) ?></td>
        <td><?= htmlspecialchars($p['photo']) ?></td>
        <td>
          <a href="/philharmonia/admin/performer_edit.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary">✏️</a>
          <a onclick="return confirm('Удалить?')" href="/philharmonia/admin/performer_delete.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger">🗑</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <a href="/philharmonia/admin/dashboard.php" class="btn btn-secondary btn-sm">← Назад</a>
</div>
</body></html>
