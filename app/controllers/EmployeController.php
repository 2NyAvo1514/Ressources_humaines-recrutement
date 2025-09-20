<?php

namespace app\controllers;

use app\models\EmployeModel;
use Flight;

class EmployeController {
    public function __construct() {

	}

    public function index() {
        $emp = Flight::employeModel()->getEmployesActifs();
        Flight::render('employes',['employes'=>$emp],'content');
        Flight::render('layout',['title'=>'Employes actifs']);
    }
}