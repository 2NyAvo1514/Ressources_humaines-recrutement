<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des annonces</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f6f8;
      margin: 0;
      padding: 20px;
    }
    h1 { text-align: center; }
    table {
      width: 80%;
      margin: 20px auto;
      border-collapse: collapse;
      background: #fff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: left;
    }
    th {
      background: #2c3e50;
      color: #fff;
    }
    tr:nth-child(even) {
      background: #f9f9f9;
    }
    .annonce-card {
      background: #fff;
      border-radius: 10px;
      padding: 15px;
      margin: 15px 0;
      box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    }
    .annonce-card h2 {
      margin-top: 0;
      color: #2c3e50;
    }
    .annonce-card ul {
      margin: 0;
      padding-left: 20px;
    }
    .note { font-size: 16px; color: #888; }
  </style>
</head>
<body>
  <h1>📢 Liste des annonces</h1>

<?php if (empty($annonces)): ?>
  <p>Aucune annonce disponible pour le moment.</p>
<?php else: ?>
  <?php foreach ($annonces as $a): ?>
    <div class="annonce-card">
      <h2><?= htmlspecialchars($a['nomPoste']) ?></h2>
      <p class="note"><?= htmlspecialchars($a['descriPoste']) ?></p>
      <p><strong>Âge :</strong> <?php if($a['ageMax']!=null){ echo $a['ageMin']." - ".  $a['ageMax'] . "ans";}else{ echo "au moins ". $a['ageMin'] ." ans" ;}?> </p>
      <p><strong>Sexe :</strong> <?= htmlspecialchars($a['sexe'] ?? 'Indifférent') ?></p>
      <p><strong>Expérience requise :</strong> <?= $a['experience'] ?? 'Non précisé' ?> an(s)</p>

      <?php if (!empty($a['diplomes'])): ?>
        <p><strong>Diplômes requis :</strong></p>
        <ul>
          <?php foreach ($a['diplomes'] as $d): ?>
            <li><?= htmlspecialchars($d['nomDegre'] . ' en ' . $d['nomDomaine']) ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <?php if (!empty($a['langues'])): ?>
        <p><strong>Langues requises :</strong></p>
        <ul>
          <?php foreach ($a['langues'] as $l): ?>
            <li><?= htmlspecialchars($l['langue']) ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
<?php endif; ?>
</body>
</html>
