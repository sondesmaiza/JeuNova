<?php
require_once '../includes/header.php';
$id_responsable = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT DISTINCT u.id_user, u.nom, u.prenom, u.email, p.niveau 
                       FROM Utilisateur u 
                       JOIN Participant p ON u.id_user = p.id_user 
                       JOIN Inscription i ON u.id_user = i.id_user 
                       JOIN Evenement e ON i.id_event = e.id_event 
                       WHERE e.id_responsable = ? AND i.statut = 'confirmé'
                       ORDER BY u.nom");
$stmt->execute([$id_responsable]);
$participants = $stmt->fetchAll();
?>

<div class="responsible-card">
    <h2>Participants à mes événements</h2>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Nom</th><th>Prénom</th><th>Email</th><th>Niveau</th></tr></thead>
            <tbody>
                <?php if (count($participants) > 0): ?>
                    <?php foreach ($participants as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['nom']) ?></td>
                        <td><?= htmlspecialchars($p['prenom']) ?></td>
                        <td><?= htmlspecialchars($p['email']) ?></td>
                        <td><?= htmlspecialchars($p['niveau']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center">Aucun participant inscrit.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>