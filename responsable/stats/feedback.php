<?php
require_once '../includes/header.php';
$id_responsable = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT e.titre, AVG(f.note) as avg_note
                       FROM Feedback f
                       JOIN Evenement e ON f.id_event = e.id_event
                       WHERE e.id_responsable = ?
                       GROUP BY e.id_event
                       ORDER BY avg_note DESC");
$stmt->execute([$id_responsable]);
$ratings = $stmt->fetchAll();
?>

<div class="responsible-card">
    <h2>Notes moyennes par événement</h2>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Événement</th><th>Note moyenne</th></tr></thead>
            <tbody>
                <?php foreach ($ratings as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['titre']) ?></td>
                    <td><span class="badge bg-warning text-dark"><?= round($r['avg_note'], 1) ?> / 5</span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>