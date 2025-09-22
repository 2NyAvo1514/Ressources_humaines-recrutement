<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Recherche de candidats</title>
  <style>
    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: #f9fafc;
      margin: 0;
      padding: 0;
      color: #333;
    }

    header {
      background: #2c3e50;
      color: #fff;
      padding: 20px;
      text-align: center;
    }

    h1 {
      margin: 0;
      font-size: 24px;
      letter-spacing: 1px;
    }

    .container {
      width: 90%;
      max-width: 1200px;
      margin: 30px auto;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    form {
      margin-bottom: 20px;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      text-align: left;
    }

    th, td {
      border-bottom: 1px solid #ddd;
      padding: 12px;
      vertical-align: middle;
    }

    th {
      background: #f4f6f9;
      font-weight: bold;
      color: #2c3e50;
      position: sticky;
      top: 0;
      z-index: 2;
    }

    tr:hover {
      background: #f9f9f9;
    }

    input[type="text"] {
      width: 95%;
      padding: 6px 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
    }

    button {
      background: #3498db;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 4px;
      font-size: 14px;
      cursor: pointer;
      margin-top: 10px;
      transition: background 0.3s ease;
    }

    button:hover {
      background: #2980b9;
    }

    .no-result {
      text-align: center;
      padding: 20px;
      color: #999;
    }

    /* Responsive */
    @media (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }
      th {
        display: none;
      }
      td {
        border: none;
        padding: 10px;
        border-bottom: 1px solid #eee;
      }
      td:before {
        content: attr(data-label);
        font-weight: bold;
        display: block;
        margin-bottom: 4px;
        color: #2c3e50;
      }
    }
  </style>
</head>
<body>

<header>
  <h1>Recherche de candidats</h1>
</header>

<div class="container">
  <h4>Recherche global </h4>
  <form action="<?= Flight::get('flight.base_url') ?>/recherche/general" method="get">
    <input type="text" name="general">
    <button type="submit">🔍 Rechercher</button>
  </form>
  <h4>Recherche par colonne</h4>
  <form method="get" action="<?= Flight::get('flight.base_url') ?>/recherche">
    <button type="submit">🔍 Rechercher</button><br><br>
    <table style="overflow-y: scroll;display:block;height:400px">
      <thead>
        <tr>
          <th>Nom<br><input type="text" name="nom" value="<?= htmlspecialchars($criteres['nom']) ?>"></th>
          <th>Prénom<br><input type="text" name="prenom" value="<?= htmlspecialchars($criteres['prenom']) ?>"></th>
          <th>Diplômes<br><input type="text" name="diplome" value="<?= htmlspecialchars($criteres['diplome']) ?>"></th>
          <th>Domaine<br><input type="text" name="domaine" value="<?= htmlspecialchars($criteres['domaine']) ?>"></th>
          <th>Statut<br><input type="text" name="status" value="<?= htmlspecialchars($criteres['status']) ?>"></th>
          <th>Poste<br><input type="text" name="poste" value="<?= htmlspecialchars($criteres['poste']) ?>"></th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($candidats)): ?>
          <?php foreach ($candidats as $cand): ?>
            <tr>
              <td data-label="Nom"><?= htmlspecialchars($cand['nom']) ?></td>
              <td data-label="Prénom"><?= htmlspecialchars($cand['prenom']) ?></td>
              <td data-label="Diplômes"><?= htmlspecialchars($cand['diplomes'] ?? '-') ?></td>
              <td data-label="Domaine"><?= htmlspecialchars($cand['domaine'] ?? '-') ?></td>
              <td data-label="Statut"><?= htmlspecialchars($cand['nomStatus'] ?? '-') ?></td>
              <td data-label="Poste"><?= htmlspecialchars($cand['nomPoste'] ?? '-') ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="6" class="no-result">Aucun candidat trouvé.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </form>
</div>

</body>
</html>
