<?php
require_once '../includes/header.php';
$id_responsable = $_SESSION['user_id'];
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM Evenement WHERE id_event = ? AND id_responsable = ?");
$stmt->execute([$id, $id_responsable]);
$event = $stmt->fetch();
if (!$event) die("Événement introuvable ou non autorisé.");

$categories = $pdo->query("SELECT * FROM Categorie")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $capacite = $_POST['capacite'];
    $is_actualite = isset($_POST['is_actualite']) ? 1 : 0;
    $duree = $_POST['duree'];
    $id_categorie = !empty($_POST['id_categorie']) ? $_POST['id_categorie'] : null;

    $stmt = $pdo->prepare("UPDATE Evenement SET titre=?, type=?, description=?, date_debut=?, date_fin=?, capacite=?, is_actualite=?, duree=?, id_categorie=? WHERE id_event=?");
    $stmt->execute([$titre, $type, $description, $date_debut, $date_fin, $capacite, $is_actualite, $duree, $id_categorie, $id]);
    header('Location: list.php');
    exit;
}
?>
<div class="responsible-card">
    <h2>Modifier l'événement</h2>
    <form method="post" class="row g-4">
        <div class="col-md-6"><input name="titre" class="form-control form-control-premium" value="<?= htmlspecialchars($event['titre']) ?>" required></div>
        <div class="col-md-6"><input name="type" class="form-control form-control-premium" value="<?= htmlspecialchars($event['type']) ?>" required></div>
        <div class="col-12"><textarea name="description" class="form-control form-control-premium" rows="3"><?= htmlspecialchars($event['description']) ?></textarea></div>
        <div class="col-md-3"><input type="date" name="date_debut" class="form-control form-control-premium" value="<?= $event['date_debut'] ?>" required></div>
        <div class="col-md-3"><input type="date" name="date_fin" class="form-control form-control-premium" value="<?= $event['date_fin'] ?>" required></div>
        <div class="col-md-3"><input type="number" name="capacite" class="form-control form-control-premium" value="<?= $event['capacite'] ?>" required></div>
        <div class="col-md-3"><input name="duree" class="form-control form-control-premium" value="<?= htmlspecialchars($event['duree']) ?>"></div>
        <div class="col-md-3">
            <select name="id_categorie" class="form-select form-control-premium">
                <option value="">-- Catégorie --</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= $c['id_categorie'] ?>" <?= $event['id_categorie'] == $c['id_categorie'] ? 'selected' : '' ?>><?= htmlspecialchars($c['nom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <div class="form-check form-switch">
                <input type="checkbox" name="is_actualite" class="form-check-input" id="actu" <?= $event['is_actualite'] ? 'checked' : '' ?>>
                <label class="form-check-label" for="actu">À la une</label>
            </div>
        </div>
        <div class="col-12 text-center">
            <button class="btn btn-submit btn-lg">Mettre à jour</button>
        </div>
    </form>
</div>
<?php require_once '../includes/footer.php'; ?>