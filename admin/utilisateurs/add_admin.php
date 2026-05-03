<?php
require_once '../includes/header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("INSERT INTO Utilisateur (nom, prenom, email, mot_de_passe) VALUES (?,?,?,?)");
        $stmt->execute([$nom, $prenom, $email, $password]);
        $id = $pdo->lastInsertId();
        $stmt = $pdo->prepare("INSERT INTO Admin (id_user) VALUES (?)");
        $stmt->execute([$id]);
        $pdo->commit();
        header('Location: admins.php');
        exit;
    } catch(Exception $e) {
        $pdo->rollBack();
        $error = $e->getMessage();
    }
}
?>
<div class="admin-card">
    <h2>Ajouter un admin</h2>
    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="post" class="row g-4">
        <div class="col-md-6"><div class="input-group-icon"><i class="bi bi-person-fill input-icon"></i><input name="nom" class="form-control form-control-premium" placeholder="Nom" required></div></div>
        <div class="col-md-6"><div class="input-group-icon"><i class="bi bi-person-fill input-icon"></i><input name="prenom" class="form-control form-control-premium" placeholder="Prénom" required></div></div>
        <div class="col-12"><div class="input-group-icon"><i class="bi bi-envelope-fill input-icon"></i><input type="email" name="email" class="form-control form-control-premium" placeholder="Email" required></div></div>
        <div class="col-12"><div class="input-group-icon"><i class="bi bi-lock-fill input-icon"></i><input type="password" name="password" class="form-control form-control-premium" placeholder="Mot de passe" required></div></div>
        <div class="col-12 text-center"><button class="btn btn-submit btn-lg">Créer</button></div>
    </form>
</div>
<?php require_once '../includes/footer.php'; ?>