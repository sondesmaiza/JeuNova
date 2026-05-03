<?php
require_once '../includes/header.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("DELETE FROM evenement WHERE id_event = ?");
$stmt->execute([$id]);
header('Location: list.php');
exit;