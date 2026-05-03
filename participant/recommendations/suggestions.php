<?php
require_once '../includes/header.php';
$id_user = $_SESSION['user_id'];

// Récupérer les centres d'intérêt (mots-clés)
$stmt = $pdo->prepare("SELECT centre_interet FROM Participant WHERE id_user = ?");
$stmt->execute([$id_user]);
$centre = $stmt->fetchColumn();
$keywords = array_filter(array_map('trim', explode(',', $centre ?? '')), fn($k) => strlen($k) > 2);

// Récupérer les catégories des événements déjà suivis (inscriptions confirmées)
$stmt = $pdo->prepare("SELECT DISTINCT e.id_categorie 
                       FROM Evenement e 
                       JOIN Inscription i ON e.id_event = i.id_event 
                       WHERE i.id_user = ? AND i.statut = 'confirmé'
                       AND e.id_categorie IS NOT NULL");
$stmt->execute([$id_user]);
$categories_interet = $stmt->fetchAll(PDO::FETCH_COLUMN);

$sql = "SELECT e.*, c.nom as categorie 
        FROM Evenement e 
        LEFT JOIN Categorie c ON e.id_categorie = c.id_categorie 
        WHERE e.id_event NOT IN (SELECT id_event FROM Inscription WHERE id_user = ?)";
$params = [$id_user];
$conditions = [];

if (!empty($categories_interet)) {
    $placeholders = implode(',', array_fill(0, count($categories_interet), '?'));
    $conditions[] = "e.id_categorie IN ($placeholders)";
    $params = array_merge($params, $categories_interet);
}
if (!empty($keywords)) {
    $kw_conds = [];
    foreach ($keywords as $kw) {
        $kw_conds[] = "(e.titre LIKE ? OR c.nom LIKE ?)";
        $params[] = "%$kw%";
        $params[] = "%$kw%";
    }
    $conditions[] = "(" . implode(' OR ', $kw_conds) . ")";
}

// Pas de fallback : on n'affiche que s'il y a des conditions
if (!empty($conditions)) {
    $sql .= " AND (" . implode(' OR ', $conditions) . ")";
    $sql .= " ORDER BY e.date_debut ASC LIMIT 12";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $suggestions = $stmt->fetchAll();
} else {
    $suggestions = []; // aucun critère → pas de recommandations
}
?>

<div class="responsible-card">
    <h2>Événements recommandés pour vous</h2>
    <?php if (empty($suggestions)): ?>
        <div class="alert alert-info">
            Aucune recommandation pour l'instant.<br>
            Complétez votre profil (centres d'intérêt) ou participez à des événements pour affiner les suggestions.
        </div>
    <?php else: ?>
        <div class="row g-4 mt-2">
            <?php foreach ($suggestions as $s): ?>
            <div class="col-md-6 col-lg-4 fade-up">
                <div class="event-card p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2"><?= htmlspecialchars($s['type']) ?></span>
                        <small class="text-muted"><i class="bi bi-calendar-week"></i> <?= date('d M', strtotime($s['date_debut'])) ?></small>
                    </div>
                    <h4 class="mt-3 fw-bold"><?= htmlspecialchars($s['titre']) ?></h4>
                    <p class="text-muted small"><?= htmlspecialchars(substr($s['description'], 0, 100)) ?>...</p>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span><i class="bi bi-people-fill"></i> <?= $s['capacite'] ?> places</span>
                        <?php if(!empty($s['categorie'])): ?>
                            <span class="fw-bold text-primary"><?= htmlspecialchars($s['categorie']) ?></span>
                        <?php endif; ?>
                    </div>
                    <hr>
                    <a href="../inscriptions/add.php?id=<?= $s['id_event'] ?>" class="btn btn-sm btn-outline-primary rounded-pill w-100">S'inscrire <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../includes/footer.php'; ?>