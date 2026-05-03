<?php
require_once '../includes/header.php';
$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $specialite = $_POST['specialite'];
    $bio = $_POST['bio'];
    $pdo->prepare("UPDATE Utilisateur SET nom=?, prenom=?, email=? WHERE id_user=?")->execute([$nom, $prenom, $email, $id]);
    $pdo->prepare("UPDATE Responsable SET specialite=?, bio=? WHERE id_user=?")->execute([$specialite, $bio, $id]);
    header('Location: responsables.php');
    exit;
}
$stmt = $pdo->prepare("SELECT u.*, r.specialite, r.bio FROM Utilisateur u JOIN Responsable r ON u.id_user = r.id_user WHERE u.id_user=?");
$stmt->execute([$id]);
$resp = $stmt->fetch();
if(!$resp) die("Responsable introuvable");
?>
<h2>Modifier responsable</h2>
<form method="post">
    <div class="mb-3"><label>Nom</label><input name="nom" class="form-control" value="<?= htmlspecialchars($resp['nom']) ?>" required></div>
    <div class="mb-3"><label>Prénom</label><input name="prenom" class="form-control" value="<?= htmlspecialchars($resp['prenom']) ?>" required></div>
    <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" value="<?= htmlspecialchars($resp['email']) ?>" required></div>
    <div class="mb-3"><label>Spécialité</label><input name="specialite" class="form-control" value="<?= htmlspecialchars($resp['specialite']) ?>"></div>
    <div class="mb-3"><label>Bio</label><textarea name="bio" class="form-control" rows="3"><?= htmlspecialchars($resp['bio']) ?></textarea></div>
    <button class="btn btn-primary">Mettre à jour</button>
</form>
<?php require_once '../includes/footer.php'; ?>