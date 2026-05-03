<?php
require_once '../includes/header.php';
$participants = $pdo->query("SELECT u.*, p.niveau, p.centre_interet FROM Utilisateur u JOIN Participant p ON u.id_user = p.id_user")->fetchAll();
?>
<h2>Participants</h2>
<a href="add_participant.php" class="btn btn-primary mb-3">Ajouter un participant</a>
<table class="table table-bordered">
    <thead><tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Niveau</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach($participants as $p): ?>
    <tr>
        <td><?= $p['id_user'] ?></td>
        <td><?= htmlspecialchars($p['nom']) ?></td>
        <td><?= htmlspecialchars($p['prenom']) ?></td>
        <td><?= htmlspecialchars($p['email']) ?></td>
        <td><?= htmlspecialchars($p['niveau']) ?></td>
        <td>
            <a href="edit_participant.php?id=<?= $p['id_user'] ?>" class="btn btn-sm btn-warning">Modifier</a>
            <a href="delete_participant.php?id=<?= $p['id_user'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</a>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php require_once '../includes/footer.php'; ?>