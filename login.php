<?php
$page_title='Вход — филармония';
require_once __DIR__.'/config.php';
$error='';
$next=$_GET['next'] ?? '/philharmonia/index.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $username=trim($_POST['username']??'');
  $password=trim($_POST['password']??'');
  $next=$_POST['next'] ?? '/philharmonia/index.php';
  if($username!=='' && $password!==''){
    $st=$pdo->prepare("SELECT * FROM users WHERE username=?");
    $st->execute([$username]);
    $u=$st->fetch();
    if($u && $u['password']===md5($password)){
      $_SESSION['user']=$u['username'];
      $_SESSION['role']=$u['role'];
      $_SESSION['user_id']=$u['id'];
      header('Location: '.$next); exit;
    } else $error='Неверный логин или пароль';
  } else $error='Введите логин и пароль';
}
require_once __DIR__.'/includes/header.php';
require_once __DIR__.'/includes/navbar.php';
?>
<div class="container">
  <div class="row justify-content-center mt-5 mb-4">
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="mb-3 text-center">Вход</h3>
          <?php if($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
          <form method="post">
            <input type="hidden" name="next" value="<?= htmlspecialchars($next) ?>">
            <div class="mb-3"><label class="form-label">Логин</label><input name="username" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Пароль</label><input type="password" name="password" class="form-control" required></div>
            <button class="btn btn-primary w-100">Войти</button>
          </form>
          <p class="text-muted small mt-3 mb-0">Нет аккаунта? <a href="/philharmonia/register.php">Регистрация</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once __DIR__.'/includes/footer.php'; ?>
