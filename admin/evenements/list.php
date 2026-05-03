<?php
require_once '../includes/header.php';
$events = $pdo->query("SELECT e.*, c.nom as categorie FROM Evenement e LEFT JOIN Categorie c ON e.id_categorie = c.id_categorie ORDER BY date_debut DESC")->fetchAll();
?>
<div class="admin-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Liste des événements</h2>
        <a href="add.php" class="btn btn-submit btn-sm">Ajouter</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr><th>ID</th><th>Titre</th><th>Type</th><th>Date début</th><th>Capacité</th><th>Catégorie</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php foreach($events as $e): ?>
                <tr>
                    <td><?= $e['id_event'] ?></td>
                    <td><?= htmlspecialchars($e['titre']) ?></td>
                    <td><?= htmlspecialchars($e['type']) ?></td>
                    <td><?= $e['date_debut'] ?></td>
                    <td><?= $e['capacite'] ?></td>
                    <td><?= htmlspecialchars($e['categorie'] ?? '') ?></td>
                    <td>
                        <a href="edit.php?id=<?= $e['id_event'] ?>" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil"></i></a>
                        <a href="delete.php?id=<?= $e['id_event'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>