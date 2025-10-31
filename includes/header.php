<?php
if (!isset($page_title)) {
    $page_title = 'Филармония «Аккорд»';
}
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/philharmonia/assets/css/style.css">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
