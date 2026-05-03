<?php
require_once 'config/db.php';
$message_sent = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $sujet = trim($_POST['sujet'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    if(empty($nom) || empty($email) || empty($sujet) || empty($message)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email invalide.";
    } else {
        $sql = "INSERT INTO Contact (nom, email, sujet, message, date_envoi) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        if($stmt->execute([$nom, $email, $sujet, $message])) {
            $message_sent = true;
        } else {
            $error = "Erreur lors de l'envoi. Réessayez.";
        }
    }
}
require_once 'header.php';
?>
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden glass-card">
                <div class="card-header bg-primary text-white p-4">
                    <h2 class="mb-0 fw-bold"><i class="bi bi-chat-dots-fill me-2"></i> Contactez l'équipe JeuNova</h2>
                    <p class="mb-0 mt-2 opacity-75">Nous répondons sous 24h ouvrables</p>
                </div>
                <div class="card-body p-5">
                    <?php if($message_sent): ?>
                        <div class="alert alert-success rounded-pill">✔ Message envoyé ! Nous vous contacterons rapidement.</div>
                    <?php elseif($error): ?>
                        <div class="alert alert-danger rounded-pill"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <form method="post" id="contactForm">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="input-group-icon">
                                    <i class="bi bi-person-fill input-icon"></i>
                                    <input type="text" name="nom" class="form-control form-control-premium" placeholder="Nom complet *" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group-icon">
                                    <i class="bi bi-envelope-fill input-icon"></i>
                                    <input type="email" name="email" class="form-control form-control-premium" placeholder="Email *" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-group-icon">
                                    <i class="bi bi-chat-text-fill input-icon"></i>
                                    <input type="text" name="sujet" class="form-control form-control-premium" placeholder="Sujet *" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-group-icon">
                                    <i class="bi bi-pencil-square input-icon"></i>
                                    <textarea name="message" rows="5" class="form-control form-control-premium" placeholder="Votre message personnalisé ..." required></textarea>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-submit btn-lg">Envoyer <i class="bi bi-send-fill ms-2"></i></button>
                                <a href="index.php" class="btn btn-outline-secondary rounded-pill ms-3">Retour à l'accueil</a>
                            </div>
                        </div>
                    </form>
                    <hr class="my-4">
                    <div class="text-center">
                        <p><i class="bi bi-geo-alt-fill text-primary"></i> ESEN – Manouba, Tunisie</p>
                        <p><i class="bi bi-envelope-fill"></i> contact@jeunova.tn  |  <i class="bi bi-telephone-fill"></i> +216 71 234 567</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once 'footer.php'; ?>