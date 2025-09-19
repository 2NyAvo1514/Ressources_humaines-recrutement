<?php
namespace app\models;
use PDO;

class triModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllPoste()
    {
        $stmt = $this->db->query("
            select * from rh_poste;
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIdByNomPoste($nomPoste)
    {
        $stmt = $this->db->query("
            select idPoste from rh_poste where nomPoste = '" . $nomPoste . "';
        ");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllDomaine(){
        $stmt = $this->db->query("
            select * from rh_domaine;
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllStatut()
    {
        $stmt = $this->db->query("
            select * from rh_status;
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function faireTriPoste($poste)
    {
        $stmt = $this->db->query("
            select * from rh_candidat as c join rh_candidat_poste as cp on c.idCandidat = cp.idCandidat where cp.idPoste =  " . (int) $poste . ";
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function faireTriStatut($statut)
    {
        $stmt = $this->db->query("
            select * from rh_candidat as c join rh_status_candidat as sc on c.idCandidat = sc.idCandidat where sc.idStatus = " . (int) $statut . ";
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function triParMode($modeTri)
    {
        $order = "ASC";
        if ($modeTri == 2) {
            $order = "DESC";
        }
    
        $sql = "
            SELECT c.idCandidat, c.nom, c.prenom, 
                   SUM(st.note + se.note) AS totalScore
            FROM rh_candidat c
            JOIN rh_score_test st ON c.idCandidat = st.idCandidat
            JOIN rh_score_entretien se ON c.idCandidat = se.idCandidat
            GROUP BY c.idCandidat, c.nom, c.prenom
            ORDER BY totalScore $order
        ";
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // public function triercv($poste, $statut, $modeTri)
    // {
    //     $params = [];
    //     $where = [];

    //     $order = "";
    //     if ($modeTri == 1) {
    //         $order = "ORDER BY totalScore ASC";
    //     } elseif ($modeTri == 2) {
    //         $order = "ORDER BY totalScore DESC";
    //     }

    //     $sql = "
    //         SELECT c.idCandidat, c.nom AS nom, c.prenom AS prenom,
    //             COALESCE(SUM(st.note),0) + COALESCE(SUM(se.note),0) AS totalScore,
    //             p.nomPoste AS poste,
    //             s.nomStatus AS statut
    //         FROM rh_candidat c
    //         LEFT JOIN rh_score_test st ON c.idCandidat = st.idCandidat
    //         LEFT JOIN rh_score_entretien se ON c.idCandidat = se.idCandidat
    //         LEFT JOIN rh_candidat_poste cp ON c.idCandidat = cp.idCandidat
    //         LEFT JOIN rh_poste p ON cp.idPoste = p.idPoste
    //         LEFT JOIN rh_status_candidat sc ON c.idCandidat = sc.idCandidat
    //         LEFT JOIN rh_status s ON sc.idStatus = s.idStatus
    //     ";

    //     // Filtrage dynamique
    //     if (!empty($poste)) {
    //         $where[] = "cp.idPoste = :poste";
    //         $params[':poste'] = (int)$poste;
    //     }

    //     if (!empty($statut)) {
    //         $where[] = "sc.idStatus = :statut";
    //         $params[':statut'] = (int)$statut;
    //     }

    //     if (!empty($where)) {
    //         $sql .= " WHERE " . implode(" AND ", $where);
    //     }

    //     $sql .= " GROUP BY c.idCandidat, c.nom, c.prenom, p.nomPoste, s.nomStatus $order";

    //     $stmt = $this->db->prepare($sql);
    //     $stmt->execute($params);

    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function triercv($domaine = null, $poste = null, $statut = null, $modeTri = null) {
        $params = [];
    
        // Tri
        $order = "";
        if ($modeTri == 1) {
            $order = "ORDER BY totalScore ASC";
        } elseif ($modeTri == 2) {
            $order = "ORDER BY totalScore DESC";
        }
    
        $sql = "
            SELECT 
                c.idCandidat,
                c.nom,
                c.prenom,
                COALESCE(SUM(st.note),0) + COALESCE(SUM(se.note),0) AS totalScore,
                p.nomPoste AS poste,
                s.nomStatus AS statut,
                d.nomDomaine AS domaine
            FROM rh_candidat c
            LEFT JOIN rh_score_test st ON c.idCandidat = st.idCandidat
            LEFT JOIN rh_score_entretien se ON c.idCandidat = se.idCandidat
            LEFT JOIN rh_candidat_poste cp ON c.idCandidat = cp.idCandidat
            LEFT JOIN rh_poste p 
                ON cp.idPoste = p.idPoste
                AND (:domaine IS NULL OR p.idDomaine = :domaine)
            LEFT JOIN rh_domaine d ON p.idDomaine = d.idDomaine
            LEFT JOIN rh_status_candidat sc 
                ON sc.idStatusCandidat = (
                    SELECT sc2.idStatusCandidat
                    FROM rh_status_candidat sc2
                    WHERE sc2.idCandidat = c.idCandidat
                    ORDER BY sc2.dateStatus DESC, sc2.idStatusCandidat DESC
                    LIMIT 1
                )
            LEFT JOIN rh_status s ON sc.idStatus = s.idStatus
        ";
    
        // Filtre poste
        $where = [];
        if (!empty($poste)) {
            $where[] = "cp.idPoste = :poste";
            $params[':poste'] = (int)$poste;
        }
    
        // Filtre statut
        if (!empty($statut)) {
            $where[] = "sc.idStatus = :statut";
            $params[':statut'] = (int)$statut;
        } else {
            // exclure les candidats rejetés seulement si aucun filtre de statut n'est défini
            $where[] = "(sc.idStatus IS NULL OR sc.idStatus <> 6)";
        }
    
        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }
    
        $sql .= " GROUP BY c.idCandidat, c.nom, c.prenom, p.nomPoste, s.nomStatus, d.nomDomaine $order";
    
        $stmt = $this->db->prepare($sql);
        $params[':domaine'] = !empty($domaine) ? (int)$domaine : null;
        $stmt->execute($params);
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    
    

    




}