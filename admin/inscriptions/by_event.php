<?php
require_once '../includes/header.php';
$events = $pdo->query("SELECT id_event, titre FROM Evenement")->fetchAll();
$list = [];
if(isset($_GET['event_id'])) {
    $stmt = $pdo->prepare("SELECT i.*, u.nom, u.prenom FROM Inscription i JOIN Utilisateur u ON i.id_user = u.id_user WHERE i.id_event = ?");
    $stmt->execute([$_GET['event_id']]);
    $list = $stmt->fetchAll();
}
?>
<div class="admin-card">
    <h2>Inscriptions par événement</h2>
    <form method="get" class="mb-4">
        <select name="event_id" class="form-select form-control-premium w-auto d-inline-block" onchange="this.form.submit()">
            <option value="">Sélectionner un événement</option>
            <?php foreach($events as $e): ?>
            <option value="<?= $e['id_event'] ?>" <?= (isset($_GET['event_id']) && $_GET['event_id']==$e['id_event']) ? 'selected' : '' ?>><?= htmlspecialchars($e['titre']) ?></option>
            <?php endforeach; ?>
        </select>
    </form>
    <?php if($list): ?>
    <div class="table-responsive">
        <table class="table table-hover"><thead><tr><th>Nom</th><th>Prénom</th><th>Statut</th></tr></thead><tbody>
        <?php foreach($list as $l): ?>
        <tr><td><?= htmlspecialchars($l['nom']) ?></td><td><?= htmlspecialchars($l['prenom']) ?></td><td><?= $l['statut'] ?></td></tr>
        <?php endforeach; ?>
        </tbody></table>
    </div>
    <?php endif; ?>
</div>
<?php require_once '../includes/footer.php'; ?>