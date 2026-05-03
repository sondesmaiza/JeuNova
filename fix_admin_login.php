<?php
require_once 'config/db.php';

// Récupérer tous les admins
$stmt = $pdo->query("SELECT u.id_user, u.email, u.mot_de_passe 
                     FROM Utilisateur u 
                     JOIN Admin a ON u.id_user = a.id_user");
$admins = $stmt->fetchAll();

if (empty($admins)) {
    die("Aucun administrateur trouvé.");
}

echo "<h2>🔍 Diagnostic des administrateurs</h2>";

foreach ($admins as $admin) {
    echo "<hr>";
    echo "<p><strong>Email :</strong> " . htmlspecialchars($admin['email']) . "</p>";
    echo "<p><strong>Hash stocké :</strong> " . $admin['mot_de_passe'] . "</p>";
    echo "<p><strong>Vérification avec 'admin123' :</strong> " . 
         (password_verify('admin123', $admin['mot_de_passe']) ? "<span style='color:green'>✅ OK</span>" : "<span style='color:red'>❌ ÉCHEC</span>") . 
         "</p>";
    
    // Si la vérification échoue, proposer une réparation
    if (!password_verify('admin123', $admin['mot_de_passe'])) {
        // Générer un nouveau hash
        $new_hash = password_hash('admin123', PASSWORD_DEFAULT);
        $update = $pdo->prepare("UPDATE Utilisateur SET mot_de_passe = ? WHERE id_user = ?");
        $update->execute([$new_hash, $admin['id_user']]);
        
        // Revérifier
        if (password_verify('admin123', $new_hash)) {
            echo "<p style='color:green'>✅ Mot de passe réinitialisé à <strong>admin123</strong> avec succès.</p>";
        } else {
            echo "<p style='color:red'>❌ Échec de la réinitialisation.</p>";
        }
    }
}

echo "<hr><p><a href='login.php'>Aller à la page de connexion</a></p>";