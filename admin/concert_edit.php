<?php
require_once __DIR__.'/../config.php';
require_admin();
$id=$_GET['id'] ?? null;
$editing=false;
$concert=[ 'title'=>'','date'=>date('Y-m-d'),'time'=>'19:00','hall'=>'Большой зал','price'=>0,'performer_id'=>null,'description'=>'','image'=>'assets/img/placeholder.jpg' ];
$perfs=$pdo->query("SELECT id,name FROM performers ORDER BY name")->fetchAll();
if($id){
  $st=$pdo->prepare("SELECT * FROM concerts WHERE id=?"); $st->execute([$id]);
  if($row=$st->fetch()){ $concert=$row; $editing=true; }
}
if($_SERVER['REQUEST_METHOD']==='POST'){
  $title=trim($_POST['title']); $date=$_POST['date']; $time=$_POST['time']; $hall=trim($_POST['hall']);
  $price=(float)$_POST['price']; $performer_id=$_POST['performer_id']!==''?(int)$_POST['performer_id']:null;
  $description=trim($_POST['description']); $image=trim($_POST['image']) ?: 'assets/img/placeholder.jpg';
  if($editing){
    $upd=$pdo->prepare("UPDATE concerts SET title=?,date=?,time=?,hall=?,price=?,performer_id=?,description=?,image=? WHERE id=?");
    $upd->execute([$title,$date,$time,$hall,$price,$performer_id,$description,$image,$id]);
  } else {
    $ins=$pdo->prepare("INSERT INTO concerts (title,date,time,hall,price,performer_id,description,image) VALUES (?,?,?,?,?,?,?,?)");
    $ins->execute([$title,$date,$time,$hall,$price,$performer_id,$description,$image]);
  }
  header('Location: /philharmonia/admin/concerts_list.php'); exit;
}
?>
<!doctype html><html lang="ru"><head><meta charset="utf-8"><title><?= $editing?'Редактирование':'Новый' ?> концерта</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>
<nav class="navbar navbar-dark bg-dark mb-4"><div class="container"><a class="navbar-brand" href="/philharmonia/admin/dashboard.php">Админка</a></div></nav>
<div class="container">
  <h1 class="mb-3"><?= $editing?'Редактирование концерта':'Новый концерт' ?></h1>
  <form method="post">
    <div class="row">
      <div class="col-md-8 mb-3">
        <label class="form-label">Название</label>
        <input name="title" class="form-control" required value="<?= htmlspecialchars($concert['title']) ?>">
      </div>
      <div class="col-md-4 mb-3">
        <label class="form-label">Дата</label>
        <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($concert['date']) ?>">
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 mb-3">
        <label class="form-label">Время</label>
        <input type="time" name="time" class="form-control" value="<?= substr($concert['time'],0,5) ?>">
      </div>
      <div class="col-md-4 mb-3">
        <label class="form-label">Цена, ₽</label>
        <input type="number" name="price" class="form-control" value="<?= htmlspecialchars($concert['price']) ?>">
      </div>
      <div class="col-md-4 mb-3">
        <label class="form-label">Зал</label>
        <input name="hall" class="form-control" value="<?= htmlspecialchars($concert['hall']) ?>">
      </div>
    </div>
    <div class="mb-3">
      <label class="form-label">Исполнитель</label>
      <select name="performer_id" class="form-select">
        <option value="">— не выбрано —</option>
        <?php foreach($perfs as $p): ?>
          <option value="<?= $p['id'] ?>" <?= $concert['performer_id']==$p['id']?'selected':'' ?>><?= htmlspecialchars($p['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Описание</label>
      <textarea name="description" rows="5" class="form-control"><?= htmlspecialchars($concert['description']) ?></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Путь к изображению</label>
      <input name="image" class="form-control" value="<?= htmlspecialchars($concert['image']) ?>">
      <div class="form-text">По умолчанию: assets/img/placeholder.jpg</div>
    </div>
    <button class="btn btn-success">Сохранить</button>
    <a href="/philharmonia/admin/concerts_list.php" class="btn btn-secondary">Отмена</a>
  </form>
</div>
</body></html>
