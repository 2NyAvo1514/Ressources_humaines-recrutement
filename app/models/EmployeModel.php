<?php

namespace app\models;

use Flight;
use PDO;

class EmployeModel
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllEmployes()
    {
        $sql = "";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getEmployesActifs()
    {
        $sql = "SELECT
            e.idEmploye,
            c.nom,
            c.prenom,
            c.mail,
            c.contact,
            p.nomPoste,
            (
                SELECT MIN(em3.dateMouvement)
                FROM rh_employe_mouvement em3
                JOIN rh_mouvement m3 ON em3.idMouvement = m3.idMouvement
                WHERE em3.idEmploye = e.idEmploye
                AND LOWER(m3.nomMouvement) = 'embauche'
            ) AS dateEmbauche,
            lm.dateMouvement   AS dateDernierMouvement
            FROM rh_employe e
            JOIN rh_candidat c ON e.idCandidat = c.idCandidat
            LEFT JOIN (
                SELECT em1.idEmploye, em1.idMouvement, em1.dateMouvement
                FROM rh_employe_mouvement em1
                JOIN (
                    SELECT idEmploye, MAX(dateMouvement) AS maxDate
                    FROM rh_employe_mouvement
                    GROUP BY idEmploye
                ) em2 ON em1.idEmploye = em2.idEmploye AND em1.dateMouvement = em2.maxDate
            )as lm ON e.idEmploye = lm.idEmploye
            LEFT JOIN rh_mouvement m ON lm.idMouvement = m.idMouvement
            LEFT JOIN (
                SELECT cp1.idCandidat, cp1.idPoste
                FROM rh_candidat_poste cp1
                JOIN (
                    SELECT idCandidat, MAX(idCandidatPoste) AS maxId
                    FROM rh_candidat_poste
                    GROUP BY idCandidat
                ) cp2 ON cp1.idCandidat = cp2.idCandidat AND cp1.idCandidatPoste = cp2.maxId
            ) latest_cp ON latest_cp.idCandidat = e.idCandidat
            LEFT JOIN rh_poste p ON latest_cp.idPoste = p.idPoste

            WHERE ( LOWER(m.nomMouvement) <> 'demission')";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
