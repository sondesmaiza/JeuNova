<?php
require_once '../includes/header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $niveau = $_POST['niveau'];
    $centre_interet = $_POST['centre_interet'];
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("INSERT INTO Utilisateur (nom, prenom, email, mot_de_passe) VALUES (?,?,?,?)");
        $stmt->execute([$nom, $prenom, $email, $password]);
        $id = $pdo->lastInsertId();
        $stmt = $pdo->prepare("INSERT INTO Participant (id_user, niveau, centre_interet) VALUES (?,?,?)");
        $stmt->execute([$id, $niveau, $centre_interet]);
        $pdo->commit();
        header('Location: participants.php');
        exit;
    } catch(Exception $e) {
        $pdo->rollBack();
        $error = "Erreur : " . $e->getMessage();
    }
}
?>
<h2>Ajouter un participant</h2>
<?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
<form method="post">
    <div class="mb-3"><label>Nom</label><input name="nom" class="form-control" required></div>
    <div class="mb-3"><label>Prénom</label><input name="prenom" class="form-control" required></div>
    <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
    <div class="mb-3"><label>Mot de passe</label><input type="password" name="password" class="form-control" required></div>
    <div class="mb-3"><label>Niveau</label><input name="niveau" class="form-control"></div>
    <div class="mb-3"><label>Centres d'intérêt</label><textarea name="centre_interet" class="form-control" rows="2"></textarea></div>
    <button class="btn btn-success">Créer</button>
</form>
<?php require_once '../includes/footer.php'; ?>