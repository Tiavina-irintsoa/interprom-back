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

    // Routes à propos des équipes
    $routes->get('equipes/tournoi/(:num)', 'EquipeController::tournoi/$1');
    $routes->get('equipes/tournoi', 'EquipeController::tournoi');

    // Routes à propos des matchs
    $routes->get('matchs/all/(:num)/(:num)', 'MatchController::list_match_by_discipline/$1/$2');
    $routes->get('matchs/(:num)/start', 'MatchController::start_match/$1');
    $routes->get('matchs/(:num)/end', 'MatchController::end_match/$1');

});
