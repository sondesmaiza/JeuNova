<?php
require_once '../includes/header.php';
$id_user = $_SESSION['user_id'];

// Sélectionner tous les événements confirmés sans feedback (même futurs)
$sql = "SELECT e.id_event, e.titre, e.date_fin
        FROM Inscription i 
        JOIN Evenement e ON i.id_event = e.id_event 
        WHERE i.id_user = ? AND i.statut = 'confirmé'
          AND NOT EXISTS (SELECT 1 FROM Feedback f WHERE f.id_user = ? AND f.id_event = e.id_event)
        ORDER BY e.date_fin DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_user, $id_user]);
$events = $stmt->fetchAll();

$error = $success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_event = (int)$_POST['id_event'];
    $note = (int)$_POST['note'];
    $commentaire = trim($_POST['commentaire']);
    if ($note < 1 || $note > 5) {
        $error = "La note doit être comprise entre 1 et 5.";
    } elseif (empty($commentaire)) {
        $error = "Le commentaire ne peut pas être vide.";
    } else {
        $insert = $pdo->prepare("INSERT INTO Feedback (id_user, id_event, note, commentaire) VALUES (?, ?, ?, ?)");
        if ($insert->execute([$id_user, $id_event, $note, $commentaire])) {
            $success = "Merci pour votre avis !";
            // Recharger la liste (l'événement noté disparaît)
            $stmt->execute([$id_user, $id_user]);
            $events = $stmt->fetchAll();
        } else {
            $error = "Erreur lors de l'enregistrement.";
        }
    }
}
?>

<div class="responsible-card">
    <h2>Donner mon avis</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if (empty($events)): ?>
        <div class="alert alert-info">
            Vous n'avez aucun événement confirmé sans avis. Tous vos événements ont déjà été notés.
        </div>
    <?php else: ?>
        <form method="post" class="row g-4">
            <div class="col-12">
                <label>Événement</label>
                <select name="id_event" class="form-select form-control-premium" required>
                    <?php foreach ($events as $e): ?>
                        <option value="<?= $e['id_event'] ?>">
                            <?= htmlspecialchars($e['titre']) ?> (<?= $e['date_fin'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12">
                <label>Note (1 à 5)</label>
                <input type="number" name="note" class="form-control form-control-premium" min="1" max="5" step="1" required>
            </div>
            <div class="col-12">
                <label>Commentaire</label>
                <textarea name="commentaire" class="form-control form-control-premium" rows="4" required></textarea>
            </div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-submit btn-lg">Envoyer l'avis</button>
            </div>
        </form>
    <?php endif; ?>
    <div class="mt-4 text-center">
        <a href="mes_feedbacks.php" class="btn btn-outline-secondary">📋 Voir mes feedbacks</a>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>