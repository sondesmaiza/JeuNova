<?php
require_once '../includes/header.php';
$id_responsable = $_SESSION['user_id'];
$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM Evenement WHERE id_event = ? AND id_responsable = ?");
$stmt->execute([$id, $id_responsable]);
header('Location: list.php');
exit;