<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Créer une annonce</title>
  <style>
    body { font-family: "Segoe UI", sans-serif; background: #f5f7fa; margin: 0; padding: 0; }
    header { background: #34495e; color: #fff; text-align: center; padding: 20px; }
    .container { width: 90%; max-width: 700px; margin: 30px auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    form { display: flex; flex-direction: column; gap: 18px; }
    label { font-weight: bold; margin-bottom: 6px; display: block; color: #2c3e50; }
    select { width: 100%; padding: 10px; font-size: 14px; border: 1px solid #ccc; border-radius: 5px; }
    input, textarea { width: 97%; padding: 10px; font-size: 14px; border: 1px solid #ccc; border-radius: 5px; }
    textarea { min-height: 100px; resize: vertical; }
    button { background: #27ae60; color: #fff; border: none; padding: 12px 20px; font-size: 15px; border-radius: 6px; cursor: pointer; transition: background 0.3s ease; }
    button:hover { background: #219150; }
    .note { font-size: 12px; color: #888; }
  </style>
</head>
<body>

<header>
  <h1>Créer une nouvelle annonce</h1>
</header>

<div class="container">
  <form action="ajouter" method="post">

    <div>
      <label for="poste">Poste *</label>
      <select id="poste" name="poste" required>
        <optgroup label="Poste">
          <?php foreach ($poste as $d): ?>
            <option value="<?= $d['idPoste'] ?>"><?= htmlspecialchars($d['nomPoste']) ?></option>
          <?php endforeach; ?>
        </optgroup>
      </select>
    </div>

    <!-- <div>
      <label for="description">Description *</label>
      <textarea id="description" name="description" ></textarea>
    </div> -->
    
    <div>
      <label for="sexe">Sexe *</label>
      <select id="sexe" name="sexe" required>
        <optgroup label="sexe">
          <?php foreach ($sexe as $d): ?>
            <option value="<?= $d['idSexe'] ?>"><?= htmlspecialchars($d['genre']) ?></option>
          <?php endforeach; ?>
        </optgroup>
      </select>
    </div>

     <div>
      <label for="domaine">Domaine *</label>
      <select id="domaine" name="domaine" required>
        <optgroup label="Domaine">
          <!-- <option value="values" disabled>-- S&eacute;l&eacute;ctionner un (1) --</option> --> 
          <?php foreach ($domaine as $d): ?>
            <option value="<?= $d['idDomaine'] ?>"><?= htmlspecialchars($d['nomDomaine']) ?></option>
          <?php endforeach; ?>
        </optgroup>
      </select>
    </div>

    <div>
      <label for="degre">Diplome requis *</label>
      <select id="degre" name="degre" required>
        <optgroup label="Diplome">
          <?php foreach ($degre as $g): ?>
            <option value="<?= $g['idDegre'] ?>"><?= htmlspecialchars($g['nomDegre']) ?></option>
          <?php endforeach; ?>
        </optgroup>        
      </select>
    </div> 

	<div>
      <label for="langue">Langue(s) requise(s) *</label>
      <select id="langue" name="langue[]" multiple required>
        <optgroup label="langue">
          <?php foreach ($langue as $g): ?>
            <option value="<?= $g['idLangue'] ?>"><?= htmlspecialchars($g['langue']) ?></option>
          <?php endforeach; ?>
        </optgroup>        
      </select>
    </div> 

	<div>
      <label for="experience"> Ann&eacute;es d'Experience  *</label>
      <select id="experience" name="experience" required>
        <optgroup label="Nombre d'ann&eacute;es">
          <?php foreach ($experience as $g): ?>
            <option value="<?= $g['idExperience'] ?>"><?= htmlspecialchars($g['duree']) ?></option>
          <?php endforeach; ?>
        </optgroup>        
      </select>
    </div>

    <!-- <div>
      <label for="salaire">Salaire (€)</label>
      <input type="number" id="salaire" name="salaire">
    </div> -->

    <div>
      <label for="min,max">Age requis *(au moins min)</label>
      Min: <input type="number" id="min" name="min" required>
	  Max: <input type="number" id="max" name="max" >
    </div>

    <div>
      <label for="lieu">Lieu </label>
      <input type="text" id="lieu" name="lieu" >
    </div>

    <div>
      <label for="date_limite">Date limite</label>
      <input type="date" id="date_limite" name="date_limite">
    </div>

    <p class="note">* Champs obligatoires</p>
    <button type="submit">📢 Publier l'annonce</button>
  </form>
</div>

</body>
</html>
