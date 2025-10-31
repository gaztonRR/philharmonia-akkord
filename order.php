<?php
require_once __DIR__ . '/config.php';
require_login();

$concert_id = (int)($_GET['concert_id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM concerts WHERE id = ?");
$stmt->execute([$concert_id]);
$concert = $stmt->fetch();
if (!$concert) {
    die('Концерт не найден');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qty = (int)($_POST['qty'] ?? 1);
    if ($qty < 1) $qty = 1;
    $email = trim($_POST['email'] ?? '');
    if ($email === '') {
        $error = 'Укажите e-mail, куда отправлять билеты';
    } else {
        $ins = $pdo->prepare("INSERT INTO orders (user_id, concert_id, quantity, email, created_at) VALUES (?,?,?,?,NOW())");
        $ins->execute([current_user_id(), $concert_id, $qty, $email]);
        header('Location: /philharmonia/my_orders.php');
        exit;
    }
}

$page_title = 'Заказ билета — «Аккорд»';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<div class="container mb-4">
  <h1 class="mb-3">Заказ билета</h1>
  <div class="card">
    <div class="card-body">
      <h5><?= htmlspecialchars($concert['title']) ?></h5>
      <p class="mb-1"><?= date('d.m.Y', strtotime($concert['date'])) ?> в <?= substr($concert['time'],0,5) ?>, зал: <?= htmlspecialchars($concert['hall']) ?></p>
      <p>Цена от: <strong><?= (int)$concert['price'] ?> ₽</strong></p>
      <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
      <form method="post">
        <div class="row">
          <div class="col-md-3 mb-3">
            <label class="form-label">Кол-во билетов</label>
            <input type="number" name="qty" min="1" value="1" class="form-control">
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">E-mail для отправки билетов</label>
            <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
            <div class="form-text">мы не шлём спам, только билеты</div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Подтвердить заказ</button>
        <a href="/philharmonia/index.php" class="btn btn-secondary">Отмена</a>
      </form>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
