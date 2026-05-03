<?php
require_once '../includes/header.php';
$id_responsable = $_SESSION['user_id'];
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

    $stmt = $pdo->prepare("INSERT INTO Evenement 
                           (titre, type, description, date_debut, date_fin, capacite, is_actualite, duree, id_categorie, id_responsable) 
                           VALUES (?,?,?,?,?,?,?,?,?,?)");
    $stmt->execute([$titre, $type, $description, $date_debut, $date_fin, $capacite, $is_actualite, $duree, $id_categorie, $id_responsable]);
    header('Location: list.php');
    exit;
}
?>
<div class="responsible-card">
    <h2>Ajouter un événement</h2>
    <form method="post" class="row g-4">
        <div class="col-md-6"><input name="titre" class="form-control form-control-premium" placeholder="Titre" required></div>
        <div class="col-md-6"><input name="type" class="form-control form-control-premium" placeholder="Type" required></div>
        <div class="col-12"><textarea name="description" class="form-control form-control-premium" rows="3" placeholder="Description"></textarea></div>
        <div class="col-md-3"><input type="date" name="date_debut" class="form-control form-control-premium" required></div>
        <div class="col-md-3"><input type="date" name="date_fin" class="form-control form-control-premium" required></div>
        <div class="col-md-3"><input type="number" name="capacite" class="form-control form-control-premium" placeholder="Capacité" required></div>
        <div class="col-md-3"><input name="duree" class="form-control form-control-premium" placeholder="Durée (ex: 5 semaines)"></div>
        <div class="col-md-3">
            <select name="id_categorie" class="form-select form-control-premium">
                <option value="">-- Catégorie --</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= $c['id_categorie'] ?>"><?= htmlspecialchars($c['nom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <div class="form-check form-switch">
                <input type="checkbox" name="is_actualite" class="form-check-input" id="actu">
                <label class="form-check-label" for="actu">À la une</label>
            </div>
        </div>
        <div class="col-12 text-center">
            <button class="btn btn-submit btn-lg">Créer l'événement</button>
        </div>
    </form>
</div>
<?php require_once '../includes/footer.php'; ?>