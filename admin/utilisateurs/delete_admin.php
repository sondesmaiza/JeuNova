<?php
require_once '../includes/header.php';
$id = $_GET['id'];
$pdo->beginTransaction();
try {
    $pdo->prepare("DELETE FROM Admin WHERE id_user = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM Utilisateur WHERE id_user = ?")->execute([$id]);
    $pdo->commit();
} catch(Exception $e) { $pdo->rollBack(); }
header('Location: admins.php');
exit;