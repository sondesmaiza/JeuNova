<?php
require_once 'includes/header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $niveau = $_POST['niveau'];
    $centre_interet = $_POST['centre_interet'];
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("UPDATE Utilisateur SET nom=?, prenom=?, email=? WHERE id_user=?");
        $stmt->execute([$nom, $prenom, $email, $_SESSION['user_id']]);
        $stmt2 = $pdo->prepare("UPDATE Participant SET niveau=?, centre_interet=? WHERE id_user=?");
        $stmt2->execute([$niveau, $centre_interet, $_SESSION['user_id']]);
        $pdo->commit();
        $success = "Profil mis à jour.";
        $info = getParticipantInfo($pdo);
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = $e->getMessage();
    }
}
?>
<div class="responsible-card">
    <h2>Mon profil</h2>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="post" class="row g-4">
        <div class="col-md-6"><div class="input-group-icon"><i class="bi bi-person-fill input-icon"></i><input name="nom" class="form-control form-control-premium" value="<?= htmlspecialchars($info['nom']) ?>" required></div></div>
        <div class="col-md-6"><div class="input-group-icon"><i class="bi bi-person-fill input-icon"></i><input name="prenom" class="form-control form-control-premium" value="<?= htmlspecialchars($info['prenom']) ?>" required></div></div>
        <div class="col-12"><div class="input-group-icon"><i class="bi bi-envelope-fill input-icon"></i><input type="email" name="email" class="form-control form-control-premium" value="<?= htmlspecialchars($info['email']) ?>" required></div></div>
        <div class="col-12"><div class="input-group-icon"><i class="bi bi-graph-up input-icon"></i><input name="niveau" class="form-control form-control-premium" value="<?= htmlspecialchars($info['niveau']) ?>" placeholder="Niveau d'étude"></div></div>
        <div class="col-12"><div class="input-group-icon"><i class="bi bi-heart-fill input-icon"></i><textarea name="centre_interet" class="form-control form-control-premium" rows="3" placeholder="Centres d'intérêt (séparés par des virgules)"><?= htmlspecialchars($info['centre_interet']) ?></textarea></div></div>
        <div class="col-12 text-center"><button class="btn btn-submit btn-lg">Mettre à jour</button></div>
    </form>
</div>
<?php require_once 'includes/footer.php'; ?>