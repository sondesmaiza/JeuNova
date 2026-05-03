<?php
require_once 'config/db.php';
require_once 'header.php';

$search = trim($_GET['search'] ?? '');
$sql = "SELECT e.*, c.nom as categorie_nom 
        FROM Evenement e 
        LEFT JOIN Categorie c ON e.id_categorie = c.id_categorie";
if (!empty($search)) {
    $sql .= " WHERE e.titre LIKE :search OR e.description LIKE :search OR e.type LIKE :search OR c.nom LIKE :search";
    $sql .= " ORDER BY e.date_debut DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['search' => "%$search%"]);
} else {
    $sql .= " ORDER BY e.date_debut DESC";
    $stmt = $pdo->query($sql);
}
$events = $stmt->fetchAll();
?>

<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="responsible-card">
                <h2 class="text-center mb-4">Tous les événements</h2>
                
                <!-- Barre de recherche -->
                <form method="get" action="evenements.php" class="d-flex justify-content-center mb-4">
                    <div class="position-relative" style="width: 300px;">
                        <i class="bi bi-search position-absolute start-0 top-50 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" name="search" class="form-control form-control-premium ps-5" 
                               placeholder="Rechercher un événement..." 
                               value="<?= htmlspecialchars($search) ?>">
                    </div>
                    <button type="submit" class="btn btn-submit ms-2">Rechercher</button>
                    <?php if($search): ?>
                        <a href="evenements.php" class="btn btn-outline-secondary ms-2">Réinitialiser</a>
                    <?php endif; ?>
                </form>

                <?php if(count($events) > 0): ?>
                    <div class="row g-4">
                        <?php foreach($events as $event): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="event-card p-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2"><?= htmlspecialchars($event['type']) ?></span>
                                    <small class="text-muted"><i class="bi bi-calendar-week"></i> <?= date('d M', strtotime($event['date_debut'])) ?></small>
                                </div>
                                <h4 class="mt-3 fw-bold"><?= htmlspecialchars($event['titre']) ?></h4>
                                <p class="text-muted small"><?= htmlspecialchars(substr($event['description'], 0, 100)) ?>...</p>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span><i class="bi bi-people-fill"></i> <?= $event['capacite'] ?> places</span>
                                    <!-- Pas de prix -->
                                </div>
                                <hr>
                                <a href="contact.php?event=<?= $event['id_event'] ?>" class="btn btn-sm btn-outline-primary rounded-pill w-100">S'inscrire <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <p class="text-muted">Aucun événement trouvé.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>