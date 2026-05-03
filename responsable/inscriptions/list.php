<?php
require_once '../includes/header.php';
$id_responsable = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT i.id_user, i.id_event, i.date_inscription, i.statut, 
                              u.nom, u.prenom, e.titre as event_titre 
                       FROM Inscription i 
                       JOIN Utilisateur u ON i.id_user = u.id_user 
                       JOIN Evenement e ON i.id_event = e.id_event 
                       WHERE e.id_responsable = ? 
                       ORDER BY i.date_inscription DESC");
$stmt->execute([$id_responsable]);
$inscriptions = $stmt->fetchAll();
?>

<div class="responsible-card">
    <h2>Inscriptions à mes événements</h2>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Participant</th><th>Événement</th><th>Date inscription</th><th>Statut</th><th>Actions</th></tr></thead>
            <tbody>
                <?php if (count($inscriptions) > 0): ?>
                    <?php foreach ($inscriptions as $ins): ?>
                    <tr>
                        <td><?= htmlspecialchars($ins['prenom'] . ' ' . $ins['nom']) ?></td>
                        <td><?= htmlspecialchars($ins['event_titre']) ?></td>
                        <td><?= $ins['date_inscription'] ?></td>
                        <td><span class="badge bg-<?= $ins['statut'] == 'confirmé' ? 'success' : ($ins['statut'] == 'annulé' ? 'danger' : 'warning') ?>"><?= $ins['statut'] ?></span></td>
                        <td>
                            <?php if ($ins['statut'] == 'en attente'): ?>
                                <a href="valider.php?id_user=<?= $ins['id_user'] ?>&id_event=<?= $ins['id_event'] ?>" class="btn btn-sm btn-success me-1">Valider</a>
                                <a href="refuser.php?id_user=<?= $ins['id_user'] ?>&id_event=<?= $ins['id_event'] ?>" class="btn btn-sm btn-danger">Refuser</a>
                            <?php else: ?>
                                <span class="text-muted">Déjà traité</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center">Aucune inscription.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>