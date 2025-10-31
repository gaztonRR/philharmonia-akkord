<?php
require_once __DIR__.'/../config.php';
require_admin();
$stmt=$pdo->query("SELECT c.*,p.name AS performer_name FROM concerts c LEFT JOIN performers p ON c.performer_id=p.id ORDER BY c.date DESC");
$concerts=$stmt->fetchAll();
?>
<!doctype html>
<html lang="ru"><head><meta charset="utf-8"><title>Концерты</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<nav class="navbar navbar-dark bg-dark mb-4"><div class="container"><a class="navbar-brand" href="/philharmonia/admin/dashboard.php">Админка</a></div></nav>
<div class="container">
  <div class="d-flex justify-content-between mb-3">
    <h1 class="h3">Концерты</h1>
    <a href="/philharmonia/admin/concert_edit.php" class="btn btn-primary btn-sm">+ Добавить</a>
  </div>
  <table class="table table-bordered table-striped align-middle">
    <thead><tr><th>ID</th><th>Название</th><th>Дата</th><th>Время</th><th>Исполнитель</th><th>Действия</th></tr></thead>
    <tbody>
      <?php foreach($concerts as $c): ?>
      <tr>
        <td><?= $c['id'] ?></td>
        <td><?= htmlspecialchars($c['title']) ?></td>
        <td><?= date('d.m.Y',strtotime($c['date'])) ?></td>
        <td><?= substr($c['time'],0,5) ?></td>
        <td><?= htmlspecialchars($c['performer_name'] ?? '—') ?></td>
        <td>
          <a class="btn btn-sm btn-outline-primary" href="/philharmonia/admin/concert_edit.php?id=<?= $c['id'] ?>">✏️</a>
          <a class="btn btn-sm btn-outline-danger" onclick="return confirm('Удалить?')" href="/philharmonia/admin/concert_delete.php?id=<?= $c['id'] ?>">🗑</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <a href="/philharmonia/admin/dashboard.php" class="btn btn-secondary btn-sm">← Назад</a>
</div>
</body></html>
