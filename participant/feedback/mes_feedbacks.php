<?php
require_once '../includes/header.php';
$id_user = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT f.*, e.titre as event_titre 
                       FROM Feedback f 
                       JOIN Evenement e ON f.id_event = e.id_event 
                       WHERE f.id_user = ? 
                       ORDER BY f.id_event DESC");
$stmt->execute([$id_user]);
$feedbacks = $stmt->fetchAll();
?>
<div class="responsible-card">
    <h2>Mes feedbacks</h2>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Événement</th><th>Note</th><th>Commentaire</th><th>Date</th></tr></thead>
            <tbody>
                <?php foreach ($feedbacks as $fb): ?>
                <tr>
                    <td><?= htmlspecialchars($fb['event_titre']) ?></td>
                    <td><span class="badge bg-warning text-dark"><?= $fb['note'] ?>/5</span></td>
                    <td><?= nl2br(htmlspecialchars($fb['commentaire'])) ?></td>
                    <td><?= $fb['date_creation'] ?? '—' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>