<?php
namespace app\controllers;

use app\models\AnnonceModel;
use Flight;

class AnnonceController
{
    public function __construct(){
        
    }

    // Afficher le formulaire
    public function creer() {
        // Récupérer les domaines
        $domaines = Flight::annonceModel()->getDomaine();

        // Récupérer les degrés
        $degres =  Flight::annonceModel()->getDegre();

        $sexe = Flight::annonceModel()->getSexe();

        $postes = Flight::annonceModel()->getPoste();

        $experiences = Flight::annonceModel()->getExperience();

        $langues = Flight::annonceModel()->getLangue();

        // Rendre la vue avec les données
        Flight::render("annonce_form", [
            'domaine' => $domaines,
            'degre'   => $degres,
            'sexe' => $sexe,
            'poste' => $postes,
            'experience' => $experiences ,
            'langue' => $langues
        ],'content');

        Flight::render(
            'layout',                                 // Layout général
            ['title' => 'Creation d\'une annonces']     // Variables pour layout
        );
    }

    // Traitement du formulaire
    public function ajouter()
    {
        /*$data = [
            'poste'        => $_POST['poste'] ?? '',
            'description'  => $_POST['description'] ?? '',
            'sexe'  => $_POST['sexe'] ?? '',
            'domaine'      => $_POST['domaine'] ?? '',
            'diplome'      => $_POST['diplome'] ?? '',
            'experience'  => $_POST['experience'] ?? '',
            'lieu'         => $_POST['lieu'] ?? '',
            'date_limite'  => $_POST['date_limite'] ?? null,
        ];*/

        $data = [
            'poste' => $_POST['poste'] ?? '',
            'ageMin' => $_POST['min'] ?? '',
            'ageMax' => $_POST['max'] ?? null,
            'sexe' => $_POST['sexe'] ?? '',
            'exp' => $_POST['experience'] ?? '',
            'domaine'      => $_POST['domaine'] ?? '',
            'diplome'      => $_POST['degre'] ?? '',
            'langue'      => $_POST['langue'] ?? ''
        ];

        Flight::annonceModel()->ajouterAnnonce($data);

        // après ajout, on redirige par ex. vers la liste des annonces
        Flight::redirect('annonce/liste?');
    }

    // Liste des annonces publiées
    public function liste()
    {
        $annonces = Flight::annonceModel()->getAllAnnonces();
        // Flight::render(, );
        Flight::render(
            'liste_annonces',                              // Vue principale
            ['annonces' => $annonces], 
            'content'                                 // On stocke dans $content
        );

        Flight::render(
            'layout',                                 // Layout général
            ['title' => 'Liste d\'annonces']     // Variables pour layout
        );
    }
}
