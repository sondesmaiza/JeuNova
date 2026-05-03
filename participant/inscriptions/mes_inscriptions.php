<?php
require_once '../includes/header.php';
$id_user = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT i.*, e.titre as event_titre, e.date_debut 
                       FROM Inscription i 
                       JOIN Evenement e ON i.id_event = e.id_event 
                       WHERE i.id_user = ? 
                       ORDER BY i.date_inscription DESC");
$stmt->execute([$id_user]);
$inscriptions = $stmt->fetchAll();
?>
<div class="responsible-card">
    <h2>Mes inscriptions</h2>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Événement</th><th>Date inscription</th><th>Statut</th><th>Action</th></tr></thead>
            <tbody>
                <?php foreach ($inscriptions as $ins): ?>
                <tr>
                    <td><?= htmlspecialchars($ins['event_titre']) ?></td>
                    <td><?= $ins['date_inscription'] ?></td>
                    <td><span class="badge bg-<?= $ins['statut'] == 'confirmé' ? 'success' : ($ins['statut'] == 'annulé' ? 'danger' : 'warning') ?>"><?= $ins['statut'] ?></span></td>
                    <td>
                        <?php if ($ins['statut'] == 'en attente' || $ins['statut'] == 'confirmé'): ?>
                            <a href="cancel.php?id=<?= $ins['id_event'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Annuler cette inscription ?')">Annuler</a>
                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </td>
                </td>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>