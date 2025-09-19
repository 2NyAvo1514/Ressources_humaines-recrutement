<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats des Candidats</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        .btn {
            background-color: #2196F3;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background-color: #1976D2;
        }
        
        .no-results {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 40px;
        }
        
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #FF9800;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        .back-link:hover {
            background-color: #F57C00;
        }
        
        .score {
            font-weight: bold;
            color: #4CAF50;
        }
        
        .status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .status.active {
            background-color: #4CAF50;
            color: white;
        }
        
        .status.pending {
            background-color: #FF9800;
            color: white;
        }
        
        .status.rejected {
            background-color: #F44336;
            color: white;
        }
        
        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }
            
            th, td {
                padding: 8px;
            }
            
            .btn {
                padding: 6px 12px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Résultats des Candidats</h1>
        
        <?php if (!empty($result)) : ?>
            <table>
                <tr>
                    <th>ID Candidat</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Total Score</th>
                    <th>Poste</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($result as $c) : ?>
                    <tr>
                        <td><?= htmlspecialchars($c['idCandidat']) ?></td>
                        <td><?= htmlspecialchars($c['nom']) ?></td>
                        <td><?= htmlspecialchars($c['prenom']) ?></td>
                        <td class="score"><?= htmlspecialchars($c['totalScore']) ?></td>
                        <td><?= htmlspecialchars($c['nomPoste'] ?? '-') ?></td>
                        <td>
                            <span class="status <?= strtolower($c['nomStatus'] ?? 'pending') ?>">
                                <?= htmlspecialchars($c['nomStatus'] ?? '-') ?>
                            </span>
                        </td>
                        <td>
                            <form action="detail" method="get" style="margin: 0;">
                                <input type="hidden" name="idStatut" value="<?= htmlspecialchars($c['idStatus'] ?? '') ?>">
                                <input type="hidden" name="idCandidat" value="<?= htmlspecialchars($c['idCandidat']) ?>">
                                <input type="submit" value="Voir plus" class="btn">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "GET") : ?>
            <div class="no-results">
                <p>Aucun résultat trouvé.</p>
            </div>
        <?php endif; ?>
        
        <a href="formEntretien" class="back-link">Retour au paramètre de choix</a>
    </div>
</body>
</html>