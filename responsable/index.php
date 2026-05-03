<?php
require_once 'includes/header.php';

$id_responsable = $_SESSION['user_id'];

// Nombre total d'événements créés par ce responsable
$stmt = $pdo->prepare("SELECT COUNT(*) FROM Evenement WHERE id_responsable = ?");
$stmt->execute([$id_responsable]);
$totalEvents = $stmt->fetchColumn();

// Nombre total d'inscriptions aux événements de ce responsable (tous statuts)
$stmt = $pdo->prepare("SELECT COUNT(*) 
                       FROM Inscription i 
                       JOIN Evenement e ON i.id_event = e.id_event 
                       WHERE e.id_responsable = ?");
$stmt->execute([$id_responsable]);
$totalInscriptions = $stmt->fetchColumn();

// Nombre de feedbacks reçus pour ses événements
$stmt = $pdo->prepare("SELECT COUNT(*) 
                       FROM Feedback f 
                       JOIN Evenement e ON f.id_event = e.id_event 
                       WHERE e.id_responsable = ?");
$stmt->execute([$id_responsable]);
$totalFeedbacks = $stmt->fetchColumn();

// Note moyenne
$stmt = $pdo->prepare("SELECT AVG(f.note) 
                       FROM Feedback f 
                       JOIN Evenement e ON f.id_event = e.id_event 
                       WHERE e.id_responsable = ?");
$stmt->execute([$id_responsable]);
$avgNote = $stmt->fetchColumn();
$avgNote = $avgNote ? round($avgNote, 1) : 0;
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Tableau de bord</h2>
    <a href="export_pdf.php" class="btn btn-submit btn-sm" target="_blank">
        <i class="bi bi-file-pdf-fill me-1"></i> Exporter en PDF
    </a>
</div>

<div class="responsible-card">
    <div class="row g-4">
        <div class="col-md-3">
            <div class="stat-card text-center p-3">
                <i class="bi bi-calendar-event fs-1"></i>
                <div class="stat-number"><?= $totalEvents ?></div>
                <p>Mes événements</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center p-3">
                <i class="bi bi-people fs-1"></i>
                <div class="stat-number"><?= $totalInscriptions ?></div>
                <p>Inscriptions totales</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center p-3">
                <i class="bi bi-star fs-1"></i>
                <div class="stat-number"><?= $totalFeedbacks ?></div>
                <p>Feedbacks reçus</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center p-3">
                <i class="bi bi-graph-up fs-1"></i>
                <div class="stat-number"><?= $avgNote ?> / 5</div>
                <p>Note moyenne</p>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>