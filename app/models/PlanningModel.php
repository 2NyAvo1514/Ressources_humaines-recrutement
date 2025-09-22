<?php

namespace app\models;

use Flight;
use PDO;

class PlanningModel
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getPlanning()
    {
        $sql = "SELECT c.idCandidat,c.nom,c.prenom,s.nomStatus,e.dateEntretien
                FROM rh_entretien e
                JOIN rh_candidat c
                    on e.idCandidat = c.idCandidat 
                JOIN rh_status_candidat sc
                    on sc.idCandidat = c.idCandidat
                JOIN rh_status s
                    on s.idStatus = sc.idStatus
                WHERE sc.idStatus >= 3
                ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getEmployesAEntretenir()
    {
        $sql = "SELECT c.idCandidat,c.nom,c.prenom,e.dateEntretien
                FROM rh_candidat c
                JOIN rh_status_candidat sc
                    on sc.idCandidat = c.idCandidat
                LEFT JOIN rh_entretien e 
                    on e.idCandidat = c.idCandidat
                WHERE sc.idStatus = 3 and e.dateEntretien IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function saveEntretien($idCandidat, $dateEntretien)
    {
        $sql = "INSERT INTO rh_entretien (idCandidat, dateEntretien)
            VALUES (:idCandidat, :dateEntretien)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':idCandidat' => $idCandidat,
            ':dateEntretien' => $dateEntretien
        ]);
    }
}
