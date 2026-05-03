<?php
// Mettez ce fichier dans le MÊME dossier que donner_avis.php
// Exemple : C:\xampp\htdocs\jeunova\participant\participants\debug.php

session_start();

// Chercher le fichier de connexion PDO
$possible_configs = [
    '../includes/config.php',
    '../includes/db.php',
    '../includes/connexion.php',
    '../config/db.php',
    '../config/config.php',
    '../../includes/config.php',
    '../../includes/db.php',
];

$pdo = null;
$config_found = '';
foreach ($possible_configs as $path) {
    if (file_exists($path)) {
        require_once $path;
        $config_found = $path;
        break;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>DEBUG JeuNova</title>
    <style>
        body { font-family: monospace; background: #f0f4ff; padding: 20px; }
        .box { background: #fff; border-radius: 10px; padding: 20px; margin-bottom: 15px; border-left: 4px solid #1e50b4; }
        h2 { color: #1a3a6e; }
        h3 { color: #3a7bd5; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        .ok  { color: green; }
        .err { color: red; }
        pre  { background: #f8faff; padding: 10px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>

<div class="box">
    <h2>🔍 DEBUG JeuNova</h2>

    <h3>0. Session</h3>
    <?php
    echo "<pre>" . print_r($_SESSION, true) . "</pre>";
    $id_user = $_SESSION['user_id'] ?? $_SESSION['id'] ?? $_SESSION['id_user'] ?? null;
    if ($id_user) {
        echo "<p class='ok'>✅ id_user trouvé : <b>$id_user</b></p>";
    } else {
        echo "<p class='err'>❌ Pas de user_id en session. Clés disponibles : " . implode(', ', array_keys($_SESSION)) . "</p>";
    }
    ?>

    <h3>0b. Fichier de config trouvé</h3>
    <?php
    if ($config_found) {
        echo "<p class='ok'>✅ $config_found</p>";
    } else {
        echo "<p class='err'>❌ Aucun fichier de config trouvé. Listage des fichiers disponibles :</p>";
        // Lister les fichiers du répertoire parent
        $parent = dirname(__DIR__);
        echo "<pre>";
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($parent, FilesystemIterator::SKIP_DOTS)) as $f) {
            if (strpos($f->getPathname(), 'config') !== false || strpos($f->getPathname(), 'db.php') !== false || strpos($f->getPathname(), 'connect') !== false) {
                echo $f->getPathname() . "\n";
            }
        }
        echo "</pre>";
    }

    if (!$pdo) {
        echo "<p class='err'>❌ \$pdo non disponible après inclusion. Vérifiez que le fichier de config définit \$pdo.</p>";
        die("</div></body></html>");
    } else {
        echo "<p class='ok'>✅ Connexion PDO OK</p>";
    }
    ?>

    <h3>1. Inscriptions de l'utilisateur</h3>
    <?php
    if ($id_user) {
        $s = $pdo->prepare("SELECT i.*, e.titre FROM Inscription i JOIN Evenement e ON i.id_event = e.id_event WHERE i.id_user = ?");
        $s->execute([$id_user]);
        $rows = $s->fetchAll(PDO::FETCH_ASSOC);
        if (empty($rows)) {
            echo "<p class='err'>❌ Aucune inscription pour id_user=$id_user</p>";
        } else {
            foreach ($rows as $r) {
                echo "<p class='ok'>✅ <b>{$r['titre']}</b> | statut: <b>[{$r['statut']}]</b> | id_event: {$r['id_event']}</p>";
            }
        }
    }
    ?>

    <h3>2. Feedbacks existants</h3>
    <?php
    if ($id_user) {
        $s = $pdo->prepare("SELECT * FROM Feedback WHERE id_user = ?");
        $s->execute([$id_user]);
        $rows = $s->fetchAll(PDO::FETCH_ASSOC);
        if (empty($rows)) {
            echo "<p>Aucun feedback.</p>";
        } else {
            foreach ($rows as $r) {
                echo "<p>id_event: {$r['id_event']} | note: {$r['note']}</p>";
            }
        }
    }
    ?>

    <h3>3. Table Participant</h3>
    <?php
    if ($id_user) {
        $s = $pdo->prepare("SELECT * FROM Participant WHERE id_user = ?");
        $s->execute([$id_user]);
        $p = $s->fetch(PDO::FETCH_ASSOC);
        if (!$p) {
            echo "<p class='err'>❌ Aucun enregistrement dans Participant pour id_user=$id_user</p>";
            // Essayer de trouver l'utilisateur autrement
            $s2 = $pdo->query("SELECT * FROM Participant LIMIT 5");
            echo "<p>Exemples de Participant :</p><pre>" . print_r($s2->fetchAll(PDO::FETCH_ASSOC), true) . "</pre>";
        } else {
            echo "<pre>" . print_r($p, true) . "</pre>";
        }
    }
    ?>

    <h3>4. Tous les événements</h3>
    <?php
    $s = $pdo->query("SELECT e.*, c.nom as cat FROM Evenement e LEFT JOIN Categorie c ON e.id_categorie = c.id_categorie");
    $rows = $s->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $r) {
        echo "<p>ID:{$r['id_event']} | <b>{$r['titre']}</b> | Date:{$r['date_debut']} | Cat:{$r['cat']}</p>";
    }
    ?>

    <h3>5. Structure Inscription</h3>
    <?php
    $s = $pdo->query("DESCRIBE Inscription");
    foreach ($s->fetchAll(PDO::FETCH_ASSOC) as $r) {
        echo "<p><b>{$r['Field']}</b> | {$r['Type']} | Default: {$r['Default']}</p>";
    }
    ?>

    <h3>6. Structure Participant</h3>
    <?php
    $s = $pdo->query("DESCRIBE Participant");
    foreach ($s->fetchAll(PDO::FETCH_ASSOC) as $r) {
        echo "<p><b>{$r['Field']}</b> | {$r['Type']}</p>";
    }
    ?>

</div>
</body>
</html>