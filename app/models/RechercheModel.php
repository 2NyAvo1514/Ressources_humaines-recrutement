<?php

namespace app\models;

use Flight;
use PDO;

class RechercheModel
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function rechercherCandidats($criteres = []) {
        $sql = "SELECT 
            c.idCandidat, 
            c.nom, 
            c.prenom,
            GROUP_CONCAT(DISTINCT CONCAT(g.nomDegre, ' (', d.nomDomaine, ')') SEPARATOR ', ') AS diplomes,
            s.nomStatus,
            p.nomPoste
        FROM rh_candidat c
        LEFT JOIN rh_diplome dip ON dip.idCandidat = c.idCandidat
        LEFT JOIN rh_domaine d ON dip.idDomaine = d.idDomaine
        LEFT JOIN rh_degre g ON dip.idDegre = g.idDegre
        LEFT JOIN rh_status_candidat sc ON sc.idCandidat = c.idCandidat
        LEFT JOIN rh_status s ON sc.idStatus = s.idStatus
        LEFT JOIN rh_candidat_poste cp ON cp.idCandidat = c.idCandidat
        LEFT JOIN rh_poste p ON cp.idPoste = p.idPoste
        WHERE 1=1";


        $params = [];

        if (!empty($criteres['nom'])) {
            $sql .= " AND c.nom LIKE :nom";
            $params[':nom'] = "%" . $criteres['nom'] . "%";
        }
        if (!empty($criteres['prenom'])) {
            $sql .= " AND c.prenom LIKE :prenom";
            $params[':prenom'] = "%" . $criteres['prenom'] . "%";
        }
        if (!empty($criteres['domaine'])) {
            $sql .= " AND d.nomDomaine LIKE :domaine";
            $params[':domaine'] = "%" . $criteres['domaine'] . "%";
        }
        if (!empty($criteres['diplome'])) {
            $sql .= " AND g.nomDegre LIKE :diplome";
            $params[':diplome'] = "%" . $criteres['diplome'] . "%";
        }
        if (!empty($criteres['status'])) {
            $sql .= " AND s.nomStatus LIKE :status";
            $params[':status'] = "%" . $criteres['status'] . "%";
        }
        if (!empty($criteres['poste'])) {
            $sql .= " AND p.nomPoste LIKE :poste";
            $params[':poste'] = "%" . $criteres['poste'] . "%";
        }

        $sql .= " GROUP BY c.idCandidat";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function rechercheGeneral($mot=[]){
        $sql = "SELECT
                c.idCandidat,
                c.nom,
                c.prenom,
                GROUP_CONCAT(DISTINCT CONCAT(g.nomDegre, ' (', d.nomDomaine, ')') SEPARATOR ', ') AS diplomes,
                s.nomStatus,
                p.nomPoste
            FROM rh_candidat c
            LEFT JOIN rh_diplome dip ON dip.idCandidat = c.idCandidat
            LEFT JOIN rh_domaine d ON dip.idDomaine = d.idDomaine
            LEFT JOIN rh_degre g ON dip.idDegre = g.idDegre
            LEFT JOIN rh_status_candidat sc ON sc.idCandidat = c.idCandidat
            LEFT JOIN rh_status s ON sc.idStatus = s.idStatus
            LEFT JOIN rh_candidat_poste cp ON cp.idCandidat = c.idCandidat
            LEFT JOIN rh_poste p ON cp.idPoste = p.idPoste
            WHERE c.nom LIKE :keyword
               OR c.prenom LIKE :keyword
               OR d.nomDomaine LIKE :keyword
               OR g.nomDegre LIKE :keyword
               OR s.nomStatus LIKE :keyword
               OR p.nomPoste LIKE :keyword
            GROUP BY c.idCandidat";
        // if(!empty($mot['general'])){
            
        // }

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':keyword' => '%' . $mot['general'] . '%'
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
}
