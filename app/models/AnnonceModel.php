<?php
namespace app\models;

use Flight;
use PDO;

class AnnonceModel {
    private $db;

    public function __construct($db)
    {
        $this->db = $db; 
    }

    public function ajouterAnnonce($data)
    {
        $sql = "INSERT INTO rh_annonce (idPoste, ageMin, ageMax, idSexe, idExperience)
                VALUES (:idPoste, :min , :max, :sexe, :exp)";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':idPoste' => $data['poste'] , // à adapter selon ton schéma
            ':min' => $data['ageMin'] ,
            ':max' => $data['ageMax'] ,
            ':sexe' => $data['sexe'] ,
            ':exp' => $data['exp'] 
        ]);

        $idAnnonce = $this->db->lastInsertId();

        $sql2 = "INSERT INTO rh_diplome_annonce (idAnnonce,idDomaine,idDegre)
                VALUES (:annonce,:domaine,:degre)";
        $stmt2 = $this->db->prepare($sql2);
        $stmt2->execute([
            ':annonce' => $idAnnonce ,
            ':domaine' => $data['domaine'] ,
            ':degre' => $data['diplome'] 
        ]);

        // Boucle sur les langues sélectionnées
        if (!empty($data['langue'])) {
            $sql3 = "INSERT INTO rh_langue_annonce (idAnnonce, idLangue) 
                    VALUES (:annonce, :langue)";
            $stmt3 = $this->db->prepare($sql3);

            foreach ($data['langue'] as $idLangue) {
                $stmt3->execute([
                    ':annonce' => $idAnnonce,
                    ':langue' => $idLangue
                ]);
            }
        }

        return $idAnnonce;
    }

     public function getAllAnnonces() {
        // Récupération des annonces + poste + sexe + expérience
        $sql = "
            SELECT a.idAnnonce, p.nomPoste ,p.descriPoste, a.ageMin, a.ageMax, s.genre AS sexe, e.duree AS experience
            FROM rh_annonce a
            JOIN rh_poste p ON a.idPoste = p.idPoste
            LEFT JOIN rh_sexe s ON a.idSexe = s.idSexe
            LEFT JOIN rh_experience e ON a.idExperience = e.idExperience
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $annonces = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($annonces as &$annonce) {
            // Pour chaque annonce, récupérer les diplômes requis
            $stmt = $this->db->prepare("
                SELECT d.nomDomaine, g.nomDegre
                FROM rh_diplome_annonce da
                JOIN rh_domaine d ON da.idDomaine = d.idDomaine
                JOIN rh_degre g ON da.idDegre = g.idDegre
                WHERE da.idAnnonce = ?
            ");
            $stmt->execute([$annonce['idAnnonce']]);
            $annonce['diplomes'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Récupérer les langues requises
            $stmt = $this->db->prepare("
                SELECT l.langue
                FROM rh_langue_annonce la
                JOIN rh_langue l ON la.idLangue = l.idLangue
                WHERE la.idAnnonce = ?
            ");
            $stmt->execute([$annonce['idAnnonce']]);
            $annonce['langues'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $annonces;
    }

    public function getDomaine(){
        return $this->db->query("SELECT idDomaine, nomDomaine FROM rh_domaine")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDegre(){
        return $this->db->query("SELECT idDegre, nomDegre FROM rh_degre")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSexe(){
        return $this->db->query("SELECT idSexe, genre FROM rh_sexe")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPoste(){
        return $this->db->query("SELECT idPoste, nomPoste FROM rh_poste")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getExperience(){
        return $this->db->query(" SELECT * FROM rh_experience")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLangue(){
        return $this->db->query(" SELECT * FROM rh_langue")->fetchAll(PDO::FETCH_ASSOC);
    }
}
