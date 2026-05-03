<?php
require_once 'config/db.php';

// 1. Récupérer tous les admins
$admins = $pdo->query("SELECT u.id_user, u.email FROM Utilisateur u JOIN Admin a ON u.id_user = a.id_user")->fetchAll();

if (empty($admins)) {
    die("Aucun administrateur trouvé dans la base.");
}

echo "<h2>Réinitialisation des mots de passe administrateurs</h2>";

foreach ($admins as $admin) {
    // Générer un nouveau hash pour 'admin123'
    $new_hash = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE Utilisateur SET mot_de_passe = ? WHERE id_user = ?");
    $stmt->execute([$new_hash, $admin['id_user']]);
    
    // Vérifier que le nouveau hash est valide
    if (password_verify('admin123', $new_hash)) {
        echo "<p style='color:green'>✅ Admin {$admin['email']} : mot de passe réinitialisé à <strong>admin123</strong> avec succès.</p>";
    } else {
        echo "<p style='color:red'>❌ Échec pour {$admin['email']}.</p>";
    }
}

echo "<p><a href='login.php'>Aller à la page de connexion</a></p>";