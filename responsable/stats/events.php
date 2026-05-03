<?php
require_once '../includes/header.php';
$id_responsable = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT e.id_event, e.titre, e.capacite, 
                              (SELECT COUNT(*) FROM Inscription i WHERE i.id_event = e.id_event AND i.statut = 'confirmé') as inscrits,
                              (SELECT AVG(f.note) FROM Feedback f WHERE f.id_event = e.id_event) as note_moyenne
                       FROM Evenement e
                       WHERE e.id_responsable = ?");
$stmt->execute([$id_responsable]);
$events = $stmt->fetchAll();
?>
<div class="responsible-card">
    <h2>Statistiques par événement</h2>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Événement</th><th>Capacité</th><th>Inscrits confirmés</th><th>Taux remplissage</th><th>Note moyenne</th></tr></thead>
            <tbody>
                <?php foreach ($events as $e): ?>
                <tr>
                    <td><?= htmlspecialchars($e['titre']) ?></td>
                    <td><?= $e['capacite'] ?></td>
                    <td><?= $e['inscrits'] ?></td>
                    <td><?= $e['capacite'] > 0 ? round(($e['inscrits'] / $e['capacite']) * 100, 1) : 0 ?>%</td>
                    <td><?= $e['note_moyenne'] ? round($e['note_moyenne'],1) : 'Non noté' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>