<?php
require_once '../includes/header.php';
$responsables = $pdo->query("SELECT u.*, r.specialite, r.bio FROM utilisateur u JOIN responsable r ON u.id_user = r.id_user")->fetchAll();
?>
<h2>Responsables</h2>
<a href="add_responsable.php" class="btn btn-primary mb-3">Ajouter un responsable</a>
<table class="table table-bordered">
    <thead>
        <tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Spécialité</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($responsables as $r): ?>
        <tr>
            <td><?= $r['id_user'] ?></td>
            <td><?= htmlspecialchars($r['nom']) ?></td>
            <td><?= htmlspecialchars($r['prenom']) ?></td>
            <td><?= htmlspecialchars($r['email']) ?></td>
            <td><?= htmlspecialchars($r['specialite']) ?></td>
            <td>
                <a href="edit_responsable.php?id=<?= $r['id_user'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                <a href="delete_responsable.php?id=<?= $r['id_user'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php require_once '../includes/footer.php'; ?>