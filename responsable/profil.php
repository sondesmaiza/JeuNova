<?php
require_once 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $specialite = $_POST['specialite'];
    $bio = $_POST['bio'];

    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("UPDATE Utilisateur SET nom=?, prenom=?, email=? WHERE id_user=?");
        $stmt->execute([$nom, $prenom, $email, $_SESSION['user_id']]);
        $stmt2 = $pdo->prepare("UPDATE Responsable SET specialite=?, bio=? WHERE id_user=?");
        $stmt2->execute([$specialite, $bio, $_SESSION['user_id']]);
        $pdo->commit();
        $success = "Profil mis à jour.";
        $info = getResponsableInfo($pdo);
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = $e->getMessage();
    }
}
?>

<div class="responsible-card">
    <h2>Mon profil</h2>
    <?php if (isset($success)): ?>
        <div class="alert alert-success rounded-pill"><?= htmlspecialchars($success) ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger rounded-pill"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" class="row g-4">
        <div class="col-md-6">
            <div class="input-group-icon">
                <i class="bi bi-person-fill input-icon"></i>
                <input name="nom" class="form-control form-control-premium" value="<?= htmlspecialchars($info['nom']) ?>" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group-icon">
                <i class="bi bi-person-fill input-icon"></i>
                <input name="prenom" class="form-control form-control-premium" value="<?= htmlspecialchars($info['prenom']) ?>" required>
            </div>
        </div>
        <div class="col-12">
            <div class="input-group-icon">
                <i class="bi bi-envelope-fill input-icon"></i>
                <input type="email" name="email" class="form-control form-control-premium" value="<?= htmlspecialchars($info['email']) ?>" required>
            </div>
        </div>
        <div class="col-12">
            <div class="input-group-icon">
                <i class="bi bi-briefcase-fill input-icon"></i>
                <input name="specialite" class="form-control form-control-premium" value="<?= htmlspecialchars($info['specialite']) ?>">
            </div>
        </div>
        <div class="col-12">
            <div class="input-group-icon">
                <i class="bi bi-chat-text-fill input-icon"></i>
                <textarea name="bio" class="form-control form-control-premium" rows="4"><?= htmlspecialchars($info['bio']) ?></textarea>
            </div>
        </div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-submit btn-lg">Mettre à jour</button>
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>