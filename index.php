<?php
require_once 'config/db.php';
require_once 'header.php';

// Statistiques
$stmt = $pdo->query("SELECT COUNT(*) as total FROM Evenement");
$total_events = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(DISTINCT id_user) as total FROM Inscription WHERE statut = 'confirmé'");
$total_participants = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM Evenement WHERE type = 'formation'");
$total_formations = $stmt->fetch()['total'];

// Satisfaction
$stmt = $pdo->query("SELECT COUNT(*) as total_feedbacks, SUM(CASE WHEN note >= 4 THEN 1 ELSE 0 END) as satisfaits FROM Feedback");
$res = $stmt->fetch();
$total_feedbacks = $res['total_feedbacks'];
if ($total_feedbacks > 0) {
    $satisfaction = round(($res['satisfaits'] / $total_feedbacks) * 100);
    $has_feedback = true;
} else {
    $satisfaction = 0;
    $has_feedback = false;
}

// Témoignages
$sqlTest = "SELECT f.commentaire, f.note, u.nom, u.prenom, e.titre as event_titre
            FROM Feedback f
            JOIN Utilisateur u ON f.id_user = u.id_user
            JOIN Evenement e ON f.id_event = e.id_event
            WHERE f.commentaire IS NOT NULL AND f.commentaire != ''
            ORDER BY f.id_user DESC
            LIMIT 4";
$testimonials = $pdo->query($sqlTest)->fetchAll();
?>

<!-- Hero -->
<section class="hero-split text-white" style="background-image: url('images/photo2.jfif');">
    <div class="hero-overlay"></div>
    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8 fade-up">
                <h1 class="display-3 fw-bold mb-3">Bienvenue sur <span class="text-warning">JeuNova</span></h1>
                <p class="lead fs-4 mb-4">L'écosystème intelligent des événements et formations numériques.</p>
                <a href="#evenements" class="btn btn-light btn-lg rounded-pill px-5 shadow">Découvrir nos événements <i class="bi bi-arrow-right-circle-fill ms-2"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Objectifs -->
<section id="objectifs" class="container py-5 mt-3">
    <div class="text-center mb-5">
        <h2 class="section-title display-5">Nos Objectifs Stratégiques</h2>
        <p class="lead text-muted">Ce que nous visons avec JeuNova</p>
    </div>
    <div class="row g-4">
        <div class="col-md-4 fade-up">
            <div class="text-center p-4 rounded-4 bg-white shadow-sm h-100">
                <i class="bi bi-trophy-fill fs-1 text-primary"></i>
                <h4 class="mt-3">Excellence académique</h4>
                <p>Former aux métiers d'avenir avec des programmes certifiants.</p>
            </div>
        </div>
        <div class="col-md-4 fade-up" style="animation-delay: 0.1s;">
            <div class="text-center p-4 rounded-4 bg-white shadow-sm h-100">
                <i class="bi bi-globe2 fs-1 text-secondary"></i>
                <h4 class="mt-3">Rayonnement international</h4>
                <p>Partenariats avec les universités et entreprises du numérique.</p>
            </div>
        </div>
        <div class="col-md-4 fade-up" style="animation-delay: 0.2s;">
            <div class="text-center p-4 rounded-4 bg-white shadow-sm h-100">
                <i class="bi bi-people-fill fs-1 text-accent"></i>
                <h4 class="mt-3">Communauté active</h4>
                <p>+15 000 apprenants et un réseau d'experts engagés.</p>
            </div>
        </div>
    </div>
</section>

<!-- Statistiques -->
<section id="statistiques" class="container my-5 pt-3">
    <h2 class="section-title text-center mb-5">JeuNova en chiffres</h2>
    <div class="row g-4">
        <div class="col-md-3 col-6 fade-up">
            <div class="stat-card p-4 text-center">
                <i class="bi bi-calendar-event fs-1 text-primary"></i>
                <div class="stat-number counter-value" data-target="<?= $total_events ?>">0</div>
                <p class="mb-0 fw-semibold">Événements</p>
            </div>
        </div>
        <div class="col-md-3 col-6 fade-up" style="animation-delay: 0.1s;">
            <div class="stat-card p-4 text-center">
                <i class="bi bi-people fs-1 text-secondary"></i>
                <div class="stat-number counter-value" data-target="<?= $total_participants ?>">0</div>
                <p class="mb-0 fw-semibold">Participants</p>
            </div>
        </div>
        <div class="col-md-3 col-6 fade-up" style="animation-delay: 0.2s;">
            <div class="stat-card p-4 text-center">
                <i class="bi bi-journal-bookmark-fill fs-1 text-warning"></i>
                <div class="stat-number counter-value" data-target="<?= $total_formations ?>">0</div>
                <p class="mb-0 fw-semibold">Formations pro</p>
            </div>
        </div>
        <div class="col-md-3 col-6 fade-up" style="animation-delay: 0.3s;">
            <div class="stat-card p-4 text-center">
                <i class="bi bi-emoji-smile fs-1 text-success"></i>
                <?php if ($has_feedback): ?>
                    <div class="stat-number counter-value" data-target="<?= $satisfaction ?>">0</div>
                <?php else: ?>
                    <div class="stat-number">—</div>
                <?php endif; ?>
                <p class="mb-0 fw-semibold">% satisfaction</p>
                <?php if (!$has_feedback): ?>
                    <small class="text-muted">(aucun avis)</small>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Équipe -->
<section id="equipe" class="container py-5 bg-light rounded-4 my-5">
    <div class="text-center mb-5">
        <h2 class="section-title display-5">L'Équipe Derrière JeuNova</h2>
        <p>Des passionnés de l'économie numérique</p>
    </div>
    <div class="row g-4 justify-content-center">
        <div class="col-md-3 text-center fade-up">
            <div class="avatar-circle">
                <img src="images/hiba.jfif" alt="Souissi Hiba" class="avatar-img">
            </div>
            <h5 class="mt-3">Souissi Hiba</h5>
            <p class="text-muted">Fondatrice & Directrice</p>
        </div>
        <div class="col-md-3 text-center fade-up" style="animation-delay: 0.1s;">
            <div class="avatar-circle">
                <img src="images/sondes.jpg" alt="Maiza Sondes" class="avatar-img">
            </div>
            <h5 class="mt-3">Maiza Sondes</h5>
            <p class="text-muted">Fondatrice & Directrice</p>
        </div>
    </div>
</section>

<!-- Événements (sans prix) -->
<section id="evenements" class="container my-5 pt-5">
    <?php 
    $search = trim($_GET['search'] ?? '');
    if (!empty($search)): ?>
        <h2 class="section-title text-center">Résultats pour "<?= htmlspecialchars($search) ?>"</h2>
    <?php else: ?>
        <h2 class="section-title text-center">📅 Événements à venir</h2>
    <?php endif; ?>
    
    <div class="row g-4 mt-2">
        <?php 
        $sqlEvents = "SELECT e.*, c.nom as categorie_nom 
                      FROM Evenement e 
                      LEFT JOIN Categorie c ON e.id_categorie = c.id_categorie 
                      WHERE (e.date_debut >= CURDATE() OR e.date_fin >= CURDATE())";
        if (!empty($search)) {
            $sqlEvents .= " AND (e.titre LIKE :search OR e.description LIKE :search OR e.type LIKE :search OR c.nom LIKE :search)";
            $sqlEvents .= " ORDER BY e.date_debut ASC LIMIT 12";
        } else {
            $sqlEvents .= " ORDER BY e.date_debut ASC LIMIT 3";
        }
        $stmt = $pdo->prepare($sqlEvents);
        if (!empty($search)) {
            $stmt->execute(['search' => "%$search%"]);
        } else {
            $stmt->execute();
        }
        $events = $stmt->fetchAll();
        ?>
        <?php if(count($events) > 0): ?>
            <?php foreach($events as $event): ?>
            <div class="col-md-6 col-lg-4 fade-up">
                <div class="event-card p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2"><?= htmlspecialchars($event['type']) ?></span>
                        <small class="text-muted"><i class="bi bi-calendar-week"></i> <?= date('d M', strtotime($event['date_debut'])) ?></small>
                    </div>
                    <h4 class="mt-3 fw-bold"><?= htmlspecialchars($event['titre']) ?></h4>
                    <p class="text-muted small"><?= htmlspecialchars(substr($event['description'], 0, 100)) ?>...</p>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span><i class="bi bi-people-fill"></i> <?= $event['capacite'] ?> places</span>
                        <!-- Suppression de l'affichage du prix -->
                    </div>
                    <hr>
                    <a href="contact.php?event=<?= $event['id_event'] ?>" class="btn btn-sm btn-outline-primary rounded-pill w-100">S'inscrire <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="text-muted">
                    <?php if (!empty($search)): ?>
                        Aucun événement ne correspond à votre recherche.
                    <?php else: ?>
                        Aucun événement programmé pour le moment.
                    <?php endif; ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
    <div class="text-center mt-4"><a href="evenements.php" class="btn btn-primary rounded-pill px-5">Voir tout <i class="bi bi-arrow-right-circle"></i></a></div>
</section>

<!-- Témoignages -->
<section id="temoignages" class="container my-5 py-4">
    <!-- inchangé, identique à avant -->
    <h2 class="section-title text-center">💬 Ce qu'ils disent de JeuNova</h2>
    <div class="row g-4 mt-2">
        <?php if(count($testimonials) > 0): ?>
            <?php foreach($testimonials as $t): ?>
            <div class="col-md-6 fade-up">
                <div class="testimonial-card p-4 h-100">
                    <div class="star-rating mb-3">
                        <?php for($i=1; $i<=5; $i++): ?>
                            <i class="bi bi-star-fill <?= $i <= $t['note'] ? 'text-warning' : 'text-secondary' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="fst-italic">"<?= htmlspecialchars($t['commentaire']) ?>"</p>
                    <div class="d-flex align-items-center gap-2 mt-3">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width:45px;height:45px;"><i class="bi bi-person-circle fs-3 text-primary"></i></div>
                        <div><strong><?= htmlspecialchars($t['prenom'] . ' ' . $t['nom']) ?></strong><br><small class="text-muted">Événement : <?= htmlspecialchars($t['event_titre']) ?></small></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center"><p>Soyez le premier à laisser votre avis !</p></div>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'footer.php'; ?>