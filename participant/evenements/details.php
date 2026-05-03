<?php
require_once '../includes/header.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT e.*, c.nom as categorie FROM Evenement e LEFT JOIN Categorie c ON e.id_categorie = c.id_categorie WHERE e.id_event = ?");
$stmt->execute([$id]);
$event = $stmt->fetch();
if (!$event) die("Événement introuvable.");
?>
<div class="responsible-card">
    <h2><?= htmlspecialchars($event['titre']) ?></h2>
    <p><strong>Type :</strong> <?= htmlspecialchars($event['type']) ?></p>
    <p><strong>Description :</strong> <?= nl2br(htmlspecialchars($event['description'])) ?></p>
    <p><strong>Dates :</strong> du <?= $event['date_debut'] ?> au <?= $event['date_fin'] ?></p>
    <p><strong>Capacité :</strong> <?= $event['capacite'] ?></p>
    <p><strong>Durée :</strong> <?= htmlspecialchars($event['duree']) ?></p>
    <p><strong>Catégorie :</strong> <?= htmlspecialchars($event['categorie'] ?? 'Non catégorisé') ?></p>
    <a href="../inscriptions/add.php?id=<?= $event['id_event'] ?>" class="btn btn-submit">S'inscrire</a>
</div>
<?php require_once '../includes/footer.php'; ?>