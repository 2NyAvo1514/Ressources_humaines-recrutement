<?php

namespace app\controllers;
use app\models\triEntretienModel;
use Flight;

class triEntretienController
{
    public function __construct()
    {

    }

    public function getAllCandidats($statut, $modeTri)
    {
        $status = Flight::triEntretienModel()-> getAllCandidats($statut, $modeTri);
        return $status;
    }

    public function getDetailCandidats($idCandidat)
    {
        $candidat = Flight::triEntretienModel()-> getDetailCandidats($idCandidat);
        return $candidat;
    }
    
    public function changeStatutRejet($statut, $idCandidat)
    {
        Flight::triEntretienModel()->changeStatutRejet($statut, $idCandidat);
    }

    public function changeStatutLu($statut, $idCandidat)
    {
        Flight::triEntretienModel()->changeStatutLu($statut, $idCandidat);
    }

    public function isAlreadyTeste($idCandidat)
    {
        Flight::triEntretienModel()->isAlreadyTeste($idCandidat);
    }

    public function isAlreadyEntretenu($idCandidat)
    {
        Flight::triEntretienModel()->isAlreadyEntretenu($idCandidat);
    }

    public function insertScore($idCandidat, $scoreEntretien)
    {
        Flight::triEntretienModel()->insertScore($idCandidat, $scoreEntretien);
    }

    public function changeStatutLuRejet($idCandidat){
        Flight::triEntretienModel()->changeStatutLuRejet($idCandidat);
    }
    
}