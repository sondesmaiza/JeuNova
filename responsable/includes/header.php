<?php
require_once __DIR__ . '/../config.php';
requireResponsable();
$info = getResponsableInfo($pdo);

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
    <title>Espace Responsable - JeuNova</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= $base_url ?>/css/responsable-style.css" rel="stylesheet">
    <style>
        /* RESPONSIVE SIDEBAR (FORCÉ) */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -280px;
                top: 0;
                bottom: 0;
                width: 280px;
                background: white;
                z-index: 1050;
                transition: left 0.3s ease;
                overflow-y: auto;
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
                padding-top: 20px;
            }
            .sidebar.show {
                left: 0;
            }
            .navbar-top .btn-outline-secondary {
                display: inline-block !important;
                background: #2E5AA7;
                color: white;
                border: none;
                padding: 6px 12px;
                border-radius: 20px;
            }
            .flex-grow-1 {
                width: 100%;
            }
        }
        @media (min-width: 769px) {
            .navbar-top .btn-outline-secondary {
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
                    <div class="nav-item"><a href="<?= $base_url ?>/responsable/index.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></div>
                    <div class="nav-item"><a href="<?= $base_url ?>/responsable/profil.php"><i class="bi bi-person-circle me-2"></i> Mon profil</a></div>
                    <hr>
                    <div class="nav-item"><strong>Événements</strong></div>
                    <div class="nav-item"><a href="<?= $base_url ?>/responsable/evenements/list.php"><i class="bi bi-calendar-event me-2"></i> Liste</a></div>
                    <div class="nav-item"><a href="<?= $base_url ?>/responsable/evenements/add.php"><i class="bi bi-plus-circle me-2"></i> Ajouter</a></div>
                    <hr>
                    <div class="nav-item"><a href="<?= $base_url ?>/responsable/inscriptions/list.php"><i class="bi bi-pencil-square me-2"></i> Demandes</a></div>
                    <hr>
                    <div class="nav-item"><strong>Feedbacks</strong></div>
                    <div class="nav-item"><a href="<?= $base_url ?>/responsable/feedback/list.php"><i class="bi bi-star me-2"></i> Feedbacks reçus</a></div>
                    <hr>
                    <div class="nav-item"><strong>Statistiques</strong></div>
                    <div class="nav-item"><a href="<?= $base_url ?>/responsable/stats/dashboard.php"><i class="bi bi-graph-up me-2"></i> Vue globale</a></div>
                    <div class="nav-item"><a href="<?= $base_url ?>/responsable/stats/events.php"><i class="bi bi-calendar2-week me-2"></i> Par événement</a></div>
                    <div class="nav-item"><a href="<?= $base_url ?>/responsable/stats/inscriptions.php"><i class="bi bi-bar-chart-steps me-2"></i> Taux d'inscription</a></div>
                    <div class="nav-item"><a href="<?= $base_url ?>/responsable/stats/feedback.php"><i class="bi bi-star-half me-2"></i> Notes moyennes</a></div>
                    <hr>
                    <div class="nav-item"><a href="<?= $base_url ?>/responsable/logout.php"><i class="bi bi-box-arrow-right me-2"></i> Déconnexion</a></div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-grow-1 px-0" style="min-width: 0;">
            <div class="navbar-top p-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-outline-secondary" id="sidebarToggle"><i class="bi bi-list"></i> Menu</button>
                <div class="fw-semibold text-dark">
                    <i class="bi bi-person-circle me-1"></i> <?= htmlspecialchars($info['prenom'] . ' ' . $info['nom']) ?>
                </div>
            </div>
            <div class="container-fluid p-3">