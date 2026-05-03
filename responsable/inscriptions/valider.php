<?php
require_once '../includes/header.php';
$id_responsable = $_SESSION['user_id'];
$id_user = $_GET['id_user'];
$id_event = $_GET['id_event'];

// Vérifier que l'événement appartient bien au responsable
$check = $pdo->prepare("SELECT id_event FROM Evenement WHERE id_event = ? AND id_responsable = ?");
$check->execute([$id_event, $id_responsable]);
if ($check->fetch()) {
    $stmt = $pdo->prepare("UPDATE Inscription SET statut = 'confirmé' WHERE id_user = ? AND id_event = ?");
    $stmt->execute([$id_user, $id_event]);
}
header('Location: list.php');
exit;