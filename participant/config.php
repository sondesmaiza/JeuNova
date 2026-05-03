<?php
session_start();
require_once __DIR__ . '/../config/db.php';

function isParticipant() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'participant';
}

function requireParticipant() {
    if (!isParticipant()) {
        header('Location: /login.php');
        exit;
    }
}

function getParticipantInfo($pdo) {
    $stmt = $pdo->prepare("SELECT u.*, p.niveau, p.centre_interet 
                           FROM Utilisateur u 
                           JOIN Participant p ON u.id_user = p.id_user 
                           WHERE u.id_user = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}
?>