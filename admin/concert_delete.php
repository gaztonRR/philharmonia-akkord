<?php
require_once __DIR__.'/../config.php';
require_admin();
$id=(int)($_GET['id'] ?? 0);
if($id){
  $pdo->prepare("DELETE FROM concerts WHERE id=?")->execute([$id]);
}
header('Location: /philharmonia/admin/concerts_list.php');
exit;
