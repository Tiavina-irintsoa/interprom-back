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

    // Listes des équipes participant à un tournoi
    $routes->get('equipes/tournoi/(:num)', 'EquipeController::tournoi/$1');
    $routes->get('equipes/tournoi', 'EquipeController::tournoi');

    // Match par discipline par tournoi
    $routes->get('matchs/(:num)/(:num)', 'MatchController::list_match_by_discipline/$1/$2');

});

// $routes->get('api/utilisateur', 'UtilisateurJController::index');
