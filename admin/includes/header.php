<?php
require_once __DIR__ . '/../config.php';
requireAdmin();
$adminInfo = getAdminInfo($pdo);

$base_url = '';
if (preg_match('#^/jeunova#i', $_SERVER['SCRIPT_NAME'], $matches)) {
    $base_url = $matches[0];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Admin JeuNova</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= $base_url ?>/css/admin-style.css" rel="stylesheet">
    <style>
        /* SURCHARGE RESPONSIVE (force la sidebar mobile) */
        @media (max-width: 768px) {
            body {
                overflow-x: hidden;
            }
            .sidebar {
                position: fixed !important;
                left: -280px !important;
                top: 0 !important;
                bottom: 0 !important;
                width: 280px !important;
                z-index: 1050 !important;
                background: white !important;
                transition: left 0.3s ease !important;
                overflow-y: auto !important;
            }
            .sidebar.show {
                left: 0 !important;
            }
            .flex-grow-1 {
                width: 100% !important;
                margin-left: 0 !important;
            }
            #sidebarToggle {
                display: inline-block !important;
            }
        }
        @media (min-width: 769px) {
            #sidebarToggle {
                display: none !important;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid px-0">
    <div class="d-flex flex-nowrap">
        <!-- Sidebar -->
        <div class="sidebar flex-shrink-0" id="sidebar">
            <div class="p-3">
                <div class="text-center mb-4">
                    <a href="<?= $base_url ?>/index.php" class="d-inline-block logo-3d">
                        <img src="<?= $base_url ?>/images/logo.jfif" alt="JeuNova" height="45" class="rounded-3 border">
                    </a>
                    <a href="<?= $base_url ?>/index.php" class="d-inline-block ms-2 logo-3d">
                        <img src="<?= $base_url ?>/images/esen.jfif" alt="ESEN" height="45" class="rounded-3 border">
                    </a>
                </div>
                <div class="nav flex-column">
                    <div class="nav-item"><a href="<?= $base_url ?>/index.php" target="_blank"><i class="bi bi-house-door me-2"></i> Voir le site</a></div>
                    <div class="nav-item"><a href="<?= $base_url ?>/admin/index.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></div>
                    <div class="nav-item"><a href="<?= $base_url ?>/admin/profil.php"><i class="bi bi-person-circle me-2"></i> Mon profil</a></div>
                    <hr>
                    <div class="nav-item"><strong>Utilisateurs</strong></div>
                    <div class="nav-item"><a href="<?= $base_url ?>/admin/utilisateurs/admins.php"><i class="bi bi-shield-lock me-2"></i> Admins</a></div>
                    <div class="nav-item"><a href="<?= $base_url ?>/admin/utilisateurs/responsables.php"><i class="bi bi-briefcase me-2"></i> Responsables</a></div>
                    <div class="nav-item"><a href="<?= $base_url ?>/admin/utilisateurs/participants.php"><i class="bi bi-people me-2"></i> Participants</a></div>
                    <hr>
                    <div class="nav-item"><strong>Événements</strong></div>
                    <div class="nav-item"><a href="<?= $base_url ?>/admin/evenements/list.php"><i class="bi bi-calendar-event me-2"></i> Liste</a></div>
                    <div class="nav-item"><a href="<?= $base_url ?>/admin/evenements/add.php"><i class="bi bi-plus-circle me-2"></i> Ajouter</a></div>
                    <hr>
                    <div class="nav-item"><a href="<?= $base_url ?>/admin/inscriptions/list.php"><i class="bi bi-pencil-square me-2"></i> Inscriptions</a></div>
                    <div class="nav-item"><a href="<?= $base_url ?>/admin/inscriptions/by_event.php"><i class="bi bi-bar-chart me-2"></i> Par événement</a></div>
                    <hr>
                    <div class="nav-item"><a href="<?= $base_url ?>/admin/feedback/list.php"><i class="bi bi-star me-2"></i> Feedbacks</a></div>
                    <div class="nav-item"><a href="<?= $base_url ?>/admin/messages/list.php"><i class="bi bi-envelope me-2"></i> Messages</a></div>
                    <div class="nav-item"><a href="<?= $base_url ?>/admin/stats/dashboard.php"><i class="bi bi-graph-up me-2"></i> Statistiques</a></div>
                    <hr>
                    <div class="nav-item"><a href="<?= $base_url ?>/admin/logout.php"><i class="bi bi-box-arrow-right me-2"></i> Déconnexion</a></div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-grow-1 px-0" style="min-width: 0;">
            <div class="navbar-top p-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-outline-secondary d-md-none" id="sidebarToggle"><i class="bi bi-list"></i> Menu</button>
                <div class="fw-semibold text-dark">
                    <i class="bi bi-person-circle me-1"></i> <?= htmlspecialchars($adminInfo['prenom'] . ' ' . $adminInfo['nom']) ?>
                </div>
            </div>
            <div class="container-fluid p-3">