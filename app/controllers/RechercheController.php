<?php

namespace app\controllers;

use app\models\RechercheModel;
use Flight;

class RechercheController {
    public function __construct() {

	}

    public function index() {
        // Récupère les critères depuis l’URL (GET)
        $criteres = [
            'general' => Flight::request()->query['general'] ?? '',
            'nom'     => Flight::request()->query['nom'] ?? '',
            'prenom'  => Flight::request()->query['prenom'] ?? '',
            'domaine' => Flight::request()->query['domaine'] ?? '',
            'diplome' => Flight::request()->query['diplome'] ?? '',
            'status'  => Flight::request()->query['status'] ?? '',
            'poste'   => Flight::request()->query['poste'] ?? ''
        ];

        $resultats = Flight::rechercheModel()->rechercherCandidats($criteres);

        // Appelle la vue
        // ⚡ Rendu avec layout
        Flight::render(
            'recherche',                              // Vue principale
            ['candidats' => $resultats, 'criteres' => $criteres], 
            'content'                                 // On stocke dans $content
        );

        Flight::render(
            'layout',                                 // Layout général
            ['title' => 'Recherche de candidats']     // Variables pour layout
        );
    }

    function indexTwo(){
        $mot = [
            'general' => Flight::request()->query['general'] ?? '',
            'nom'     => Flight::request()->query['nom'] ?? '',
            'prenom'  => Flight::request()->query['prenom'] ?? '',
            'domaine' => Flight::request()->query['domaine'] ?? '',
            'diplome' => Flight::request()->query['diplome'] ?? '',
            'status'  => Flight::request()->query['status'] ?? '',
            'poste'   => Flight::request()->query['poste'] ?? ''
        ];
        $resultats = Flight::rechercheModel()->rechercheGeneral($mot)  ;
        Flight::render('recherche',['candidats' => $resultats,'criteres' => $mot],'content');

        Flight::render(
            'layout',                                 // Layout général
            ['title' => 'Recherche de candidats']     // Variables pour layout
        );
    }
}