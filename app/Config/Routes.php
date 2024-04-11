<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'TestDatabase::index');

$routes->group('api', function($routes)
{
    $routes->resource('utilisateur', ['controller' => 'TestDatabase']);
    $routes->resource('discipline', ['controller' => 'DisciplineJController']);
    $routes->resource('matchs', ['controller' => 'MatchController']);
    
    $routes->resource('poule', ['controller' => 'PouleJController']);
});

// Routes à propos des équipes
$routes->get('api/equipes/tournoi/(:num)', 'EquipeController::tournoi/$1');
$routes->get('api/equipes/tournoi', 'EquipeController::tournoi');

// A propos des matchs
$routes->get('matchs/all/(:num)/(:num)', 'MatchController::list_match_by_discipline/$1/$2');
$routes->get('matchs/(:num)/start', 'MatchController::start_match/$1');
$routes->get('matchs/(:num)/end', 'MatchController::end_match/$1');

$routes->post('api/matchs/update_score', 'MatchController::update_score');
$routes->get('api/match-en-cours', 'MatchJController::get_matche_en_cours_par_discipline');
$routes->get('api/match-a-suivre', 'MatchJController::get_matche_a_suivre');