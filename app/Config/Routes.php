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

// Login
$routes->post('login','LoginController::index');

// Routes qui ont besoin d authentification
$routes->get('api/equipes/tournoi', 'EquipeController::tournoi',['filter' => \App\Filters\TokenFilter::class]);

// Import
$routes->post('api/equipes/import', 'EquipeController::import_equipe',['filter' => \App\Filters\TokenFilter::class]);
$routes->post('api/matchs/import', 'MatchController::import_match',['filter' => \App\Filters\TokenFilter::class]);





$routes->post('/api/matchs/update_score', 'MatchController::update_score');

// Routes à propos des équipes
$routes->get('api/equipes/tournoi/(:num)', 'EquipeController::tournoi/$1');
$routes->get('api/equipes/tournoi', 'EquipeController::tournoi');
$routes->get('api/equipes-discipline-tournoi/(:num)/(:num)', 'EquipeController::get_equipes_by_tournoi_discipline/$1/$2');

// A propos des matchs
$routes->get('api/matchs-discipline-tournoi/(:num)/(:num)', 'MatchController::list_match_by_discipline/$1/$2');
$routes->get('api/matchs-tournoi/(:num)', 'MatchController::list_match_ordered/$1');
$routes->get('api/matchs-tournoi', 'MatchController::list_match_ordered');
$routes->get('api/start-match/(:num)', 'MatchController::start_match/$1');
$routes->get('api/end-match/(:num)', 'MatchController::end_match/$1');

$routes->get('api/match-a-suivre', 'MatchJController::get_matche_a_suivre');
$routes->get('api/match-en-cours/(:num)', 'MatchJController::get_matche_en_cours_par_discipline/$1');
$routes->get('api/match-en-cours/poule_(:num)', 'MatchJController::get_matche_en_cours_par_discipline_et_poule/$1');
$routes->get('api/match-a-suivre/poule_(:num)', 'MatchJController::get_matche_a_suivre_par_discipline_et_poule/$1');

$routes->post('api/matchs/update_score', 'MatchController::update_score');

$routes->get('matchs/all/(:num)/(:num)', 'MatchController::list_match_by_discipline/$1/$2');
$routes->get('matchs/(:num)/start', 'MatchController::start_match/$1');
$routes->get('matchs/(:num)/end', 'MatchController::end_match/$1');

$routes->get('api/resultat-match/poule_(:num)', 'PouleJController::get_resultat_poule_choisie/$1');
$routes->get('api/classement/poule_(:num)', 'PouleJController::get_classement_par_poule_choisi/$1');
$routes->get('api/poule-discipline_(:num)', 'DisciplineJController::get_all_poule_by_discipline/$1');

$routes->get('api/elimination-en-cours/discipline_(:num)', 'MatchJController::get_matche_en_cours_par_discipline/$1');
$routes->get('api/elimination-a-suivre/discipline_(:num)', 'MatchJController::get_matche_a_suivre_par_discipline/$1');