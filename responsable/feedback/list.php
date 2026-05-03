<?php
require_once '../includes/header.php';
$id_responsable = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT f.*, u.nom, u.prenom, e.titre as event_titre 
                       FROM Feedback f 
                       JOIN Utilisateur u ON f.id_user = u.id_user 
                       JOIN Evenement e ON f.id_event = e.id_event 
                       WHERE e.id_responsable = ? 
                       ORDER BY f.id_event DESC");
$stmt->execute([$id_responsable]);
$feedbacks = $stmt->fetchAll();
?>

<div class="responsible-card">
    <h2>Feedbacks reçus</h2>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Participant</th><th>Événement</th><th>Note</th><th>Commentaire</th></tr></thead>
            <tbody>
                <?php if (count($feedbacks) > 0): ?>
                    <?php foreach ($feedbacks as $fb): ?>
                    <tr>
                        <td><?= htmlspecialchars($fb['prenom'] . ' ' . $fb['nom']) ?></td>
                        <td><?= htmlspecialchars($fb['event_titre']) ?></td>
                        <td><span class="badge bg-warning text-dark"><?= $fb['note'] ?>/5</span></td>
                        <td><?= nl2br(htmlspecialchars($fb['commentaire'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center">Aucun feedback pour le moment.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>