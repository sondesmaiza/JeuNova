<?php
require_once '../includes/header.php';
$responsables = $pdo->query("SELECT u.*, r.specialite, r.bio FROM Utilisateur u JOIN Responsable r ON u.id_user = r.id_user")->fetchAll();
?>
<div class="admin-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Responsables</h2>
        <a href="add_responsable.php" class="btn btn-submit btn-sm">Ajouter</a>
    </div>
    <div style="overflow-x: auto; -webkit-overflow-scrolling: touch; width: 100%;">
        <table class="table table-hover" style="min-width: 650px; width: 100%;">
            <thead>
                <tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Spécialité</th><th>Actions</th></tr>
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
                    <a href="edit_responsable.php?id=<?= $r['id_user'] ?>" class="btn btn-sm btn-warning me-1">Modifier</a>
                    <a href="delete_responsable.php?id=<?= $r['id_user'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>