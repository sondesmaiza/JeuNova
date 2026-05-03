<?php
require_once 'config/db.php';

$email_admin = 'admin@exemple.com'; // Remplacez par l'email réel de votre admin
$new_password = 'admin123';

$hash = password_hash($new_password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("UPDATE Utilisateur SET mot_de_passe = ? WHERE email = ?");
if ($stmt->execute([$hash, $email_admin])) {
    echo "Mot de passe de l'admin réinitialisé à '$new_password' pour l'email $email_admin.<br>";
    echo "<a href='login.php'>Aller à la connexion</a>";
} else {
    echo "Erreur.";
}