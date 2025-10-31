<?php
$page_title='Регистрация — филармония';
require_once __DIR__.'/config.php';
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $username=trim($_POST['username']??'');
  $password=trim($_POST['password']??'');
  $password2=trim($_POST['password2']??'');
  if($username===''||$password===''||$password2===''){
    $error='Заполните все поля';
  } elseif($password!==$password2){
    $error='Пароли не совпадают';
  } else {
    $st=$pdo->prepare("SELECT id FROM users WHERE username=?"); $st->execute([$username]);
    if($st->fetch()){
      $error='Такой логин уже есть';
    } else {
      $ins=$pdo->prepare("INSERT INTO users (username,password,role) VALUES (?,?, 'user')");
      $ins->execute([$username, md5($password)]);
      $_SESSION['user']=$username; $_SESSION['role']='user'; $_SESSION['user_id']=$pdo->lastInsertId();
      header('Location: /philharmonia/index.php'); exit;
    }
  }
}
require_once __DIR__.'/includes/header.php';
require_once __DIR__.'/includes/navbar.php';
?>
<div class="container">
  <div class="row justify-content-center mt-5 mb-4">
    <div class="col-md-5">
      <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="mb-3 text-center">Регистрация</h3>
          <?php if($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
          <form method="post">
            <div class="mb-3"><label class="form-label">Логин</label><input name="username" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Пароль</label><input type="password" name="password" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Повторите пароль</label><input type="password" name="password2" class="form-control" required></div>
            <button class="btn btn-success w-100">Создать аккаунт</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once __DIR__.'/includes/footer.php'; ?>
