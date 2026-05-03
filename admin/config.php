<?php
session_start();
require_once __DIR__ . '/../config/db.php';

function isAdmin() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function requireAdmin() {
    if (!isAdmin()) {
        header('Location: /login.php');
        exit;
    }
}

function getAdminInfo($pdo) {
    $stmt = $pdo->prepare("SELECT u.* FROM Utilisateur u JOIN Admin a ON u.id_user = a.id_user WHERE u.id_user = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}
?>