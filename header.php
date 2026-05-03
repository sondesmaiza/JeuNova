<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>JeuNova - Événements & Formations</title>
    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style4.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top glass-nav">
        <div class="container-fluid px-4">
            <!-- Logos à gauche -->
            <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
                <img src="images/logo.jfif" alt="JeuNova" height="45" class="rounded-3 shadow-sm">
                <img src="images/esen.jfif" alt="ESEN" height="45" class="rounded">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <!-- Liens de navigation -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-3">
                    <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#objectifs">Objectifs</a></li>
                    <li class="nav-item"><a class="nav-link" href="#statistiques">Statistiques</a></li>
                    <li class="nav-item"><a class="nav-link" href="#equipe">Équipe</a></li>
                    <li class="nav-item"><a class="nav-link" href="#evenements">Événements</a></li>
                    <li class="nav-item"><a class="nav-link" href="#temoignages">Témoignages</a></li>
                </ul>
                <!-- Boutons Contact et Connexion -->
                <div class="d-flex gap-2 ms-3">
                    <a class="btn btn-nav" href="contact.php">Contact <i class="bi bi-envelope-fill"></i></a>
                    <a class="btn btn-nav" href="login.php">Connexion <i class="bi bi-box-arrow-in-right"></i></a>
                </div>
                <!-- Barre de recherche (avec ancrage #evenements) -->
                <form method="get" action="index.php#evenements" class="d-flex ms-3" role="search">
                    <input class="form-control rounded-pill" type="search" name="search" 
                           placeholder="Rechercher un événement..." 
                           value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" 
                           style="width: 220px; padding-left: 15px;">
                    <button class="btn btn-nav ms-1" type="submit"><i class="bi bi-search"></i></button>
                </form>
            </div>
        </div>
    </nav>
    <main class="pt-5 mt-4">