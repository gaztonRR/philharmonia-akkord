<?php
$page_title = 'Афиша — филармония «Аккорд»';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

$stmt = $pdo->query("SELECT c.*, p.name AS performer_name 
                     FROM concerts c
                     LEFT JOIN performers p ON c.performer_id = p.id
                     ORDER BY c.date, c.time");
$concerts = $stmt->fetchAll();
?>
<div class="container mb-4">
  <div class="py-4 text-center">
    <h1 class="fw-bold">Филармония «Аккорд»</h1>
    <p class="text-muted">Афиша ближайших концертов</p>
  </div>
  <div class="row g-4">
    <?php foreach ($concerts as $c): ?>
      <div class="col-md-4">
        <div class="card h-100 card-concert shadow-sm">
          <img src="<?= htmlspecialchars($c['image']) ?>" class="card-img-top" alt="">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?= htmlspecialchars($c['title']) ?></h5>
            <p class="mb-1"><strong><?= date('d.m.Y', strtotime($c['date'])) ?></strong> в <?= substr($c['time'],0,5) ?><br>Зал: <?= htmlspecialchars($c['hall']) ?></p>
            <?php if (!empty($c['performer_name'])): ?>
              <p class="small text-muted mb-1">Исполнитель: <?= htmlspecialchars($c['performer_name']) ?></p>
            <?php endif; ?>
            <p class="flex-grow-1"><?= nl2br(htmlspecialchars(mb_strimwidth($c['description'] ?? '', 0, 110, '...'))) ?></p>
            <p class="fw-bold mb-2">Билеты от <?= (int)$c['price'] ?> ₽</p>
            <?php if (is_logged_in() && current_role() === 'user'): ?>
              <a href="/philharmonia/order.php?concert_id=<?= $c['id'] ?>" class="btn btn-primary">Заказать билет</a>
            <?php else: ?>
              <a href="/philharmonia/login.php?next=/philharmonia/order.php?concert_id=<?= $c['id'] ?>" class="btn btn-outline-primary">Войти, чтобы заказать</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
