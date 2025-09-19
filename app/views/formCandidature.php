<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="candidater">
        <label for="domaine">domaine</label>
        <select name="domaine" id="domaine">
            <option value="" disabled>Veuiller choisir</option>
            <?php foreach ($postes as $poste) : ?>
                <option value="<?=$poste['idPoste']?>"><?= $poste['nomPoste'] ?></option>
            <?php endforeach; ?>
        </select>
    </form>
</body>
</html>