<?php
require_once 'includes/header.php';
$id_user = $_SESSION['user_id'];

// Nombre d'inscriptions confirmées
$stmt = $pdo->prepare("SELECT COUNT(*) FROM Inscription WHERE id_user = ? AND statut = 'confirmé'");
$stmt->execute([$id_user]);
$totalInscrits = $stmt->fetchColumn();

// Nombre de feedbacks donnés
$stmt = $pdo->prepare("SELECT COUNT(*) FROM Feedback WHERE id_user = ?");
$stmt->execute([$id_user]);
$totalFeedbacks = $stmt->fetchColumn();

// Dernier événement consulté ou au hasard
$stmt = $pdo->prepare("SELECT e.titre FROM Evenement e ORDER BY e.date_debut DESC LIMIT 1");
$stmt->execute();
$lastEvent = $stmt->fetchColumn();
?>
<div class="responsible-card">
    <h2>Tableau de bord</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="stat-card text-center p-3">
                <i class="bi bi-check-circle-fill fs-1"></i>
                <div class="stat-number"><?= $totalInscrits ?></div>
                <p>Inscriptions confirmées</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card text-center p-3">
                <i class="bi bi-star-fill fs-1"></i>
                <div class="stat-number"><?= $totalFeedbacks ?></div>
                <p>Feedbacks donnés</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card text-center p-3">
                <i class="bi bi-calendar-week fs-1"></i>
                <div class="stat-number"><?= $lastEvent ? '✓' : '—' ?></div>
                <p>Dernier événement</p>
                <small><?= htmlspecialchars($lastEvent ?? 'Aucun') ?></small>
            </div>
        </div>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>