<?php
require_once 'config/db.php';

// Récupérer l'admin (premier trouvé)
$stmt = $pdo->query("SELECT u.id_user, u.email, u.mot_de_passe 
                     FROM Utilisateur u 
                     JOIN Admin a ON u.id_user = a.id_user 
                     LIMIT 1");
$admin = $stmt->fetch();

if (!$admin) {
    die("Aucun administrateur trouvé dans la base.");
}

echo "<h2>Informations de l'administrateur</h2>";
echo "<p><strong>Email :</strong> " . htmlspecialchars($admin['email']) . "</p>";
echo "<p><strong>Hash stocké :</strong> " . $admin['mot_de_passe'] . "</p>";

// Tester avec admin123
$test = password_verify('admin123', $admin['mot_de_passe']);
echo "<p><strong>Vérification avec 'admin123' :</strong> " . ($test ? "✅ OK" : "❌ ÉCHEC") . "</p>";

// Si échec, proposer de réparer
if (!$test) {
    echo "<hr>";
    echo "<form method='post'>";
    echo "<button type='submit' name='fix' class='btn btn-danger'>Réparer le mot de passe (admin123)</button>";
    echo "</form>";
    
    if (isset($_POST['fix'])) {
        $new_hash = password_hash('admin123', PASSWORD_DEFAULT);
        $update = $pdo->prepare("UPDATE Utilisateur SET mot_de_passe = ? WHERE id_user = ?");
        $update->execute([$new_hash, $admin['id_user']]);
        echo "<p style='color:green'>✅ Mot de passe réinitialisé. <a href='login.php'>Testez maintenant</a></p>";
    }
}