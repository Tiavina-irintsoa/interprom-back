<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'TestDatabase::index');

$routes->group('api', function($routes)
{
    $routes->resource('utilisateur', ['controller' => 'UtilisateurJController']);
    $routes->resource('discipline', ['controller' => 'DisciplineJController']);
    $routes->resource('matchs', ['controller' => 'MatchController']);
    
    $routes->resource('poule', ['controller' => 'PouleJController']);
});

// Login
$routes->post('login','LoginController::index');

// Routes qui ont besoin d authentification
$routes->get('api/equipes/tournoi', 'EquipeController::tournoi',['filter' => \App\Filters\TokenFilter::class]);

// Import
$routes->post('api/equipes/import', 'EquipeController::import_equipe');
$routes->post('api/matchs/import', 'MatchController::import_match');





$routes->post('/api/matchs/update_score', 'MatchController::update_score');

// Routes à propos des équipes
$routes->get('api/equipes/tournoi/(:num)', 'EquipeController::tournoi/$1');
// $routes->get('api/equipes/tournoi', 'EquipeController::tournoi');

// A propos des matchs
$routes->get('matchs/all/(:num)/(:num)', 'MatchController::list_match_by_discipline/$1/$2');
$routes->get('matchs/(:num)/start', 'MatchController::start_match/$1');
$routes->get('matchs/(:num)/end', 'MatchController::end_match/$1');

$routes->post('api/matchs/update_score', 'MatchController::update_score');
$routes->get('api/match-en-cours', 'MatchJController::get_matche_en_cours_par_discipline');
$routes->get('api/match-a-suivre', 'MatchJController::get_matche_a_suivre');
$routes->get('api/match-en-cours/(:num)', 'MatchJController::get_matche_en_cours_par_discipline/$1');
$routes->get('api/match-a-suivre', 'MatchJController::get_matche_a_suivre');
$routes->get('api/statistique-par-poule/(:num)', 'PouleJController::get_resultat_poule_choisie/$1');

