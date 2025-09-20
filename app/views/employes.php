<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des employés</title>
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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        form {
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            text-align: left;
        }

        th,
        td {
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

            table,
            thead,
            tbody,
            th,
            td,
            tr {
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
        <h1>Employés actifs</h1>
    </header>
    <div class="container">
        <!-- <form action="detail" method="get"> -->
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Poste</th>
                    <th>Date d'embauche</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employes as $e): ?>
                    <input type="hidden" name="<?= $e['idEmploye'] ;?>">
                    <tr>
                        <td><?= htmlspecialchars($e['nom']) ?></td>
                        <td><?= htmlspecialchars($e['prenom']) ?></td>
                        <td><?= htmlspecialchars($e['mail']) ?></td>
                        <td><?= htmlspecialchars($e['contact']) ?></td>
                        <td><?= htmlspecialchars($e['nomPoste'] ?? '-') ?></td>
                        <td><?= !empty($e['dateEmbauche']) ? date('d/m/Y', strtotime($e['dateEmbauche'])) : '-' ?></td>
                        <td><button type="submit">Voir</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- </form> -->
    </div>
</body>

</html>