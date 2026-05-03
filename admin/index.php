<?php
require_once 'includes/header.php';

$totalEvents = $pdo->query("SELECT COUNT(*) FROM Evenement")->fetchColumn();
$totalParticipants = $pdo->query("SELECT COUNT(DISTINCT id_user) FROM Inscription WHERE statut='confirmé'")->fetchColumn();
$totalFeedbacks = $pdo->query("SELECT COUNT(*) FROM Feedback")->fetchColumn();
$totalMessages = $pdo->query("SELECT COUNT(*) FROM Contact")->fetchColumn();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Tableau de bord</h2>
    <a href="export_pdf.php" class="btn btn-submit btn-sm" target="_blank">
        <i class="bi bi-file-pdf-fill me-1"></i> Exporter en PDF
    </a>
</div>

<div class="admin-card">
    <div class="row g-4">
        <div class="col-md-3">
            <div class="stat-card text-center p-3">
                <i class="bi bi-calendar-event fs-1"></i>
                <div class="stat-number"><?= $totalEvents ?></div>
                <p>Événements</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center p-3">
                <i class="bi bi-people fs-1"></i>
                <div class="stat-number"><?= $totalParticipants ?></div>
                <p>Participants</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center p-3">
                <i class="bi bi-star fs-1"></i>
                <div class="stat-number"><?= $totalFeedbacks ?></div>
                <p>Feedbacks</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center p-3">
                <i class="bi bi-envelope fs-1"></i>
                <div class="stat-number"><?= $totalMessages ?></div>
                <p>Messages</p>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>