<?php
require_once __DIR__.'/../config.php';
require_admin();
$id=(int)($_GET['id'] ?? 0);
if($id){
  $pdo->prepare("UPDATE concerts SET performer_id=NULL WHERE performer_id=?")->execute([$id]);
  $pdo->prepare("DELETE FROM performers WHERE id=?")->execute([$id]);
}
header('Location: /philharmonia/admin/performers_list.php');
exit;
