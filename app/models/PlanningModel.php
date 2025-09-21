<?php

namespace app\models;

use Flight;
use PDO;

class PlanningModel {

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getPlanning(){
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

    public function getEmployesAEntretenir(){
        $sql = "SELECT c.idCandidat,c.nom,c.prenom
                FROM rh_candidat c
                JOIN rh_status_candidat sc
                    on sc.idCandidat = c.idCandidat
                WHERE sc.idStatus = 3";
        $stmt = $this->db->prepare($sql);   
        $stmt->execute();  
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);    
        return $result; 
    }
}