<?php
require_once '../config/db.php';
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'responsable') {
    die("Accès refusé.");
}
$id = $_SESSION['user_id'];

$s = $pdo->prepare("SELECT COUNT(*) FROM Evenement WHERE id_responsable=?");
$s->execute([$id]); $totalEvents = $s->fetchColumn();

$s = $pdo->prepare("SELECT COUNT(DISTINCT i.id_user) FROM Inscription i JOIN Evenement e ON i.id_event=e.id_event WHERE e.id_responsable=? AND i.statut='confirmé'");
$s->execute([$id]); $totalParticipants = $s->fetchColumn();

$s = $pdo->prepare("SELECT COUNT(f.id_user) FROM Feedback f JOIN Evenement e ON f.id_event=e.id_event WHERE e.id_responsable=?");
$s->execute([$id]); $totalFeedbacks = $s->fetchColumn();

$s = $pdo->prepare("SELECT AVG(f.note) FROM Feedback f JOIN Evenement e ON f.id_event=e.id_event WHERE e.id_responsable=?");
$s->execute([$id]); $avgNote = $s->fetchColumn();
$satisfaction = $avgNote ? round(($avgNote/5)*100) : 0;

$s = $pdo->prepare("SELECT DATE_FORMAT(i.date_inscription,'%Y-%m') as mois, COUNT(*) as total
                    FROM Inscription i JOIN Evenement e ON i.id_event=e.id_event
                    WHERE e.id_responsable=? GROUP BY mois ORDER BY mois DESC LIMIT 6");
$s->execute([$id]);
$inscritsParMois = $s->fetchAll();
$mois   = array_reverse(array_column($inscritsParMois,'mois'));
$totaux = array_reverse(array_column($inscritsParMois,'total'));
$maxVal = max(array_merge($totaux,[1]));

$nom = htmlspecialchars(trim(($_SESSION['prenom']??'').' '.($_SESSION['nom']??'')));
$parts = preg_split('/\s+/',trim($nom));
$initials = strtoupper(implode('',array_filter(array_map(fn($p)=>$p?$p[0]:'', $parts))));
$initials = substr($initials,0,2);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Rapport Responsable — JeuNova</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
:root{
  --citrus:#FFA62B;--sea:#86C5FF;--blue:#2E5AA7;--cream:#F8E6A0;
  --g:linear-gradient(135deg,#2E5AA7 0%,#86C5FF 55%,#FFA62B 100%);
  --card:rgba(255,255,255,0.9);--border:rgba(46,90,167,0.16);
  --text:#1A2C3E;--dim:#4A6478;--muted:#7A9BB0;
  --r:14px;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{
  font-family:'DM Sans',system-ui,sans-serif;font-size:clamp(11px,1.2vw,13.5px);line-height:1.5;color:var(--text);
  background:linear-gradient(135deg,var(--cream) 0%,#fff 40%,var(--sea) 80%,var(--citrus) 100%) fixed;
  min-height:100vh;
  padding:clamp(16px,2.5vh,28px) clamp(16px,2.5vw,32px);
  animation:pr .4s ease both;
}
@keyframes pr{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:none}}
h1,h2,h3,h4{font-family:'Syne',sans-serif;font-weight:800;line-height:1.1;letter-spacing:-.02em;color:var(--blue);}
.wrap{width:100%;}

/* HEADER */
.hd{
  background:var(--g);border-radius:var(--r);padding:clamp(12px,2vh,20px) clamp(14px,2.5vw,28px);margin-bottom:clamp(8px,1.2vh,14px);
  position:relative;overflow:hidden;display:flex;align-items:center;justify-content:space-between;gap:12px;
}
.hd::before{
  content:'';position:absolute;inset:-30px;pointer-events:none;
  background-image:linear-gradient(rgba(255,255,255,.06)1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.06)1px,transparent 1px);
  background-size:38px 38px;animation:gm 18s linear infinite;
}
@keyframes gm{to{transform:translateY(38px)}}
.hd-inner{position:relative;z-index:1;display:flex;align-items:center;gap:16px;flex:1;min-width:0;}
.avatar{
  width:52px;height:52px;border-radius:50%;flex-shrink:0;
  background:rgba(255,255,255,.25);border:2px solid rgba(255,255,255,.4);
  display:flex;align-items:center;justify-content:center;
  font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:800;color:#fff;
  backdrop-filter:blur(6px);
}
.badge{
  display:inline-flex;align-items:center;gap:5px;
  background:rgba(255,255,255,.2);border:1px solid rgba(255,255,255,.35);
  border-radius:99px;padding:2px 10px;font-size:10px;font-weight:600;
  letter-spacing:.08em;text-transform:uppercase;color:#fff;margin-bottom:5px;
}
.hd h1{color:#fff;font-size:clamp(1.1rem,2.5vw,1.6rem);}
.hd .meta{color:rgba(255,255,255,.75);font-size:11px;margin-top:3px;}
.btn-p{
  position:relative;z-index:1;flex-shrink:0;
  display:inline-flex;align-items:center;gap:5px;
  background:rgba(255,255,255,.2);border:1.5px solid rgba(255,255,255,.4);
  color:#fff;border-radius:99px;padding:7px 16px;
  font-family:'DM Sans',sans-serif;font-size:11px;font-weight:600;
  letter-spacing:.06em;text-transform:uppercase;cursor:pointer;
  transition:all .25s cubic-bezier(.34,1.56,.64,1);
}
.btn-p:hover{background:rgba(255,255,255,.32);transform:scale(1.05) translateY(-2px);}
@media print{.btn-p{display:none}}

/* STATS — 4 cards en ligne */
.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:clamp(6px,1vw,10px);margin-bottom:clamp(8px,1.2vh,12px);}
.sc{
  background:var(--card);border:1px solid var(--border);border-radius:var(--r);
  padding:clamp(8px,1.2vh,13px) clamp(10px,1.2vw,15px);display:flex;align-items:center;gap:clamp(8px,1vw,13px);
  position:relative;overflow:hidden;
  transition:transform .28s cubic-bezier(.34,1.56,.64,1),box-shadow .28s;cursor:default;
}
.sc::before{content:'';position:absolute;left:0;top:10%;bottom:10%;width:2.5px;background:var(--g);border-radius:99px;transform:scaleY(0);transform-origin:bottom;transition:transform .3s cubic-bezier(.34,1.56,.64,1);}
.sc:hover{transform:translateY(-6px) scale(1.015);box-shadow:0 12px 28px rgba(46,90,167,.12),0 0 30px rgba(255,166,43,.07);}
.sc:hover::before{transform:scaleY(1);}
.sc-icon-box{
  width:42px;height:42px;border-radius:12px;flex-shrink:0;
  background:rgba(46,90,167,.07);border:1px solid rgba(46,90,167,.12);
  display:flex;align-items:center;justify-content:center;
  font-size:1.1rem;color:var(--sea);
  filter:drop-shadow(0 0 5px rgba(46,90,167,.2));
  transition:transform .3s cubic-bezier(.34,1.56,.64,1);
}
.sc:hover .sc-icon-box{transform:scale(1.1) rotate(-5deg);}
.sc-info{flex:1;min-width:0;}
.sc-num{
  display:block;font-family:'Syne',sans-serif;font-size:clamp(1.2rem,2.5vw,1.7rem);font-weight:800;
  letter-spacing:-.04em;line-height:1;margin-bottom:2px;
  background:var(--g);background-clip:text;-webkit-background-clip:text;color:transparent;
}
.sc-lbl{font-size:10.5px;font-weight:500;color:var(--muted);}

/* SECTION LABEL */
.slbl{
  font-size:9.5px;font-weight:700;letter-spacing:.15em;text-transform:uppercase;
  background:var(--g);background-clip:text;-webkit-background-clip:text;color:transparent;
  margin:10px 0 7px;display:flex;align-items:center;gap:7px;
}
.slbl::after{content:'';flex:1;height:1px;background:linear-gradient(90deg,rgba(46,90,167,.22),transparent);}

/* TWO-COL */
.cols{display:grid;grid-template-columns:1fr 1fr;gap:clamp(7px,1vw,11px);}
.col-stack{display:flex;flex-direction:column;gap:clamp(7px,1vw,11px);}

/* CARD */
.card{background:var(--card);border:1px solid var(--border);border-radius:var(--r);overflow:hidden;}
.ch{background:var(--g);padding:clamp(7px,1vh,10px) clamp(12px,1.5vw,18px);display:flex;align-items:center;gap:7px;}
.ch h3{color:#fff;font-family:'DM Sans',sans-serif;font-size:clamp(.68rem,1.1vw,.78rem);font-weight:600;letter-spacing:.04em;}
.ch .bi{color:#fff;font-size:.9rem;}
.cb{padding:clamp(10px,1.5vh,15px) clamp(12px,1.5vw,18px);}

/* TABLE */
table{width:100%;border-collapse:collapse;}
th{font-size:10px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:var(--blue);padding:7px 0 6px;text-align:left;border-bottom:1px solid rgba(46,90,167,.1);}
td{padding:6px 0;font-size:12px;color:var(--dim);border-bottom:1px solid rgba(46,90,167,.05);}
tbody tr:last-child td{border-bottom:none;}
tbody tr:hover td{background:rgba(46,90,167,.025);}
.num{font-family:'Syne',sans-serif;font-weight:800;font-size:12.5px;color:var(--blue);}

/* BAR CHART */
.br{display:flex;align-items:center;gap:9px;margin-bottom:7px;}
.br:last-child{margin-bottom:0;}
.bm{font-size:10.5px;font-weight:600;color:var(--muted);width:54px;flex-shrink:0;}
.bt{flex:1;height:7px;background:rgba(46,90,167,.07);border-radius:99px;overflow:hidden;}
.bf{height:100%;background:var(--g);border-radius:99px;transform-origin:left;animation:bG .65s cubic-bezier(.34,1.56,.64,1) both;}
@keyframes bG{from{transform:scaleX(0)}to{transform:scaleX(1)}}
.bv{font-family:'Syne',sans-serif;font-size:10.5px;font-weight:700;color:var(--blue);width:22px;text-align:right;flex-shrink:0;}

/* SAT */
.sr{display:flex;align-items:center;gap:9px;}
.sl{font-size:10.5px;color:var(--muted);width:84px;flex-shrink:0;}
.st{flex:1;height:9px;background:rgba(46,90,167,.07);border-radius:99px;overflow:hidden;}
.sf{height:100%;background:var(--g);border-radius:99px;animation:bG .9s cubic-bezier(.34,1.56,.64,1) .15s both;}
.sp{font-family:'Syne',sans-serif;font-weight:800;font-size:.95rem;background:var(--g);background-clip:text;-webkit-background-clip:text;color:transparent;width:38px;text-align:right;}

@media(max-width:680px){
  .stats{grid-template-columns:1fr 1fr;}
  .cols{grid-template-columns:1fr;}
  .avatar{display:none;}
}
@media print{
  body{background:#fff;padding:8px;animation:none;}
  .hd,.ch{-webkit-print-color-adjust:exact;print-color-adjust:exact;}
  .sc-num,.bf,.sf,.slbl{-webkit-print-color-adjust:exact;print-color-adjust:exact;}
  .sc,.card{box-shadow:none;border-color:#ddd;}
}
</style>
</head>
<body>
<div class="wrap">

  <div class="hd">
    <div class="hd-inner">
      <div class="avatar"><?= $initials ?></div>
      <div>
        <div class="badge"><i class="bi bi-person-badge"></i> Responsable</div>
        <h1>Rapport responsable</h1>
        <p class="meta">
          <i class="bi bi-person"></i> <?= $nom ?>
          &nbsp;·&nbsp;
          <i class="bi bi-calendar3"></i> <?= date('d/m/Y à H:i') ?>
        </p>
      </div>
    </div>
    <button class="btn-p" onclick="window.print()"><i class="bi bi-file-earmark-pdf"></i> PDF</button>
  </div>

  <div class="slbl"><i class="bi bi-bar-chart-line"></i> Mes statistiques</div>
  <div class="stats">
    <div class="sc">
      <div class="sc-icon-box"><i class="bi bi-calendar-event"></i></div>
      <div class="sc-info"><span class="sc-num"><?= $totalEvents ?></span><span class="sc-lbl">Événements créés</span></div>
    </div>
    <div class="sc">
      <div class="sc-icon-box"><i class="bi bi-people"></i></div>
      <div class="sc-info"><span class="sc-num"><?= $totalParticipants ?></span><span class="sc-lbl">Participants inscrits</span></div>
    </div>
    <div class="sc">
      <div class="sc-icon-box"><i class="bi bi-chat-square-text"></i></div>
      <div class="sc-info"><span class="sc-num"><?= $totalFeedbacks ?></span><span class="sc-lbl">Feedbacks reçus</span></div>
    </div>
    <div class="sc">
      <div class="sc-icon-box"><i class="bi bi-star"></i></div>
      <div class="sc-info"><span class="sc-num"><?= $satisfaction ?>%</span><span class="sc-lbl">Satisfaction</span></div>
    </div>
  </div>

  <div class="slbl"><i class="bi bi-graph-up"></i> Évolution des inscriptions — 6 derniers mois</div>
  <div class="cols">

    <div class="card">
      <div class="ch"><i class="bi bi-table"></i><h3>Tableau mensuel</h3></div>
      <div class="cb">
        <table>
          <thead><tr><th>Mois</th><th>Inscriptions</th></tr></thead>
          <tbody>
            <?php for($i=0;$i<count($mois);$i++): ?>
            <tr><td><?= htmlspecialchars($mois[$i]) ?></td><td><span class="num"><?= $totaux[$i] ?></span></td></tr>
            <?php endfor; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="col-stack">
      <div class="card">
        <div class="ch"><i class="bi bi-bar-chart"></i><h3>Graphique inscriptions</h3></div>
        <div class="cb">
          <?php foreach($mois as $k=>$m): ?>
          <div class="br">
            <span class="bm"><?= htmlspecialchars($m) ?></span>
            <div class="bt"><div class="bf" style="width:<?= round(($totaux[$k]/$maxVal)*100) ?>%;animation-delay:<?= $k*.07 ?>s"></div></div>
            <span class="bv"><?= $totaux[$k] ?></span>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="card">
        <div class="ch"><i class="bi bi-emoji-smile"></i><h3>Satisfaction globale</h3></div>
        <div class="cb">
          <div class="sr">
            <span class="sl">Note moyenne</span>
            <div class="st"><div class="sf" style="width:<?= $satisfaction ?>%"></div></div>
            <span class="sp"><?= $satisfaction ?>%</span>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
</body>
</html>