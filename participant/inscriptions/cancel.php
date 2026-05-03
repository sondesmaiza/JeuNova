<?php
require_once '../includes/header.php';
$id_event = $_GET['id'] ?? 0;
$id_user = $_SESSION['user_id'];

$stmt = $pdo->prepare("UPDATE Inscription SET statut = 'annulé' WHERE id_user = ? AND id_event = ?");
$stmt->execute([$id_user, $id_event]);
header('Location: mes_inscriptions.php');
exit;