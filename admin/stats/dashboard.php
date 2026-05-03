<?php
require_once '../includes/header.php';
$totalInscriptions = $pdo->query("SELECT COUNT(*) FROM Inscription WHERE statut='confirmé'")->fetchColumn();
$totalFeedbacks = $pdo->query("SELECT COUNT(*) FROM Feedback")->fetchColumn();
$avgNote = $pdo->query("SELECT AVG(note) FROM Feedback")->fetchColumn();
$satisfaction = $avgNote ? round(($avgNote/5)*100) : 0;
$inscritsParMois = $pdo->query("SELECT DATE_FORMAT(date_inscription, '%Y-%m') as mois, COUNT(*) as total FROM Inscription GROUP BY mois ORDER BY mois DESC LIMIT 6")->fetchAll();
$mois = array_reverse(array_column($inscritsParMois, 'mois'));
$totaux = array_reverse(array_column($inscritsParMois, 'total'));
?>
<div class="admin-card">
    <h2>Statistiques</h2>
    <div class="row g-4 mb-4">
        <div class="col-md-4"><div class="stat-card text-center p-3"><h4>Inscriptions</h4><div class="stat-number"><?= $totalInscriptions ?></div></div></div>
        <div class="col-md-4"><div class="stat-card text-center p-3"><h4>Feedbacks</h4><div class="stat-number"><?= $totalFeedbacks ?></div></div></div>
        <div class="col-md-4"><div class="stat-card text-center p-3"><h4>Satisfaction</h4><div class="stat-number"><?= $satisfaction ?>%</div></div></div>
    </div>
    <canvas id="statsChart" height="100"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('statsChart'), {
    type: 'line',
    data: { labels: <?= json_encode($mois) ?>, datasets: [{ label: 'Inscriptions', data: <?= json_encode($totaux) ?>, borderColor: '#FFA62B', tension: 0.3 }] }
});
</script>
<?php require_once '../includes/footer.php'; ?>