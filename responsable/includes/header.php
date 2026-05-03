<?php
require_once __DIR__ . '/../config.php';
requireResponsable();
$info = getResponsableInfo($pdo);

$depth = substr_count($_SERVER['SCRIPT_NAME'], '/') - 1;
$root_path = str_repeat('../', max(0, $depth));
if ($root_path === '') $root_path = './';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Responsable - JeuNova</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= $root_path ?>css/responsable-style.css" rel="stylesheet">
    <script src="<?= $root_path ?>js/responsable.js"></script>
    <style>
        .sidebar {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(12px);
            border-right: 1px solid var(--c-border);
        }
        .sidebar a {
            color: var(--amalfi);
            text-decoration: none;
            transition: all 0.2s;
        }
        .sidebar a:hover {
            color: var(--citrus);
            transform: translateX(4px);
        }
        .navbar-top {
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(10px);
            border-radius: var(--r-xl);
            margin-bottom: 1.5rem;
        }
        .responsible-card {
            background: var(--c-card);
            border: 1px solid var(--c-border);
            border-radius: var(--r-xl);
            padding: 1.8rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-card);
            transition: transform 0.3s ease;
        }
        .responsible-card:hover {
            transform: translateY(-4px);
            border-color: var(--c-border2);
        }
        .table {
            background: rgba(255,255,255,0.6);
            border-radius: var(--r-lg);
            overflow: hidden;
        }
        .table th {
            background: var(--amalfi);
            color: white;
            font-weight: 600;
            border: none;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0 sidebar min-vh-100" id="sidebar">
            <div class="p-3">
                <div class="text-center mb-4">
                    <a href="<?= $root_path ?>index.php" class="d-inline-block logo-3d">
                        <img src="<?= $root_path ?>images/logo.jfif" alt="JeuNova" height="45" class="rounded-3 border">
                    </a>
                    <a href="<?= $root_path ?>index.php" class="d-inline-block ms-2 logo-3d">
                        <img src="<?= $root_path ?>images/esen.jfif" alt="ESEN" height="45" class="rounded-3 border">
                    </a>
                </div>
                <div class="nav flex-column">
                    <div class="nav-item"><a href="<?= $root_path ?>index.php" target="_blank"><i class="bi bi-house-door me-2"></i> Voir le site</a></div>
                    <div class="nav-item"><a href="<?= $root_path ?>responsable/index.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></div>
                    <div class="nav-item"><a href="<?= $root_path ?>responsable/profil.php"><i class="bi bi-person-circle me-2"></i> Mon profil</a></div>
                    <hr>
                    <div class="nav-item"><strong>Événements</strong></div>
                    <div class="nav-item"><a href="<?= $root_path ?>responsable/evenements/list.php"><i class="bi bi-calendar-event me-2"></i> Liste</a></div>
                    <div class="nav-item"><a href="<?= $root_path ?>responsable/evenements/add.php"><i class="bi bi-plus-circle me-2"></i> Ajouter</a></div>
                    <hr>
                    <div class="nav-item"><a href="<?= $root_path ?>responsable/inscriptions/list.php"><i class="bi bi-pencil-square me-2"></i> Demandes</a></div>
                    <hr>
                    <div class="nav-item"><a href="<?= $root_path ?>responsable/feedback/list.php"><i class="bi bi-star me-2"></i> Feedbacks</a></div>
                    <div class="nav-item"><a href="<?= $root_path ?>responsable/stats/dashboard.php"><i class="bi bi-graph-up me-2"></i> Statistiques</a></div>
                    <hr>
                    <div class="nav-item"><a href="<?= $root_path ?>responsable/logout.php"><i class="bi bi-box-arrow-right me-2"></i> Déconnexion</a></div>
                    <hr>
                    <div class="nav-item"><strong>Statistiques</strong></div>
                    <div class="nav-item"><a href="<?= $root_path ?>responsable/stats/dashboard.php"><i class="bi bi-graph-up me-2"></i> Vue globale</a></div>
                    <div class="nav-item"><a href="<?= $root_path ?>responsable/stats/events.php"><i class="bi bi-calendar2-week me-2"></i> Par événement</a></div>
                    <div class="nav-item"><a href="<?= $root_path ?>responsable/stats/inscriptions.php"><i class="bi bi-bar-chart-steps me-2"></i> Taux d'inscription</a></div>
                    <hr>
                    <div class="nav-item"><a href="<?= $root_path ?>responsable/logout.php"><i class="bi bi-box-arrow-right me-2"></i> Déconnexion</a></div>
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