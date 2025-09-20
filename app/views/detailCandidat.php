<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Candidat</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            line-height: 1.6;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
        }

        .header::before {
            content: '👤';
            font-size: 60px;
            display: block;
            margin-bottom: 15px;
        }

        .header h1 {
            color: #333;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            text-transform: capitalize;
        }

        .header .subtitle {
            color: #666;
            font-size: 16px;
            font-weight: 500;
        }

        .candidate-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }

        .card-header h2 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .card-header .score-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            margin-top: 10px;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 0;
        }

        .detail-item {
            display: flex;
            padding: 18px 25px;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.3s ease;
        }

        .detail-item:hover {
            background-color: #f8f9ff;
        }

        .detail-item:nth-child(even) {
            background-color: #fafbff;
        }

        .detail-label {
            font-weight: 600;
            color: #333;
            min-width: 140px;
            display: flex;
            align-items: center;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-value {
            flex: 1;
            color: #555;
            font-size: 15px;
            display: flex;
            align-items: center;
        }

        .detail-value.empty {
            color: #999;
            font-style: italic;
        }

        /* Icônes pour les différents types de données */
        .detail-label::before {
            content: '';
            width: 20px;
            height: 20px;
            margin-right: 10px;
            background-size: contain;
            display: inline-block;
        }

        .detail-item[data-type="personal"] .detail-label::before {
            content: '🆔';
        }

        .detail-item[data-type="contact"] .detail-label::before {
            content: '📧';
        }

        .detail-item[data-type="phone"] .detail-label::before {
            content: '📱';
        }

        .detail-item[data-type="address"] .detail-label::before {
            content: '🏠';
        }

        .detail-item[data-type="date"] .detail-label::before {
            content: '📅';
        }

        .detail-item[data-type="experience"] .detail-label::before {
            content: '💼';
        }

        .detail-item[data-type="education"] .detail-label::before {
            content: '🎓';
        }

        .detail-item[data-type="language"] .detail-label::before {
            content: '🌐';
        }

        .detail-item[data-type="score"] .detail-label::before {
            content: '📊';
        }

        .score-section {
            background: linear-gradient(135deg, #f8f9ff 0%, #e8edff 100%);
            padding: 25px;
            border-radius: 15px;
            margin: 30px 0;
        }

        .score-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .score-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .score-card:hover {
            transform: translateY(-5px);
        }

        .score-card .score-title {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .score-card .score-value {
            font-size: 28px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }

        .score-card.total .score-value {
            color: #4CAF50;
            font-size: 32px;
        }

        /* Section des actions */
        .actions-section {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin: 40px 0;
            flex-wrap: wrap;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-accept {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
        }

        .btn-accept:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(76, 175, 80, 0.4);
        }

        .btn-reject {
            background: linear-gradient(135deg, #f44336 0%, #da190b 100%);
            color: white;
        }

        .btn-reject:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(244, 67, 54, 0.4);
        }

        .btn-back {
            background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }

        .btn-back:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(255, 152, 0, 0.4);
        }

        /* Popup moderne */
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 1000;
            backdrop-filter: blur(5px);
        }

        .popup-box {
            background: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            animation: popupSlide 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
        }

        .popup-box::before {
            content: '⚠️';
            font-size: 48px;
            display: block;
            margin-bottom: 20px;
        }

        .popup-box h3 {
            color: #333;
            font-size: 22px;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .popup-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
        }

        .btn-cancel:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .btn-confirm {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
        }

        .btn-confirm:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(220, 53, 69, 0.4);
        }

        @keyframes popupSlide {
            from {
                opacity: 0;
                transform: scale(0.5) translateY(-50px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* États vides */
        .no-candidate {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .no-candidate::before {
            content: '👥';
            font-size: 80px;
            display: block;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .no-candidate h2 {
            color: #333;
            margin-bottom: 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin: 10px;
            }

            .header h1 {
                font-size: 24px;
            }

            .details-grid {
                grid-template-columns: 1fr;
            }

            .detail-item {
                flex-direction: column;
                gap: 8px;
            }

            .detail-label {
                min-width: auto;
                font-size: 12px;
            }

            .actions-section {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
            }

            .popup-box {
                padding: 30px 20px;
            }

            .popup-buttons {
                flex-direction: column;
                gap: 10px;
            }

            .popup-buttons .btn {
                width: 100%;
            }
        }

        /* Animation d'entrée */
        .container {
            animation: slideInUp 0.6s ease-out;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <?php if (!empty($candidat)) : ?>
        <div class="container">
            <div class="header">
                <h1><?= htmlspecialchars($candidat['nom'] . ' ' . $candidat['prenom']) ?></h1>
                <div class="subtitle">Profil détaillé du candidat</div>
            </div>

            <div class="candidate-card">
                <div class="card-header">
                    <h2><?= htmlspecialchars($candidat['nomPoste'] ?? 'Poste non spécifié') ?></h2>
                    <div class="score-badge">Score Total: <?= htmlspecialchars($candidat['totalScore'] ?? 0) ?></div>
                </div>

                <div class="details-grid">
                    <div class="detail-item" data-type="personal">
                        <div class="detail-label">ID Candidat</div>
                        <div class="detail-value"><?= htmlspecialchars($candidat['idCandidat']) ?></div>
                    </div>

                    <div class="detail-item" data-type="personal">
                        <div class="detail-label">Nom</div>
                        <div class="detail-value"><?= htmlspecialchars($candidat['nom']) ?></div>
                    </div>

                    <div class="detail-item" data-type="personal">
                        <div class="detail-label">Prénom</div>
                        <div class="detail-value"><?= htmlspecialchars($candidat['prenom']) ?></div>
                    </div>

                    <div class="detail-item" data-type="personal">
                        <div class="detail-label">Sexe</div>
                        <div class="detail-value"><?= htmlspecialchars($candidat['sexe']) ?></div>
                    </div>

                    <div class="detail-item" data-type="date">
                        <div class="detail-label">Date de naissance</div>
                        <div class="detail-value"><?= htmlspecialchars($candidat['dateNaissance']) ?></div>
                    </div>

                    <div class="detail-item" data-type="address">
                        <div class="detail-label">Adresse</div>
                        <div class="detail-value"><?= htmlspecialchars($candidat['adresse']) ?></div>
                    </div>

                    <div class="detail-item" data-type="contact">
                        <div class="detail-label">Email</div>
                        <div class="detail-value"><?= htmlspecialchars($candidat['mail']) ?></div>
                    </div>

                    <div class="detail-item" data-type="phone">
                        <div class="detail-label">Contact</div>
                        <div class="detail-value"><?= htmlspecialchars($candidat['contact']) ?></div>
                    </div>

                    <div class="detail-item" data-type="experience">
                        <div class="detail-label">Expérience</div>
                        <div class="detail-value"><?= htmlspecialchars($candidat['experience']) ?> année(s)</div>
                    </div>

                    <div class="detail-item" data-type="language">
                        <div class="detail-label">Langues</div>
                        <div class="detail-value <?= empty($candidat['langues']) ? 'empty' : '' ?>">
                            <?= htmlspecialchars($candidat['langues'] ?? 'Non spécifié') ?>
                        </div>
                    </div>

                    <div class="detail-item" data-type="education">
                        <div class="detail-label">Diplômes</div>
                        <div class="detail-value <?= empty($candidat['diplomes']) ? 'empty' : '' ?>">
                            <?= htmlspecialchars($candidat['diplomes'] ?? 'Non spécifié') ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="score-section">
                <div class="score-grid">
                    <div class="score-card">
                        <div class="score-title">Score Test</div>
                        <div class="score-value"><?= htmlspecialchars($candidat['scoreTest'] ?? 0) ?></div>
                        <div style="font-size: 12px; color: #999;">sur 100</div>
                    </div>
                    <div class="score-card">
                        <div class="score-title">Score Entretien</div>
                        <div class="score-value"><?= htmlspecialchars($candidat['scoreEntretien'] ?? 0) ?></div>
                        <div style="font-size: 12px; color: #999;">sur 100</div>
                    </div>
                    <div class="score-card total">
                        <div class="score-title">Score Total</div>
                        <div class="score-value"><?= htmlspecialchars($candidat['totalScore'] ?? 0) ?></div>
                        <div style="font-size: 12px; color: #999;">sur 200</div>
                    </div>
                </div>
            </div>

            <div class="actions-section">
                <?php if ($candidat['idStatus'] == 6): ?>
                    <form action="restaurer" method="get" style="display: inline;">
                        <input type="hidden" name="idCandidat" value="<?= $candidat['idCandidat'] ?>">
                        <button type="submit" class="btn btn-accept">Restaurer</button>
                    </form>
                <?php else: ?>
                    <form action="<?= Flight::get('flight.base_url') ?>/changeStatut" method="get" style="display: inline;">
                        <input type="hidden" name="idCandidat" value="<?= htmlspecialchars($candidat['idCandidat']) ?>">
                        <button type="submit" name="statut" value="1" class="btn btn-accept">
                            ✓ Accepter le candidat
                        </button>
                    </form>

                    <form action="<?= Flight::get('flight.base_url') ?>/changeStatut" method="get" id="statutForm" style="display: inline;">
                        <input type="hidden" name="idCandidat" value="<?= htmlspecialchars($candidat['idCandidat']) ?>">
                        <input type="hidden" name="statut" id="hiddenStatut">
                        <button type="button" onclick="ouvrirPopup()" class="btn btn-reject">
                            ✗ Rejeter le candidat
                        </button>
                    </form>
                <?php endif; ?>
            </div>

            <div style="text-align: center;">
                <a href="formEntretien" class="btn btn-back">
                    ← Retour à la liste des candidats
                </a>
            </div>
        </div>

        <!-- Popup de confirmation -->
        <div class="popup-overlay" id="popup">
            <div class="popup-box">
                <h3>Confirmer le rejet</h3>
                <p style="color: #666; margin-bottom: 20px;">
                    Êtes-vous sûr de vouloir rejeter ce candidat ? Cette action est irréversible.
                </p>
                <div class="popup-buttons">
                    <button class="btn btn-cancel" onclick="fermerPopup()">Annuler</button>
                    <button class="btn btn-confirm" onclick="confirmerRejet()">Oui, rejeter</button>
                </div>
            </div>
        </div>

    <?php else : ?>
        <div class="container">
            <div class="no-candidate">
                <h2>Aucun candidat trouvé</h2>
                <p>Le candidat demandé n'existe pas ou n'est plus disponible.</p>
                <a href="formEntretien" class="btn btn-back" style="margin-top: 30px;">
                    ← Retour à la liste
                </a>
            </div>
        </div>
    <?php endif; ?>

    <script>
        function ouvrirPopup() {
            document.getElementById("popup").style.display = "flex";
            document.body.style.overflow = "hidden"; 
        }

        function fermerPopup() {
            document.getElementById("popup").style.display = "none";
            document.body.style.overflow = "auto";
        }

        function confirmerRejet() {
            document.getElementById("hiddenStatut").value = 0;
            document.getElementById("statutForm").submit();
        }

        // Fermer le popup en cliquant à l'extérieur
        document.getElementById("popup").addEventListener("click", function(e) {
            if (e.target === this) {
                fermerPopup();
            }
        });

        // Fermer avec la touche Échap
        document.addEventListener("keydown", function(e) {
            if (e.key === "Escape") {
                fermerPopup();
            }
        });

        // Animation au chargement
        document.addEventListener("DOMContentLoaded", function() {
            const details = document.querySelectorAll('.detail-item');
            details.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateX(-20px)';
                setTimeout(() => {
                    item.style.transition = 'all 0.3s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateX(0)';
                }, index * 50);
            });
        });
    </script>
</body>
</html>