<?php
require_once __DIR__ . '/../config.php';
requireParticipant();
$info = getParticipantInfo($pdo);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Participant - JeuNova</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="/jeunova/css/style.css" rel="stylesheet">
    <link href="/jeunova/css/responsable-style.css" rel="stylesheet"> <!-- ou partici... -->
    <script src="/jeunova/js/responsable.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0 sidebar" id="sidebar">
            <div class="p-3">
                <div class="text-center mb-4">
                    <a href="/jeunova/index.php" class="logo-3d">
                        <img src="/jeunova/images/logo.jfif" alt="JeuNova" height="45" class="rounded-3 border">
                    </a>
                    <a href="/jeunova/index.php" class="logo-3d ms-2">
                        <img src="/jeunova/images/esen.jfif" alt="ESEN" height="45" class="rounded-3 border">
                    </a>
                </div>
                <div class="nav flex-column">
                    <div class="nav-item"><a href="/jeunova/index.php" target="_blank"><i class="bi bi-house-door me-2"></i> Voir le site</a></div>
                    <div class="nav-item"><a href="/jeunova/participant/index.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></div>
                    <div class="nav-item"><a href="/jeunova/participant/profil.php"><i class="bi bi-person-circle me-2"></i> Mon profil</a></div>
                    <hr>
                    <div class="nav-item"><strong>Événements</strong></div>
                    <div class="nav-item"><a href="/jeunova/participant/evenements/list.php"><i class="bi bi-calendar-event me-2"></i> Tous les événements</a></div>
                    <div class="nav-item"><a href="/jeunova/participant/recommendations/suggestions.php"><i class="bi bi-lightbulb me-2"></i> Recommandations</a></div>
                    <hr>
                    <div class="nav-item"><a href="/jeunova/participant/inscriptions/mes_inscriptions.php"><i class="bi bi-pencil-square me-2"></i> Mes inscriptions</a></div>
                    <hr>
                    <div class="nav-item"><a href="/jeunova/participant/feedback/mes_feedbacks.php"><i class="bi bi-star me-2"></i> Mes feedbacks</a></div>
                    <div class="nav-item"><a href="/jeunova/participant/feedback/add.php"><i class="bi bi-plus-circle me-2"></i> Donner un avis</a></div>
                    <hr>
                    <div class="nav-item"><a href="/jeunova/participant/logout.php"><i class="bi bi-box-arrow-right me-2"></i> Déconnexion</a></div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="col-md-9 col-lg-10 ms-sm-auto px-0">
            <div class="navbar-top p-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-outline-secondary d-md-none" id="sidebarToggle"><i class="bi bi-list"></i> Menu</button>
                <div class="fw-semibold text-dark">
                    <i class="bi bi-person-circle me-1"></i> <?= htmlspecialchars($info['prenom'] . ' ' . $info['nom']) ?>
                </div>
            </div>
            <div class="container-fluid p-3">