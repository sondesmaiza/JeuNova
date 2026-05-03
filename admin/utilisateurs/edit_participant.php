<?php
require_once '../includes/header.php';

// Récupération de l'ID du participant
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die("ID du participant invalide.");
}

// Chargement des informations actuelles du participant
$stmt = $pdo->prepare("SELECT u.*, p.niveau, p.centre_interet 
                       FROM Utilisateur u 
                       JOIN Participant p ON u.id_user = p.id_user 
                       WHERE u.id_user = ?");
$stmt->execute([$id]);
$participant = $stmt->fetch();

if (!$participant) {
    die("Participant introuvable.");
}

$error = '';
$success = '';

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $niveau = trim($_POST['niveau']);
    $centre_interet = trim($_POST['centre_interet']);

    // Validation
    if (empty($nom) || empty($prenom) || empty($email)) {
        $error = "Les champs Nom, Prénom et Email sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format d'email invalide.";
    } else {
        // Vérifier que l'email n'est pas déjà utilisé par un autre utilisateur
        $check = $pdo->prepare("SELECT id_user FROM Utilisateur WHERE email = ? AND id_user != ?");
        $check->execute([$email, $id]);
        if ($check->fetch()) {
            $error = "Cet email est déjà utilisé par un autre compte.";
        } else {
            // Mise à jour des deux tables
            $pdo->beginTransaction();
            try {
                $stmt1 = $pdo->prepare("UPDATE Utilisateur SET nom = ?, prenom = ?, email = ? WHERE id_user = ?");
                $stmt1->execute([$nom, $prenom, $email, $id]);

                $stmt2 = $pdo->prepare("UPDATE Participant SET niveau = ?, centre_interet = ? WHERE id_user = ?");
                $stmt2->execute([$niveau, $centre_interet, $id]);

                $pdo->commit();
                $success = "Participant mis à jour avec succès.";
                // Recharger les données actualisées
                $stmt = $pdo->prepare("SELECT u.*, p.niveau, p.centre_interet 
                                       FROM Utilisateur u 
                                       JOIN Participant p ON u.id_user = p.id_user 
                                       WHERE u.id_user = ?");
                $stmt->execute([$id]);
                $participant = $stmt->fetch();
            } catch (Exception $e) {
                $pdo->rollBack();
                $error = "Erreur lors de la mise à jour : " . $e->getMessage();
            }
        }
    }
}
?>

<div class="admin-card">
    <h2>Modifier le participant</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger rounded-pill">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= htmlspecialchars($error) ?>
        </div>
    <?php elseif ($success): ?>
        <div class="alert alert-success rounded-pill">
            <i class="bi bi-check-circle-fill me-2"></i> <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <form method="post" class="row g-4">
        <div class="col-md-6">
            <div class="input-group-icon">
                <i class="bi bi-person-fill input-icon"></i>
                <input type="text" name="nom" class="form-control form-control-premium" 
                       value="<?= htmlspecialchars($participant['nom']) ?>" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group-icon">
                <i class="bi bi-person-fill input-icon"></i>
                <input type="text" name="prenom" class="form-control form-control-premium" 
                       value="<?= htmlspecialchars($participant['prenom']) ?>" required>
            </div>
        </div>
        <div class="col-12">
            <div class="input-group-icon">
                <i class="bi bi-envelope-fill input-icon"></i>
                <input type="email" name="email" class="form-control form-control-premium" 
                       value="<?= htmlspecialchars($participant['email']) ?>" required>
            </div>
        </div>
        <div class="col-12">
            <div class="input-group-icon">
                <i class="bi bi-graph-up input-icon"></i>
                <input type="text" name="niveau" class="form-control form-control-premium" 
                       value="<?= htmlspecialchars($participant['niveau']) ?>" 
                       placeholder="Niveau d'étude (ex: Bac+3, Master, ...)">
            </div>
        </div>
        <div class="col-12">
            <div class="input-group-icon">
                <i class="bi bi-heart-fill input-icon"></i>
                <textarea name="centre_interet" class="form-control form-control-premium" 
                          rows="3" placeholder="Centres d'intérêt (séparés par des virgules)"><?= htmlspecialchars($participant['centre_interet']) ?></textarea>
            </div>
        </div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-submit btn-lg">
                <i class="bi bi-save me-2"></i> Mettre à jour
            </button>
            <a href="participants.php" class="btn btn-outline-secondary btn-lg ms-2">
                <i class="bi bi-arrow-left me-2"></i> Annuler
            </a>
        </div>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>