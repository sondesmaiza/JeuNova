<?php
require_once '../includes/header.php';
$id_event = $_GET['id'] ?? 0;
$id_user = $_SESSION['user_id'];

$check = $pdo->prepare("SELECT * FROM Inscription WHERE id_user = ? AND id_event = ?");
$check->execute([$id_user, $id_event]);
if ($check->fetch()) {
    $error = "Vous êtes déjà inscrit à cet événement.";
} else {
    $stmt = $pdo->prepare("INSERT INTO Inscription (id_user, id_event, date_inscription, statut) VALUES (?, ?, NOW(), 'en attente')");
    $stmt->execute([$id_user, $id_event]);
    $success = "Inscription en attente de validation.";
}
?>
<div class="responsible-card">
    <h2>Inscription</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php elseif (isset($success)): ?>
        <div class="alert alert-success"><?= $success ?> <a href="mes_inscriptions.php">Voir mes inscriptions</a></div>
    <?php endif; ?>
    <a href="../evenements/list.php" class="btn btn-primary">Retour aux événements</a>
</div>
<?php require_once '../includes/footer.php'; ?>