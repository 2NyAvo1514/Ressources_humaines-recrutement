<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="insertScore">
        <label for="scoreEntretien">Note de l'entretien</label>
        <input type="hidden" name="idCandidat" value="<?= $candidat ?>"><?= $candidat ?>
        <input type="number" name="scoreEntretien" id="scoreEntretien">
        <input type="submit" value="valider">
    </form>
</body>
</html>