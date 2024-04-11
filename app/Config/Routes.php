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

    // Listes des équipes participant à un tournoi
    $routes->get('equipes/tournoi/(:num)', 'EquipeController::tournoi/$1');
    $routes->get('equipes/tournoi', 'EquipeController::tournoi');

    $routes->resource('poule', ['controller' => 'PouleJController']);
    // Match par discipline par tournoi
    $routes->get('matchs/(:num)/(:num)', 'MatchController::list_match_by_discipline/$1/$2');

});

$routes->post('login','LoginController::index');
$routes->post('/api/matchs/update_score', 'MatchController::update_score');

// $routes->get('api/utilisateur', 'UtilisateurJController::index');


$routes->get('api/match-en-cours', 'MatchJController::get_matche_en_cours_par_discipline');
$routes->get('api/match-a-suivre', 'MatchJController::get_matche_a_suivre');
