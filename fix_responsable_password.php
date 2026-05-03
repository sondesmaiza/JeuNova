<?php
require_once 'config/db.php';

// 1. Récupérer tous les responsables
$stmt = $pdo->query("SELECT u.id_user, u.email, u.mot_de_passe 
                     FROM Utilisateur u 
                     JOIN Responsable r ON u.id_user = r.id_user");
$responsables = $stmt->fetchAll();

if (empty($responsables)) {
    die("Aucun responsable trouvé dans la base.");
}

echo "<h2>Réinitialisation des mots de passe des responsables</h2>";

foreach ($responsables as $resp) {
    // Ancien hash (pour info)
    $old_hash = $resp['mot_de_passe'];
    
    // Nouveau hash pour le mot de passe 'responsable123'
    $new_hash = password_hash('responsable123', PASSWORD_DEFAULT);
    
    // Mise à jour
    $update = $pdo->prepare("UPDATE Utilisateur SET mot_de_passe = ? WHERE id_user = ?");
    $update->execute([$new_hash, $resp['id_user']]);
    
    // Vérifier que le nouveau hash est valide
    if (password_verify('responsable123', $new_hash)) {
        echo "<p style='color:green'>✅ Responsable <strong>{$resp['email']}</strong> : mot de passe réinitialisé à <strong>responsable123</strong> avec succès.</p>";
    } else {
        echo "<p style='color:red'>❌ Échec pour {$resp['email']}.</p>";
    }
}

echo "<hr><p><a href='login.php'>Aller à la page de connexion</a></p>";