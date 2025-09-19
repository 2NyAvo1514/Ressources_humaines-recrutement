<?php
namespace app\models;
use PDO;

class triEntretienModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getDetailCandidats($idCandidat)
    {
    $sql = "
        SELECT 
            c.idCandidat,
            c.nom,
            c.prenom,
            c.dateNaissance,
            c.adresse,
            c.mail,
            c.contact,
            s.genre AS sexe,
            e.duree AS experience,
            GROUP_CONCAT(DISTINCT l.langue SEPARATOR ', ') AS langues,
            GROUP_CONCAT(DISTINCT CONCAT(d.nomDomaine, ' - ', g.nomDegre, ' (', di.anneeObtention, ')') SEPARATOR '; ') AS diplomes,
            p.nomPoste,
            st.note AS scoreTest,
            se.note AS scoreEntretien,
            COALESCE(st.note,0) + COALESCE(se.note,0) AS totalScore,
            stc.idStatusCandidat,
            stc.dateStatus,
            stt.nomStatus,
            stt.idStatus
        FROM rh_candidat c
        LEFT JOIN rh_sexe s ON c.idSexe = s.idSexe
        LEFT JOIN rh_experience e ON c.idExperience = e.idExperience
        LEFT JOIN rh_candidat_langue cl ON c.idCandidat = cl.idCandidat
        LEFT JOIN rh_langue l ON cl.idLangue = l.idLangue
        LEFT JOIN rh_diplome di ON c.idCandidat = di.idCandidat
        LEFT JOIN rh_domaine d ON di.idDomaine = d.idDomaine
        LEFT JOIN rh_degre g ON di.idDegre = g.idDegre
        LEFT JOIN rh_candidat_poste cp ON c.idCandidat = cp.idCandidat
        LEFT JOIN rh_poste p ON cp.idPoste = p.idPoste
        LEFT JOIN rh_score_test st ON c.idCandidat = st.idCandidat
        LEFT JOIN rh_score_entretien se ON c.idCandidat = se.idCandidat
        LEFT JOIN rh_status_candidat stc 
            ON stc.idCandidat = c.idCandidat
            AND stc.idStatusCandidat = (
                SELECT sc2.idStatusCandidat
                FROM rh_status_candidat sc2
                WHERE sc2.idCandidat = c.idCandidat
                ORDER BY sc2.dateStatus DESC, sc2.idStatusCandidat DESC
                LIMIT 1
            )
        LEFT JOIN rh_status stt ON stc.idStatus = stt.idStatus
        WHERE c.idCandidat = ".$idCandidat."
        GROUP BY c.idCandidat
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    public function getAllCandidats($statut = null, $modeTri = null)
{
    $sql = "
        SELECT 
            c.idCandidat,
            c.nom,
            c.prenom,
            p.nomPoste,
            s.nomStatus,
            s.idStatus,
            COALESCE(MAX(st.note), 0) + COALESCE(MAX(se.note), 0) AS totalScore
        FROM rh_candidat c
        LEFT JOIN rh_score_test st ON c.idCandidat = st.idCandidat
        LEFT JOIN rh_score_entretien se ON c.idCandidat = se.idCandidat
        LEFT JOIN rh_candidat_poste cp ON c.idCandidat = cp.idCandidat
        LEFT JOIN rh_poste p ON cp.idPoste = p.idPoste
        LEFT JOIN rh_status_candidat sc 
            ON sc.idCandidat = c.idCandidat
            AND sc.idStatusCandidat = (
                SELECT sc2.idStatusCandidat
                FROM rh_status_candidat sc2
                WHERE sc2.idCandidat = c.idCandidat
                ORDER BY sc2.dateStatus DESC, sc2.idStatusCandidat DESC
                LIMIT 1
            )
        LEFT JOIN rh_status s ON sc.idStatus = s.idStatus
        WHERE 1=1
    ";

    if (!empty($statut)) {
        if ($statut == 6) {
            $sql .= " AND sc.idStatus = 6 ";
        } else {
            $sql .= " AND sc.idStatus = :statut AND sc.idStatus != 6 ";
        }
    } else {
        $sql .= " AND (sc.idStatus IS NULL OR sc.idStatus != 6) ";
    }

    $sql .= " GROUP BY c.idCandidat ";

    if (!empty($modeTri)) {
        if ($modeTri == 1) {
            $sql .= " ORDER BY totalScore ASC ";
        } elseif ($modeTri == 2) {
            $sql .= " ORDER BY totalScore DESC ";
        }
    }

    $stmt = $this->db->prepare($sql);

    if (!empty($statut) && $statut != 6) {
        $stmt->bindValue(":statut", $statut, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    


    public function changeStatutRejet($statut, $idCandidat) 
    {

        if ($statut === 0) {
            $idStatus = 6;
        } 

        $sql = "
            INSERT INTO rh_status_candidat (idCandidat, idStatus, dateStatus)
            VALUES (:idCandidat, :idStatus, NOW())
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':idCandidat' => $idCandidat,
            ':idStatus'   => 6
        ]);

        return $this->db->lastInsertId();
    }

    public function changeStatutLu($statut, $idCandidat)
    {
        if ($statut == 1) { 
            $idStatus = 2;
            $sql = "
                INSERT INTO rh_status_candidat (idCandidat, idStatus, dateStatus)
                VALUES (:idCandidat, :idStatus, NOW())
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':idCandidat' => $idCandidat,
                ':idStatus'   => $idStatus
            ]);

            return $this->db->lastInsertId();
        }   

        return null; 
    }


    public function isAlreadyTeste($idCandidat)
    {
        $sql = "
            SELECT CASE 
                    WHEN COUNT(*) > 0 THEN 1 
                    ELSE 0 
                END AS dejaTeste
            FROM rh_score_test
            WHERE idCandidat = :idCandidat
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idCandidat", $idCandidat, PDO::PARAM_INT);
        $stmt->execute();

        return (int) $stmt->fetchColumn(); // retournera 1 ou 0
    }

    public function isAlreadyEntretenu($idCandidat)
    {
        $sql = "
            SELECT CASE 
                    WHEN COUNT(*) > 0 THEN 1 
                    ELSE 0 
                END AS dejaTeste
            FROM rh_score_entretien
            WHERE idCandidat = :idCandidat
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idCandidat", $idCandidat, PDO::PARAM_INT);
        $stmt->execute();

        return (int) $stmt->fetchColumn(); // retournera 1 ou 0
    }

    public function insertScore($idCandidat, $scoreEntretien)
    {
        $sql = "
            INSERT INTO rh_score_entretien (idCandidat, note)
            VALUES (:idCandidat, :note)
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':idCandidat' => $idCandidat,
            ':note'       => $scoreEntretien
        ]);

        $sqlStatus = "
            INSERT INTO rh_status_candidat (idCandidat, idStatus, dateStatus)
            VALUES (:idCandidat, :idStatus, NOW())
        ";
        $stmtStatus = $this->db->prepare($sqlStatus);
        $stmtStatus->execute([
            ':idCandidat' => $idCandidat,
            ':idStatus'   => 4
        ]);

        return $this->db->lastInsertId();
    }

    public function changeStatutLuRejet($idCandidat)
    {
        $idStatus = 2;
            $sql = "
                INSERT INTO rh_status_candidat (idCandidat, idStatus, dateStatus)
                VALUES (:idCandidat, :idStatus, NOW())
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':idCandidat' => $idCandidat,
                ':idStatus'   => $idStatus
            ]);

            return $this->db->lastInsertId();
    }
}