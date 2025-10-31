<?php
require_once __DIR__.'/../config.php';
require_admin();
$id=$_GET['id'] ?? null;
$editing=false;
$perf=['name'=>'','genre'=>'','bio'=>'','photo'=>'assets/img/placeholder.jpg'];
if($id){
  $st=$pdo->prepare("SELECT * FROM performers WHERE id=?"); $st->execute([$id]);
  if($row=$st->fetch()){ $perf=$row; $editing=true; }
}
if($_SERVER['REQUEST_METHOD']==='POST'){
  $name=trim($_POST['name']); $genre=trim($_POST['genre']); $bio=trim($_POST['bio']); $photo=trim($_POST['photo']) ?: 'assets/img/placeholder.jpg';
  if($editing){
    $upd=$pdo->prepare("UPDATE performers SET name=?,genre=?,bio=?,photo=? WHERE id=?");
    $upd->execute([$name,$genre,$bio,$photo,$id]);
  } else {
    $ins=$pdo->prepare("INSERT INTO performers (name,genre,bio,photo) VALUES (?,?,?,?)");
    $ins->execute([$name,$genre,$bio,$photo]);
  }
  header('Location: /philharmonia/admin/performers_list.php'); exit;
}
?>
<!doctype html><html lang="ru"><head><meta charset="utf-8"><title><?= $editing?'Редактирование':'Новый' ?> исполнителя</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>
<nav class="navbar navbar-dark bg-dark mb-4"><div class="container"><a class="navbar-brand" href="/philharmonia/admin/dashboard.php">Админка</a></div></nav>
<div class="container">
  <h1 class="mb-3"><?= $editing?'Редактирование исполнителя':'Новый исполнитель' ?></h1>
  <form method="post">
    <div class="mb-3"><label class="form-label">Имя / коллектив</label><input name="name" class="form-control" required value="<?= htmlspecialchars($perf['name']) ?>"></div>
    <div class="mb-3"><label class="form-label">Жанр</label><input name="genre" class="form-control" value="<?= htmlspecialchars($perf['genre']) ?>"></div>
    <div class="mb-3"><label class="form-label">Описание / биография</label><textarea name="bio" rows="5" class="form-control"><?= htmlspecialchars($perf['bio']) ?></textarea></div>
    <div class="mb-3"><label class="form-label">Путь к фото</label><input name="photo" class="form-control" value="<?= htmlspecialchars($perf['photo']) ?>"><div class="form-text">Напр.: assets/img/placeholder.jpg</div></div>
    <button class="btn btn-success">Сохранить</button>
    <a href="/philharmonia/admin/performers_list.php" class="btn btn-secondary">Отмена</a>
  </form>
</div>
</body></html>
