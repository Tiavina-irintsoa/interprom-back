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
    $routes->resource('type-matchs', ['controller' => 'TypeMatchController']);
    $routes->resource('tournoi-equipes', ['controller' => 'TournoiEquipeController']);
    $routes->resource('poule', ['controller' => 'PouleJController']);
});

$routes->post('login','LoginController::index');

// Routes à propos des équipes
$routes->get('api/equipes/tournoi/(:num)', 'EquipeController::tournoi/$1');
$routes->get('api/equipes/tournoi', 'EquipeController::tournoi');

// A propos des matchs
$routes->get('api/matchs-discipline-tournoi/(:num)/(:num)', 'MatchController::list_match_by_discipline/$1/$2');
$routes->get('api/start-match/(:num)', 'MatchController::start_match/$1');
$routes->get('api/end-match/(:num)', 'MatchController::end_match/$1');

$routes->get('api/match-en-cours', 'MatchJController::get_matche_en_cours_par_discipline');
$routes->get('api/match-a-suivre', 'MatchJController::get_matche_a_suivre');
$routes->post('api/matchs/update_score', 'MatchController::update_score');

$routes->get('api/match-en-cours/(:num)', 'MatchJController::get_matche_en_cours_par_discipline/$1');
$routes->get('api/statistique-par-poule/(:num)', 'PouleJController::get_resultat_poule_choisie/$1');
$routes->get('api/classement-par-poule/(:num)', 'PouleJController::get_classement_par_poule_choisi/$1');