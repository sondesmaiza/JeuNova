<?php
require_once '../includes/header.php';
$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $pdo->prepare("UPDATE Utilisateur SET nom=?, prenom=?, email=? WHERE id_user=?")->execute([$nom, $prenom, $email, $id]);
    header('Location: admins.php');
    exit;
}
$stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE id_user=?");
$stmt->execute([$id]);
$admin = $stmt->fetch();
?>
<div class="admin-card">
    <h2>Modifier admin</h2>
    <form method="post" class="row g-4">
        <div class="col-md-6"><input name="nom" class="form-control form-control-premium" value="<?= htmlspecialchars($admin['nom']) ?>" required></div>
        <div class="col-md-6"><input name="prenom" class="form-control form-control-premium" value="<?= htmlspecialchars($admin['prenom']) ?>" required></div>
        <div class="col-12"><input type="email" name="email" class="form-control form-control-premium" value="<?= htmlspecialchars($admin['email']) ?>" required></div>
        <div class="col-12 text-center"><button class="btn btn-submit btn-lg">Mettre à jour</button></div>
    </form>
</div>
<?php require_once '../includes/footer.php'; ?>