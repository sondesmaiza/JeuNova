<?php
require_once '../includes/header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $specialite = $_POST['specialite'];
    $bio = $_POST['bio'];
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("INSERT INTO Utilisateur (nom, prenom, email, mot_de_passe) VALUES (?,?,?,?)");
        $stmt->execute([$nom, $prenom, $email, $password]);
        $id = $pdo->lastInsertId();
        $stmt = $pdo->prepare("INSERT INTO Responsable (id_user, specialite, bio) VALUES (?,?,?)");
        $stmt->execute([$id, $specialite, $bio]);
        $pdo->commit();
        header('Location: responsables.php');
        exit;
    } catch(Exception $e) {
        $pdo->rollBack();
        $error = "Erreur : " . $e->getMessage();
    }
}
?>
<h2>Ajouter un responsable</h2>
<?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
<form method="post">
    <div class="mb-3"><label>Nom</label><input name="nom" class="form-control" required></div>
    <div class="mb-3"><label>Prénom</label><input name="prenom" class="form-control" required></div>
    <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
    <div class="mb-3"><label>Mot de passe</label><input type="password" name="password" class="form-control" required></div>
    <div class="mb-3"><label>Spécialité</label><input name="specialite" class="form-control"></div>
    <div class="mb-3"><label>Bio</label><textarea name="bio" class="form-control" rows="3"></textarea></div>
    <button class="btn btn-success">Créer</button>
</form>
<?php require_once '../includes/footer.php'; ?>