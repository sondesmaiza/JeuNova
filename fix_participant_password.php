<?php
require_once 'config/db.php';

// Récupérer tous les participants
$stmt = $pdo->query("SELECT u.id_user, u.email, u.mot_de_passe 
                     FROM Utilisateur u 
                     JOIN Participant p ON u.id_user = p.id_user");
$participants = $stmt->fetchAll();

if (empty($participants)) {
    die("Aucun participant trouvé.");
}

echo "<h2>Réinitialisation des mots de passe des participants</h2>";

foreach ($participants as $p) {
    // Nouveau hash pour 'participant123'
    $new_hash = password_hash('participant123', PASSWORD_DEFAULT);
    
    $update = $pdo->prepare("UPDATE Utilisateur SET mot_de_passe = ? WHERE id_user = ?");
    $update->execute([$new_hash, $p['id_user']]);
    
    if (password_verify('participant123', $new_hash)) {
        echo "<p style='color:green'>✅ Participant <strong>{$p['email']}</strong> : mot de passe réinitialisé à <strong>participant123</strong> avec succès.</p>";
    } else {
        echo "<p style='color:red'>❌ Échec pour {$p['email']}.</p>";
    }
}

echo "<hr><p><a href='login.php'>Aller à la page de connexion</a></p>";