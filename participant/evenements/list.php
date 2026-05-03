<?php
require_once '../includes/header.php';
$events = $pdo->query("SELECT e.*, c.nom as categorie 
                       FROM Evenement e 
                       LEFT JOIN Categorie c ON e.id_categorie = c.id_categorie 
                       ORDER BY e.date_debut DESC")->fetchAll();
?>
<div class="responsible-card">
    <h2>Tous les événements</h2>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Titre</th><th>Type</th><th>Date début</th><th>Capacité</th><th>Catégorie</th><th>Action</th></tr></thead>
            <tbody>
                <?php foreach ($events as $e): ?>
                <tr>
                    <td><?= htmlspecialchars($e['titre']) ?></td>
                    <td><?= htmlspecialchars($e['type']) ?></td>
                    <td><?= $e['date_debut'] ?></td>
                    <td><?= $e['capacite'] ?></td>
                    <td><?= htmlspecialchars($e['categorie'] ?? '—') ?></td>
                    <td>
                        <a href="../inscriptions/add.php?id=<?= $e['id_event'] ?>" class="btn btn-sm btn-primary">S'inscrire</a>
                        <a href="details.php?id=<?= $e['id_event'] ?>" class="btn btn-sm btn-outline-secondary">Détails</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>