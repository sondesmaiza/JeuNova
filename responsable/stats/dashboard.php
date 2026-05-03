<?php
require_once '../includes/header.php';
$id_responsable = $_SESSION['user_id'];

// Nombre d'événements
$stmt = $pdo->prepare("SELECT COUNT(*) FROM Evenement WHERE id_responsable = ?");
$stmt->execute([$id_responsable]);
$totalEvents = $stmt->fetchColumn();

// Inscriptions confirmées
$stmt = $pdo->prepare("SELECT COUNT(i.id_user) 
                       FROM Inscription i 
                       JOIN Evenement e ON i.id_event = e.id_event 
                       WHERE e.id_responsable = ? AND i.statut = 'confirmé'");
$stmt->execute([$id_responsable]);
$totalConfirmes = $stmt->fetchColumn();

// Taux de conversion (inscriptions confirmées / capacité totale)
$stmt = $pdo->prepare("SELECT SUM(e.capacite) FROM Evenement e WHERE e.id_responsable = ?");
$stmt->execute([$id_responsable]);
$capaciteTotale = $stmt->fetchColumn();
$tauxConversion = ($capaciteTotale > 0) ? round(($totalConfirmes / $capaciteTotale) * 100, 1) : 0;

// Note moyenne
$stmt = $pdo->prepare("SELECT AVG(f.note) 
                       FROM Feedback f 
                       JOIN Evenement e ON f.id_event = e.id_event 
                       WHERE e.id_responsable = ?");
$stmt->execute([$id_responsable]);
$avgNote = $stmt->fetchColumn();
$avgNote = $avgNote ? round($avgNote, 1) : 0;
?>

<div class="responsible-card">
    <h2>Statistiques globales</h2>
    <div class="row g-4">
        <div class="col-md-3"><div class="stat-card text-center p-3"><h4>Événements</h4><div class="stat-number"><?= $totalEvents ?></div></div></div>
        <div class="col-md-3"><div class="stat-card text-center p-3"><h4>Inscriptions confirmées</h4><div class="stat-number"><?= $totalConfirmes ?></div></div></div>
        <div class="col-md-3"><div class="stat-card text-center p-3"><h4>Taux de conversion</h4><div class="stat-number"><?= $tauxConversion ?>%</div></div></div>
        <div class="col-md-3"><div class="stat-card text-center p-3"><h4>Note moyenne</h4><div class="stat-number"><?= $avgNote ?>/5</div></div></div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>