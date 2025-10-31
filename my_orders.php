<?php
$page_title = 'Мои заказы — «Аккорд»';
require_once __DIR__ . '/config.php';
require_login();

$st = $pdo->prepare("SELECT o.*, c.title, c.date, c.time, c.hall
                     FROM orders o
                     JOIN concerts c ON o.concert_id = c.id
                     WHERE o.user_id = ?
                     ORDER BY o.created_at DESC");
$st->execute([current_user_id()]);
$orders = $st->fetchAll();

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<div class="container mb-4">
  <h1 class="mb-3">Мои заказы</h1>
  <?php if ($orders): ?>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Концерт</th>
          <th>Дата/время</th>
          <th>Зал</th>
          <th>Кол-во</th>
          <th>E-mail</th>
          <th>Создан</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $o): ?>
          <tr>
            <td><?= htmlspecialchars($o['title']) ?></td>
            <td><?= date('d.m.Y', strtotime($o['date'])) ?> <?= substr($o['time'],0,5) ?></td>
            <td><?= htmlspecialchars($o['hall']) ?></td>
            <td><?= (int)$o['quantity'] ?></td>
            <td><?= htmlspecialchars($o['email']) ?></td>
            <td><?= $o['created_at'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>У вас пока нет заказов.</p>
  <?php endif; ?>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
