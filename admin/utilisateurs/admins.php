<?php
require_once '../includes/header.php';
$admins = $pdo->query("SELECT u.* FROM Utilisateur u JOIN Admin a ON u.id_user = a.id_user")->fetchAll();
?>
<div class="admin-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Administrateurs</h2>
        <a href="add_admin.php" class="btn btn-submit btn-sm">Ajouter</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Nom</th><th>Prénom</th><th>Email</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach($admins as $a): ?>
            <tr>
                <td><?= htmlspecialchars($a['nom']) ?></td>
                <td><?= htmlspecialchars($a['prenom']) ?></td>
                <td><?= htmlspecialchars($a['email']) ?></td>
                <td>
                    <a href="edit_admin.php?id=<?= $a['id_user'] ?>" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil"></i></a>
                    <a href="delete_admin.php?id=<?= $a['id_user'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')"><i class="bi bi-trash"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>