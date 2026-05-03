<?php
require_once '../includes/header.php';
$feedbacks = $pdo->query("SELECT f.*, u.nom, u.prenom, e.titre as event FROM Feedback f JOIN Utilisateur u ON f.id_user = u.id_user JOIN Evenement e ON f.id_event = e.id_event ORDER BY f.note DESC")->fetchAll();
?>
<div class="admin-card">
    <h2>Feedbacks</h2>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Participant</th><th>Événement</th><th>Note</th><th>Commentaire</th><th>Validation</th></tr></thead>
            <tbody>
            <?php foreach($feedbacks as $fb): ?>
            <tr>
                <td><?= htmlspecialchars($fb['prenom'] . ' ' . $fb['nom']) ?></td>
                <td><?= htmlspecialchars($fb['event']) ?></td>
                <td><span class="badge bg-warning text-dark"><?= $fb['note'] ?> / 5</span></td>
                <td><?= nl2br(htmlspecialchars($fb['commentaire'])) ?></td>
                <td>
                    <?php if(!isset($fb['valide']) || !$fb['valide']): ?>
                        <a href="validate.php?id_user=<?= $fb['id_user'] ?>&id_event=<?= $fb['id_event'] ?>" class="btn btn-sm btn-success">Valider</a>
                    <?php else: ?>
                        <span class="badge bg-success">Validé</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>