<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtrage des Candidats</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-header h1 {
            color: #333;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-header p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .select-wrapper {
            position: relative;
            display: block;
        }

        .select-wrapper::after {
            content: '▼';
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #667eea;
            font-size: 12px;
        }

        select {
            width: 100%;
            padding: 15px 40px 15px 20px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            background: white;
            font-size: 16px;
            color: #333;
            appearance: none;
            cursor: pointer;
            transition: all 0.3s ease;
            outline: none;
        }

        select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        select:hover {
            border-color: #667eea;
        }

        option {
            padding: 10px;
            background: white;
            color: #333;
        }

        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 18px;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            position: relative;
            overflow: hidden;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }

        .submit-btn:active {
            transform: translateY(-1px);
        }

        .form-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 24px;
            color: white;
        }

        /* Animation pour les éléments du formulaire */
        .form-group {
            opacity: 0;
            transform: translateY(30px);
            animation: slideUp 0.6s ease forwards;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.1s;
        }

        .form-group:nth-child(3) {
            animation-delay: 0.2s;
        }

        .submit-btn {
            opacity: 0;
            transform: translateY(30px);
            animation: slideUp 0.6s ease 0.3s forwards;
        }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Effet de validation visuelle */
        .form-group.valid select {
            border-color: #4CAF50;
            background: linear-gradient(90deg, #fff 0%, #f8fff8 100%);
        }

        .form-group.valid::after {
            content: '✓';
            position: absolute;
            right: 45px;
            top: 50%;
            transform: translateY(-50%);
            color: #4CAF50;
            font-weight: bold;
            font-size: 16px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-container {
                margin: 20px;
                padding: 30px 25px;
            }

            .form-header h1 {
                font-size: 24px;
            }

            select {
                padding: 12px 35px 12px 15px;
                font-size: 15px;
            }

            .submit-btn {
                padding: 15px;
                font-size: 14px;
            }
        }

        /* États de focus améliorés */
        select:focus + .select-wrapper::after {
            color: #667eea;
            transform: translateY(-50%) rotate(180deg);
        }

        /* Effet de chargement sur le bouton */
        .submit-btn.loading {
            pointer-events: none;
        }

        .submit-btn.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <div class="form-icon">🔍</div>
            <h1>Filtrage des Candidats</h1>
            <p>Sélectionnez vos critères de tri</p>
        </div>

        <form action="entretien" method="get" id="filterForm">
            <div class="form-group">
                <label for="statutEntretien">Statut du CV</label>
                <div class="select-wrapper">
                    <select name="statutEntretien" id="statutEntretien">
                        <option value="">Veuillez choisir un statut</option>
                        <?php foreach ($tri as $statut) : ?>
                            <option value="<?= htmlspecialchars($statut['idStatus']) ?>">
                                <?= htmlspecialchars($statut['nomStatus']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="modeTri">Ordre de tri par score</label>
                <div class="select-wrapper">
                    <select name="modeTri" id="modeTri">
                        <option value="">Veuillez choisir un ordre</option>
                        <option value="1">Ascendant (Plus bas → Plus haut)</option>    
                        <option value="2">Descendant (Plus haut → Plus bas)</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="submit-btn" id="submitBtn">
                Appliquer les filtres
            </button>
        </form>
    </div>

    <script>
        // Amélioration de l'expérience utilisateur
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('filterForm');
            const submitBtn = document.getElementById('submitBtn');
            const selects = document.querySelectorAll('select');

            // Validation visuelle en temps réel
            selects.forEach(select => {
                select.addEventListener('change', function() {
                    const formGroup = this.closest('.form-group');
                    if (this.value !== '') {
                        formGroup.classList.add('valid');
                    } else {
                        formGroup.classList.remove('valid');
                    }
                });
            });

            // Effet de chargement sur submit
            form.addEventListener('submit', function() {
                submitBtn.classList.add('loading');
                submitBtn.innerHTML = '';
            });

            // Animation d'entrée retardée pour un effet professionnel
            setTimeout(() => {
                document.querySelector('.form-container').style.transform = 'scale(1)';
                document.querySelector('.form-container').style.opacity = '1';
            }, 100);
        });
    </script>
</body>
</html>