<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion RH - Entreprise</title>
  <!-- Font Awesome (icônes) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
      min-height: 100vh;
      background: #f4f6f8;
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
      background: #2c3e50;
      color: #fff;
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      padding-top: 20px;
      transition: width 0.3s;
      overflow-y: auto;
    }
    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 20px;
      letter-spacing: 1px;
    }
    .sidebar a {
      padding: 15px 20px;
      color: #ecf0f1;
      text-decoration: none;
      display: block;
      transition: background 0.3s;
    }
    .sidebar a:hover {
      background: #34495e;
    }
    .sidebar a.active {
      background: #1abc9c;
      font-weight: bold;
    }

    /* Dropdown */
    .dropdown-btn {
      cursor: pointer;
      padding: 15px 20px;
      color: #ecf0f1;
      border: none;
      background: none;
      width: 100%;
      text-align: left;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 16px;
    }
    .dropdown-btn:hover {
      background: #34495e;
    }
    .dropdown-container {
      display: none;
      flex-direction: column;
      background: #34495e;
    }
    .dropdown-container a {
      padding-left: 40px;
      font-size: 14px;
    }

    /* Main content */
    .main-content {
      margin-left: 250px;
      padding: 20px;
      flex: 1;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        width: 60px;
      }
      .sidebar h2 {
        display: none;
      }
      .sidebar a,
      .dropdown-btn {
        text-align: center;
        padding: 15px;
      }
      .sidebar a span,
      .dropdown-btn span {
        display: none;
      }
      .main-content {
        margin-left: 60px;
      }
      .dropdown-container a {
        padding-left: 20px;
      }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h2><i class="fas fa-briefcase"></i> RH</h2>
    
    <a href="<?= Flight::get('flight.base_url') ?>/recherche" class="<?= ($_SERVER['REQUEST_URI'] == '/recherche') ? 'active' : '' ?>">
      <i class="fas fa-search"></i> <span>Recherche Candidats</span>
    </a>

    <!-- Dropdown -->
    <button class="dropdown-btn">
      <span><i class="fas fa-bullhorn"></i> Annonces</span>
      <i class="fas fa-chevron-down"></i>
    </button>
    <div class="dropdown-container">
      <a href="<?= Flight::get('flight.base_url') ?>/annonce/create" class="<?= ($_SERVER['REQUEST_URI'] == '/annonce') ? 'active' : '' ?>">➕ Créer une annonce</a>
      <a href="<?= Flight::get('flight.base_url') ?>/annonce/liste" class="<?= ($_SERVER['REQUEST_URI'] == '/annonce/liste') ? 'active' : '' ?>">📄 Liste des annonces</a>
    </div>

    <a href="<?= Flight::get('flight.base_url') ?>/employes" class="<?= ($_SERVER['REQUEST_URI'] == '/employes') ? 'active' : '' ?>">
      <i class="fas fa-users"></i> <span>Employés</span>
    </a>
    <a href="planning" class="<?= ($_SERVER['REQUEST_URI'] == '/planning') ? 'active' : '' ?>">
      <i class="fas fa-chart-line"></i> <span>Planning Entretiens</span>
    </a>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <?php echo $content; ?>
  </div>

  <!-- Script pour dropdown -->
  <script>
    document.querySelectorAll(".dropdown-btn").forEach(btn => {
      btn.addEventListener("click", function() {
        this.classList.toggle("active");
        let container = this.nextElementSibling;
        if (container.style.display === "flex") {
          container.style.display = "none";
        } else {
          container.style.display = "flex";
        }
      });
    });
  </script>
</body>
</html>
