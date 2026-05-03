<?php
require_once '../includes/header.php';
$id_responsable = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT DATE_FORMAT(i.date_inscription, '%Y-%m') as mois, COUNT(*) as total
                       FROM Inscription i
                       JOIN Evenement e ON i.id_event = e.id_event
                       WHERE e.id_responsable = ?
                       GROUP BY mois
                       ORDER BY mois DESC
                       LIMIT 6");
$stmt->execute([$id_responsable]);
$data = $stmt->fetchAll();

$mois = array_reverse(array_column($data, 'mois'));
$totaux = array_reverse(array_column($data, 'total'));
?>

<div class="responsible-card">
    <h2>Évolution des inscriptions (6 derniers mois)</h2>
    <canvas id="inscChart" height="100"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('inscChart'), {
    type: 'line',
    data: {
        labels: <?= json_encode($mois) ?>,
        datasets: [{
            label: 'Inscriptions',
            data: <?= json_encode($totaux) ?>,
            borderColor: '#FFA62B',
            tension: 0.3,
            fill: true,
            backgroundColor: 'rgba(255,166,43,0.1)'
        }]
    }
});
</script>

<?php require_once '../includes/footer.php'; ?>