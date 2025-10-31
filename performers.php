<?php
$page_title='Исполнители — филармония';
require_once __DIR__.'/config.php';
require_once __DIR__.'/includes/header.php';
require_once __DIR__.'/includes/navbar.php';
$stmt=$pdo->query("SELECT * FROM performers ORDER BY name");
$performers=$stmt->fetchAll();
?>
<div class="container mb-4">
  <h1 class="mb-4">Исполнители</h1>
  <div class="row g-4">
    <?php foreach($performers as $p): ?>
    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <img src="<?= htmlspecialchars($p['photo']) ?>" class="card-img-top" style="height:200px;object-fit:cover" alt="">
        <div class="card-body d-flex flex-column">
          <h5><?= htmlspecialchars($p['name']) ?></h5>
          <p class="text-muted mb-1"><?= htmlspecialchars($p['genre']) ?></p>
          <p class="flex-grow-1"><?= nl2br(htmlspecialchars(mb_strimwidth($p['bio']??'',0,140,'...'))) ?></p>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>
<?php require_once __DIR__.'/includes/footer.php'; ?>
