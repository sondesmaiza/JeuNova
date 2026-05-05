<?php
require_once '../includes/header.php';
$messages = $pdo->query("SELECT * FROM Contact ORDER BY date_envoi DESC")->fetchAll();
?>
<div class="admin-card">
    <h2>Messages reçus</h2>
    <div style="overflow-x: auto; -webkit-overflow-scrolling: touch; width: 100%;">
        <table class="table table-hover" style="min-width: 650px; width: 100%;">
            <thead>
                <tr><th>Nom</th><th>Email</th><th>Sujet</th><th>Message</th><th>Date</th></tr>
            </thead>
            <tbody>
            <?php foreach($messages as $msg): ?>
            <tr>
                <td><?= htmlspecialchars($msg['nom']) ?></td>
                <td><?= htmlspecialchars($msg['email']) ?></td>
                <td><?= htmlspecialchars($msg['sujet']) ?></td>
                <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
                <td><?= $msg['date_envoi'] ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>