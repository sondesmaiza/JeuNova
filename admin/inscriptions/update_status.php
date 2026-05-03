<?php
require_once '../config.php';
requireAdmin();
$id_user = $_GET['id_user'];
$id_event = $_GET['id_event'];
$status = $_GET['status'];
$pdo->prepare("UPDATE Inscription SET statut = ? WHERE id_user = ? AND id_event = ?")->execute([$status, $id_user, $id_event]);
header('Location: list.php');
exit;