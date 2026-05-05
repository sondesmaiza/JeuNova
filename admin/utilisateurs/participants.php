<?php
require_once '../includes/header.php';
$participants = $pdo->query("SELECT u.*, p.niveau, p.centre_interet FROM Utilisateur u JOIN Participant p ON u.id_user = p.id_user")->fetchAll();
?>
<div class="admin-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Participants</h2>
        <a href="add_participant.php" class="btn btn-submit btn-sm">Ajouter</a>
    </div>
    <div style="overflow-x: auto; -webkit-overflow-scrolling: touch; width: 100%;">
        <table class="table table-hover" style="min-width: 650px; width: 100%;">
            <thead>
                <tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Niveau</th><th>Actions</th></tr>
            </thead>
            <tbody>
            <?php foreach($participants as $p): ?>
            <tr>
                <td><?= $p['id_user'] ?></td>
                <td><?= htmlspecialchars($p['nom']) ?></td>
                <td><?= htmlspecialchars($p['prenom']) ?></td>
                <td><?= htmlspecialchars($p['email']) ?></td>
                <td><?= htmlspecialchars($p['niveau']) ?></td>
                <td>
                    <a href="edit_participant.php?id=<?= $p['id_user'] ?>" class="btn btn-sm btn-warning me-1">Modifier</a>
                    <a href="delete_participant.php?id=<?= $p['id_user'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>