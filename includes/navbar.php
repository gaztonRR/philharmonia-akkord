<?php require_once __DIR__ . '/../config.php'; ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-gradient-phil shadow-sm mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/philharmonia/index.php">🎻 Аккорд</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navPhil"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="navPhil">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="/philharmonia/index.php">Афиша</a></li>
        <li class="nav-item"><a class="nav-link" href="/philharmonia/performers.php">Исполнители</a></li>
        <?php if (is_logged_in() && current_role() === 'user'): ?>
          <li class="nav-item"><a class="nav-link" href="/philharmonia/my_orders.php">Мои заказы</a></li>
        <?php endif; ?>
      </ul>
      <ul class="navbar-nav ms-auto">
        <?php if (is_logged_in()): ?>
          <?php if (current_role() === 'admin'): ?>
            <li class="nav-item"><a class="nav-link" href="/philharmonia/admin/dashboard.php">Админка</a></li>
          <?php endif; ?>
          <li class="nav-item"><span class="navbar-text me-2">Привет, <?= htmlspecialchars(current_user()) ?></span></li>
          <li class="nav-item"><a class="btn btn-sm btn-outline-light" href="/philharmonia/admin/logout.php">Выход</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="btn btn-sm btn-outline-light me-2" href="/philharmonia/login.php">Вход</a></li>
          <li class="nav-item"><a class="btn btn-sm btn-warning" href="/philharmonia/register.php">Регистрация</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
