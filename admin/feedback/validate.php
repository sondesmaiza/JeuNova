<?php
require_once '../config.php';
requireAdmin();
$id_user = $_GET['id_user'];
$id_event = $_GET['id_event'];
$pdo->prepare("UPDATE Feedback SET valide = 1 WHERE id_user = ? AND id_event = ?")->execute([$id_user, $id_event]);
header('Location: list.php');
exit;