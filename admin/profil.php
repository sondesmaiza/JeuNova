<?php
require_once 'includes/header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $stmt = $pdo->prepare("UPDATE Utilisateur SET nom=?, prenom=?, email=? WHERE id_user=?");
    $stmt->execute([$nom, $prenom, $email, $_SESSION['user_id']]);
    $_SESSION['nom'] = $nom;
    $_SESSION['prenom'] = $prenom;
    $success = "Profil mis à jour";
    $adminInfo = getAdminInfo($pdo);
}
?>
<div class="admin-card">
    <h2>Mon profil</h2>
    <?php if(isset($success)) echo "<div class='alert alert-success rounded-pill'>$success</div>"; ?>
    <form method="post" class="row g-4">
        <div class="col-md-6">
            <div class="input-group-icon">
                <i class="bi bi-person-fill input-icon"></i>
                <input name="nom" class="form-control form-control-premium" value="<?= htmlspecialchars($adminInfo['nom']) ?>" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group-icon">
                <i class="bi bi-person-fill input-icon"></i>
                <input name="prenom" class="form-control form-control-premium" value="<?= htmlspecialchars($adminInfo['prenom']) ?>" required>
            </div>
        </div>
        <div class="col-12">
            <div class="input-group-icon">
                <i class="bi bi-envelope-fill input-icon"></i>
                <input type="email" name="email" class="form-control form-control-premium" value="<?= htmlspecialchars($adminInfo['email']) ?>" required>
            </div>
        </div>
        <div class="col-12 text-center">
            <button class="btn btn-submit btn-lg">Mettre à jour</button>
        </div>
    </form>
</div>
<?php require_once 'includes/footer.php'; ?>