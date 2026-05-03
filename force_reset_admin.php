<?php
require_once 'config/db.php';

// Récupérer l'email de l'admin (vous pouvez aussi le remplacer manuellement)
$stmt = $pdo->query("SELECT u.email FROM Utilisateur u JOIN Admin a ON u.id_user = a.id_user LIMIT 1");
$admin = $stmt->fetch();
if (!$admin) {
    die("Aucun administrateur trouvé.");
}
$email = $admin['email'];

echo "Administrateur trouvé : <strong>" . htmlspecialchars($email) . "</strong><br>";

$nouveau_mdp = 'admin123';
$nouveau_hash = password_hash($nouveau_mdp, PASSWORD_DEFAULT);

// Vérifier que le hash est valide
if (!password_verify($nouveau_mdp, $nouveau_hash)) {
    die("Erreur : le hash généré ne fonctionne pas.");
}

// Mettre à jour la base
$update = $pdo->prepare("UPDATE Utilisateur SET mot_de_passe = ? WHERE email = ?");
if ($update->execute([$nouveau_hash, $email])) {
    // Vérification finale
    $check = $pdo->prepare("SELECT mot_de_passe FROM Utilisateur WHERE email = ?");
    $check->execute([$email]);
    $row = $check->fetch();
    if (password_verify($nouveau_mdp, $row['mot_de_passe'])) {
        echo "<span style='color:green'>✅ Mot de passe réinitialisé avec succès pour $email.</span><br>";
        echo "Mot de passe : <strong>admin123</strong><br>";
        echo "<a href='login.php'>Aller à la page de connexion</a>";
    } else {
        echo "<span style='color:red'>❌ La vérification finale a échoué. Le hash a été modifié mais ne fonctionne toujours pas.</span>";
    }
} else {
    echo "❌ Échec de la mise à jour.";
}