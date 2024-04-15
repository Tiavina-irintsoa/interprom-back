<?php

namespace App\Controllers;

use App\Models\UtilisateurJModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class MatchJController extends ResourceController
{
    public function get_matche_eliminatoire_en_cours_par_discipline($id_discipline = null): ResponseInterface
    {
        $db = \Config\Database::connect();
        $builder = $db->table('match');
        $builder->select('match.*, e1.nom_equipe as nom_equipe_1, e2.nom_equipe as nom_equipe_2, tm.nom as nom_type_match');
        $builder->join('equipe_tournoi as et1', 'et1.id_equipe_tournoi = match.id_equipe_tournoi_1');
        $builder->join('equipe as e1', 'e1.id_equipe = et1.id_equipe');
        $builder->join('equipe_tournoi as et2', 'et2.id_equipe_tournoi = match.id_equipe_tournoi_2');
        $builder->join('equipe as e2', 'e2.id_equipe = et2.id_equipe');
        $builder->join('type_match as tm', 'tm.id_type_match = id_type');
        $builder->where('id_discipline', $id_discipline);
        $builder->where('id_type > 1');
        $builder->where('debut_reel IS NOT NULL', null, false);
        $builder->where('fin_reel IS NULL', null, false);
        // Afficher la requête SQL générée
        // $sql = $builder->getCompiledSelect();
        // echo $sql;
        $query = $builder->get();
        if ($query) {
            $result = $query->getResult();
            return $this->respond(['error' => null, 'status' => 1, 'data' => $result]);
        } else {
            return $this->respond(['error' => 'Erreur lors de l\'exécution de la requête', 'status' => 0, 'data' => null], 403);
        }
    }

    public function get_matche_eliminatoire_a_suivre_par_discipline($id_discipline = null): ResponseInterface
    {
        $db = \Config\Database::connect();
        $builder = $db->table('match');
        $builder->select('match.*, e1.nom_equipe as nom_equipe_1, e2.nom_equipe as nom_equipe_2, tm.nom as nom_type_match');
        $builder->join('equipe_tournoi as et1', 'et1.id_equipe_tournoi = match.id_equipe_tournoi_1');
        $builder->join('equipe as e1', 'e1.id_equipe = et1.id_equipe');
        $builder->join('equipe_tournoi as et2', 'et2.id_equipe_tournoi = match.id_equipe_tournoi_2');
        $builder->join('equipe as e2', 'e2.id_equipe = et2.id_equipe');
        $builder->join('type_match as tm', 'tm.id_type_match = id_type');
        $builder->where('id_discipline', $id_discipline);
        $builder->where('id_type > 1');
        $builder->where('debut_reel IS NULL', null, false);
        $builder->where('fin_reel IS NULL', null, false);

        $query = $builder->get();

        if ($query) {
            $result = $query->getResult();
            return $this->respond(['error' => null, 'status' => 1, 'data' => $result]);
        } else {
            return $this->respond(['error' => 'Erreur lors de l\'exécution de la requête', 'status' => 0, 'data' => null], 403);
        }
    }
    
    public function get_matche_en_cours_par_discipline_et_poule($id_poule = null): ResponseInterface
    {
        $db = \Config\Database::connect();
        $builder = $db->table('match');
        $builder->select('match.*, e1.nom_equipe as nom_equipe_1, e2.nom_equipe as nom_equipe_2, tm.nom as nom_type_match');
        $builder->join('equipe_tournoi as et1', 'et1.id_equipe_tournoi = match.id_equipe_tournoi_1');
        $builder->join('equipe as e1', 'e1.id_equipe = et1.id_equipe');
        $builder->join('equipe_tournoi as et2', 'et2.id_equipe_tournoi = match.id_equipe_tournoi_2');
        $builder->join('equipe as e2', 'e2.id_equipe = et2.id_equipe');
        $builder->join('type_match as tm', 'tm.id_type_match = id_type');
        $builder->where('et1.id_poule', $id_poule);
        $builder->where('et2.id_poule', $id_poule);
        $builder->where('debut_reel IS NOT NULL', null, false);
        $builder->where('fin_reel IS NULL', null, false);
        // Afficher la requête SQL générée
        // $sql = $builder->getCompiledSelect();
        // echo $sql;
        $query = $builder->get();
        if ($query) {
            $result = $query->getResult();
            return $this->respond(['error' => null, 'status' => 1, 'data' => $result]);
        } else {
            return $this->respond(['error' => 'Erreur lors de l\'exécution de la requête', 'status' => 0, 'data' => null], 403);
        }
    }

    public function get_matche_a_suivre_par_discipline_et_poule($id_poule = null): ResponseInterface
    {
        $db = \Config\Database::connect();
        $builder = $db->table('match');
        $builder->select('match.*, e1.nom_equipe as nom_equipe_1, e2.nom_equipe as nom_equipe_2, tm.nom as nom_type_match');
        $builder->join('equipe_tournoi as et1', 'et1.id_equipe_tournoi = match.id_equipe_tournoi_1');
        $builder->join('equipe as e1', 'e1.id_equipe = et1.id_equipe');
        $builder->join('equipe_tournoi as et2', 'et2.id_equipe_tournoi = match.id_equipe_tournoi_2');
        $builder->join('equipe as e2', 'e2.id_equipe = et2.id_equipe');
        $builder->join('type_match as tm', 'tm.id_type_match = id_type');
        $builder->where('et1.id_poule', $id_poule);
        $builder->where('et2.id_poule', $id_poule);
        $builder->where('debut_reel IS NULL', null, false);
        $builder->where('fin_reel IS NULL', null, false);

        $query = $builder->get();

        if ($query) {
            $result = $query->getResult();
            return $this->respond(['error' => null, 'status' => 1, 'data' => $result]);
        } else {
            return $this->respond(['error' => 'Erreur lors de l\'exécution de la requête', 'status' => 0, 'data' => null], 403);
        }
    }

    public function get_matche_en_cours_par_discipline($id_discipline = null): ResponseInterface
    {
        $db = \Config\Database::connect();
        $builder = $db->table('match');
        $builder->select('match.*, e1.nom_equipe as nom_equipe_1, e2.nom_equipe as nom_equipe_2, tm.nom as nom_type_match');
        $builder->join('equipe_tournoi as et1', 'et1.id_equipe_tournoi = match.id_equipe_tournoi_1');
        $builder->join('equipe as e1', 'e1.id_equipe = et1.id_equipe');
        $builder->join('equipe_tournoi as et2', 'et2.id_equipe_tournoi = match.id_equipe_tournoi_2');
        $builder->join('equipe as e2', 'e2.id_equipe = et2.id_equipe');
        $builder->join('type_match as tm', 'tm.id_type_match = id_type');
        $builder->where('id_discipline', $id_discipline);
        $builder->where('debut_reel IS NOT NULL', null, false);
        $builder->where('fin_reel IS NULL', null, false);
        // Afficher la requête SQL générée
        // $sql = $builder->getCompiledSelect();
        // echo $sql;
        $query = $builder->get();
        if ($query) {
            $result = $query->getResult();
            return $this->respond(['error' => null, 'status' => 1, 'data' => $result]);
        } else {
            return $this->respond(['error' => 'Erreur lors de l\'exécution de la requête', 'status' => 0, 'data' => null], 403);
        }
    }

    public function get_matche_a_suivre_par_discipline($id_discipline = null): ResponseInterface
    {
        $db = \Config\Database::connect();
        $builder = $db->table('match');
        $builder->select('match.*, e1.nom_equipe as nom_equipe_1, e2.nom_equipe as nom_equipe_2, tm.nom as nom_type_match');
        $builder->join('equipe_tournoi as et1', 'et1.id_equipe_tournoi = match.id_equipe_tournoi_1');
        $builder->join('equipe as e1', 'e1.id_equipe = et1.id_equipe');
        $builder->join('equipe_tournoi as et2', 'et2.id_equipe_tournoi = match.id_equipe_tournoi_2');
        $builder->join('equipe as e2', 'e2.id_equipe = et2.id_equipe');
        $builder->join('type_match as tm', 'tm.id_type_match = id_type');
        $builder->where('id_discipline', $id_discipline);
        $builder->where('debut_reel IS NULL', null, false);
        $builder->where('fin_reel IS NULL', null, false);

        $query = $builder->get();

        if ($query) {
            $result = $query->getResult();
            return $this->respond(['error' => null, 'status' => 1, 'data' => $result]);
        } else {
            return $this->respond(['error' => 'Erreur lors de l\'exécution de la requête', 'status' => 0, 'data' => null], 403);
        }
    }
}