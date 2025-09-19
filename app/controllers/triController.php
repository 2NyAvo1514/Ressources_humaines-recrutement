<?php

namespace app\controllers;
use app\models\triModel;
use Flight;

class triController
{
    public function __construct()
    {

    }

    public function getAllStatus()
    {
        $status = Flight::triModel()-> getAllstatut();
        return $status;
    }

    public function getAllPoste()
    {
        $poste = Flight::triModel()-> getAllPoste();
        return $poste;
    }

    public function getIdByNomPoste($nomPoste)
    {
        $id = Flight::triModel()-> getIdByNomPoste($nomPoste);
        return $id;
    }

    public function getAllDomaine()
    {
        $domaine = Flight::triModel()-> getAllDomaine();
        return $domaine;
    }

    public function triercv($domaine, $poste, $statut, $modeTri)
    {
        $tri = Flight::triModel()-> triercv($domaine, $poste, $statut, $modeTri);
        return $tri;
    }
    
}