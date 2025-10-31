<?php
require_once __DIR__ . '/../config.php';
require_admin();

$id = (int)($_GET['id'] ?? 0);
$st = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$st->execute([$id]);
$order = $st->fetch();
if (!$order) {
    die('Заказ не найден');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $qty = (int)($_POST['quantity'] ?? 1);
    if ($qty < 1) $qty = 1;
    $upd = $pdo->prepare("UPDATE orders SET email = ?, quantity = ? WHERE id = ?");
    $upd->execute([$email, $qty, $id]);
    header('Location: /philharmonia/admin/orders_list.php');
    exit;
}

$page_title = 'Редактирование заказа';
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($page_title) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark mb-4"><div class="container"><a class="navbar-brand" href="/philharmonia/admin/dashboard.php">Админка</a></div></nav>
<div class="container">
  <h1 class="mb-3">Редактирование заказа #<?= $order['id'] ?></h1>
  <form method="post">
    <div class="mb-3">
      <label class="form-label">E-mail</label>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($order['email']) ?>">
    </div>
    <div class="mb-3" style="max-width:200px;">
      <label class="form-label">Кол-во билетов</label>
      <input type="number" name="quantity" min="1" value="<?= (int)$order['quantity'] ?>" class="form-control">
    </div>
    <button class="btn btn-success">Сохранить</button>
    <a href="/philharmonia/admin/orders_list.php" class="btn btn-secondary">Отмена</a>
  </form>
</div>
</body>
</html>
