<?php

use app\controllers\ApiExampleController;
use app\controllers\RechercheController;
use app\controllers\AnnonceController;
use app\controllers\MigrationController;
// ======

use app\controllers\triController;
use app\controllers\triEntretienController;


use flight\Engine;
use flight\net\Router;
//use Flight;

/** 
 * @var Router $router 
 * @var Engine $app
 */
/*$router->get('/', function() use ($app) {
	$Welcome_Controller = new WelcomeController($app);
	$app->render('welcome', [ 'message' => 'It works!!' ]);
});*/
$rechercheController = new RechercheController();
$annonceController   = new AnnonceController();

$router->get('/', function () {
	Flight::render('hello');
});
// Recherche de candidats
$router->get('/recherche', [$rechercheController, 'index']);
$router->get('/recherche/general', [$rechercheController, 'indexTwo']);

// Annonces
// $router->get('/annonce', [$annonceController, 'form']); 
$router->get('/annonce/create', [$annonceController, 'creer']); 


// $router->get('/annonce', [$annonceController, 'form']);
$router->post('/annonce/ajouter', [$annonceController, 'ajouter']);
$router->get('/annonce/liste', [$annonceController, 'liste']);

// $router->post('/login', function () use ($LoginController) {
// 	$username = Flight::request()->data->username;
// 	$password = Flight::request()->data->password;
// 	$LoginController->login($username, $password);        
// });

// $router->get('/depot', function () {
//     session_start();
//     if (!isset($_SESSION['username'])) {
//         Flight::redirect('/');
//         return;
//     }
// 	// $_SESSION['username'] = $_SESSION['username'];
//     Flight::render('depot');
// });

// =====================
$tri_entretien_Controller = new triEntretienController();
$tri_controller = new triController();
//$candidature_controller = new candidatureController();

$router->get('/formtri', function() use ($tri_controller) {
    $status = $tri_controller->getAllStatus();
    $poste = $tri_controller->getAllPoste();
    $domaine = $tri_controller->getAllDomaine();
    Flight::render('formtri', ['status' => $status, 'poste' => $poste, 'domaine' => $domaine ]);
});


$router->post('/tri', function() use ($tri_controller) {
    $request = Flight::request();

    $poste = $request->data->poste;
    $idPoste = $tri_controller->getIdByNomPoste($poste);
    $domaine = $request->data->domaine;
    $statut = $request->data->statut;   
    $modeTri = $request->data->modetri;
    
    $tri = $tri_controller-> triercv($domaine,  $idPoste, $statut, $modeTri);
    Flight::render('resultattri', ['tri' => $tri]);
});

$router->get('/formEntretien', function() use ($tri_controller) {
    $tri = $tri_controller-> getAllStatus();
    Flight::render('formTriEntretien', ['tri' => $tri]);
});

$router->get('/entretien', function() use ($tri_entretien_Controller) {
    $request = Flight::request();
    $statut = $request->query->statutEntretien;
    $modeTri = $request->query->modeTri;

    $result = $tri_entretien_Controller->getAllCandidats($statut, $modeTri);

    Flight::render('resultatTriEntretien', ['result' => $result]);
});

$router->get('/detail', function() use ($tri_entretien_Controller) {
    $request = Flight::request();
    $idCandidat = $request->query->idCandidat;
    $statut = $request->query->idStatut;

    Flight::triEntretienModel()->changeStatutLu($statut, $idCandidat);
    $candidat = Flight::triEntretienModel()->getDetailCandidats($idCandidat);
    Flight::render('detailCandidat', ['candidat' => $candidat]);

});

$router->get('/changeStatut', function() use ($tri_entretien_Controller) {
    $request = Flight::request();       
    $statut = $request->query->statut;
    $idCandidat = $request->query->idCandidat;

    if( $statut==0){
        Flight::triEntretienModel()->changeStatutRejet($statut, $idCandidat) ;
        Flight::redirect("../../formEntretien");
    } else {
        
        $test = Flight::triEntretienModel()->isAlreadyTeste($idCandidat);
        $entretenu= Flight::triEntretienModel()->isAlreadyEntretenu($idCandidat);

        if($test==1 && $entretenu==0){
            Flight::render('formScoreEntretien', ['candidat' => $idCandidat]);
        } else if($test==0){
            Flight::redirect("../../test-qcm");

            // passer faire une teste
        }else if($entretenu==1){
            // detail du score avec message déjà entretenu
        }
    };
    
});


$router->get('/insertScore', function() use ($tri_entretien_Controller) {
    $request = Flight::request();       
    $idCandidat = $request->query->idCandidat;
    $scoreEntretien = $request->query->scoreEntretien;

    Flight::triEntretienModel()->insertScore($idCandidat, $scoreEntretien) ;
    Flight::redirect("../../formEntretien");
});


$router->get('/restaurer', function() use ($tri_entretien_Controller) {
    $request = Flight::request();       
    $idCandidat = $request->query->idCandidat;

    Flight::triEntretienModel()->changeStatutLuRejet($idCandidat) ;
    Flight::redirect("../../entretien");
});


