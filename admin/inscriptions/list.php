<?php
require_once '../includes/header.php';
$inscriptions = $pdo->query("SELECT i.*, u.nom, u.prenom, e.titre as event_titre FROM Inscription i JOIN Utilisateur u ON i.id_user = u.id_user JOIN Evenement e ON i.id_event = e.id_event ORDER BY date_inscription DESC")->fetchAll();
?>
<div class="admin-card">
    <h2>Inscriptions</h2>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Participant</th><th>Événement</th><th>Date</th><th>Statut</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach($inscriptions as $ins): ?>
            <tr>
                <td><?= htmlspecialchars($ins['prenom'] . ' ' . $ins['nom']) ?></td>
                <td><?= htmlspecialchars($ins['event_titre']) ?></td>
                <td><?= $ins['date_inscription'] ?></td>
                <td><span class="badge bg-<?= $ins['statut'] == 'confirmé' ? 'success' : 'danger' ?>"><?= $ins['statut'] ?></span></td>
                <td>
                    <a href="update_status.php?id_user=<?= $ins['id_user'] ?>&id_event=<?= $ins['id_event'] ?>&status=confirmé" class="btn btn-sm btn-success me-1">Confirmer</a>
                    <a href="update_status.php?id_user=<?= $ins['id_user'] ?>&id_event=<?= $ins['id_event'] ?>&status=annulé" class="btn btn-sm btn-danger">Annuler</a>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>