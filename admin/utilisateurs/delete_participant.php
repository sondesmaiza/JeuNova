<?php
require_once '../includes/header.php';

// Récupération et validation de l'ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die("ID du participant invalide.");
}

// Vérifier que le participant existe bien
$check = $pdo->prepare("SELECT id_user FROM Participant WHERE id_user = ?");
$check->execute([$id]);
if (!$check->fetch()) {
    die("Participant introuvable.");
}

// Suppression en transaction
$pdo->beginTransaction();
try {
    // Supprimer d'abord de la table Participant (clé étrangère)
    $stmt1 = $pdo->prepare("DELETE FROM Participant WHERE id_user = ?");
    $stmt1->execute([$id]);

    // Puis supprimer de la table Utilisateur
    $stmt2 = $pdo->prepare("DELETE FROM Utilisateur WHERE id_user = ?");
    $stmt2->execute([$id]);

    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    // En cas d'erreur (par exemple contrainte d'intégrité), on redirige quand même
    // avec un message d'erreur (optionnel)
}

// Redirection vers la liste des participants
header('Location: participants.php');
exit;