<?php

namespace app\controllers;

use app\models\PlanningModel;
use Flight;

class PlanningController {
    public function __construct() {

	}

    public function index() {
        $plan = Flight::planningModel()->getEmployesAEntretenir();
        Flight::render("planning",['data'=>$plan],'content');
        Flight::render('layout',['title'=>'Planning des entretiens']);
    }

    public function events() {
        $list = Flight::planningModel()->getPlanning();
        $events = [];
        foreach ($list as $li) {
            $events[] = [
                'title' => $li['nom']." ".$li['prenom'],
                'start'=> $li['dateEntretien'],
                'color' => $li['nomStatus'] === 'entretien-non' ? 'yellow' : 'green',
                'textColor' => $li['nomStatus'] === 'entretien-non' ? 'black' : 'white',
            ];
        }
        Flight::json($events);
    }
}

