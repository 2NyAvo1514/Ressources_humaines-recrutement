<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style1.css">
    <title>Document</title>
</head>
<body>
    <h2>Tri des CV</h2>
    <form action="tri" method="post">
        
        <label for="poste">Poste</label>
        <input list="postes" name="poste" id="poste">

        <datalist id="postes">
            <?php foreach ($poste as $d) : ?>
                <option value="<?= $d['nomPoste'] ?>" data-id="<?= $d['idPoste'] ?>"></option>
            <?php endforeach; ?>
        </datalist>

        <br>

        <label for="domaine">Domaine</label>
        <select name="domaine" id="domaine">
            <option value="">veuiller choisir</option>
            <?php foreach ($domaine as $d) : ?>
                <option value="<?=$d['idDomaine']?>"><?= $d['nomDomaine'] ?></option>
            <?php endforeach; ?>
        </select>

        <br>

        <label for="statut">Statut</label>
        <select name="statut" id="statut">
            <option value="">veuiller choisir</option>
            <?php foreach ($status as $statut) : ?>
                <option value="<?=$statut['idStatus']?>"><?= $statut['nomStatus'] ?></option>
            <?php endforeach; ?>
        </select>

        <br>

        <label for="modetri">Mode de tri par rapport au score</label>      
        <select name="modetri" id="modetri">
            <option value="">veuiller choisir</option>
            <option value="1">Ascendant</option>
            <option value="2">Descendant</option>
        </select>
        
        <input type="submit" value="rechercher">
    </form>

    <script>
        $(document).ready(function() {
            $('#poste').select2({
                placeholder: "Veuillez choisir un poste",
                allowClear: true
            });
        });
    </script>
</body>
</html>