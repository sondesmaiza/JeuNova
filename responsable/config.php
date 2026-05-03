<?php
session_start();
require_once __DIR__ . '/../config/db.php';

function isResponsable() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'responsable';
}

function requireResponsable() {
    if (!isResponsable()) {
        header('Location: /login.php');
        exit;
    }
}

function getResponsableInfo($pdo) {
    $stmt = $pdo->prepare("SELECT u.*, r.specialite, r.bio 
                           FROM Utilisateur u 
                           JOIN Responsable r ON u.id_user = r.id_user 
                           WHERE u.id_user = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}
?>