<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php if (!empty($tri)) : ?>
        <table>
            <tr>
                <th>ID Candidat</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Total Score</th>
                <th>Poste</th>
                <th>Statut</th>
            </tr>
            <?php foreach ($tri as $r) : ?>
            <tr>
                <td><?= $r['idCandidat'] ?></td>
                <td><?= $r['nom'] ?></td>
                <td><?= $r['prenom'] ?></td>
                <td><?= $r['totalScore'] ?></td>
                <td><?= $r['poste'] ?? 'Non défini' ?></td>
                <td><?= $r['statut'] ?? 'Non défini' ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST") : ?>
        <p>Aucun résultat trouvé.</p>
    <?php endif; ?>
    <a href="formtri">Retour au formulaire</a>
</body>
</html>