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
        $builder->select('match.*, e1.nom_equipe as nom_equipe_1, e2.nom_equipe as nom_equipe_2');
        $builder->join('equipe_tournoi as et1', 'et1.id_equipe_tournoi = match.id_equipe_tournoi_1');
        $builder->join('equipe as e1', 'e1.id_equipe = et1.id_equipe');
        $builder->join('equipe_tournoi as et2', 'et2.id_equipe_tournoi = match.id_equipe_tournoi_2');
        $builder->join('equipe as e2', 'e2.id_equipe = et2.id_equipe');
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
        $builder->select('match.*, e1.nom_equipe as nom_equipe_1, e2.nom_equipe as nom_equipe_2');
        $builder->join('equipe_tournoi as et1', 'et1.id_equipe_tournoi = match.id_equipe_tournoi_1');
        $builder->join('equipe as e1', 'e1.id_equipe = et1.id_equipe');
        $builder->join('equipe_tournoi as et2', 'et2.id_equipe_tournoi = match.id_equipe_tournoi_2');
        $builder->join('equipe as e2', 'e2.id_equipe = et2.id_equipe');
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
        $builder->select('match.*, e1.nom_equipe as nom_equipe_1, e2.nom_equipe as nom_equipe_2');
        $builder->join('equipe_tournoi as et1', 'et1.id_equipe_tournoi = match.id_equipe_tournoi_1');
        $builder->join('equipe as e1', 'e1.id_equipe = et1.id_equipe');
        $builder->join('equipe_tournoi as et2', 'et2.id_equipe_tournoi = match.id_equipe_tournoi_2');
        $builder->join('equipe as e2', 'e2.id_equipe = et2.id_equipe');
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
        $builder->select('match.*, e1.nom_equipe as nom_equipe_1, e2.nom_equipe as nom_equipe_2');
        $builder->join('equipe_tournoi as et1', 'et1.id_equipe_tournoi = match.id_equipe_tournoi_1');
        $builder->join('equipe as e1', 'e1.id_equipe = et1.id_equipe');
        $builder->join('equipe_tournoi as et2', 'et2.id_equipe_tournoi = match.id_equipe_tournoi_2');
        $builder->join('equipe as e2', 'e2.id_equipe = et2.id_equipe');
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
        $sql = "SELECT m.id_match, et1.id_tournoi, e1.nom_equipe AS nom_equipe_1, e2.nom_equipe AS nom_equipe_2, m.date_, d.id_discipline, m.debut_prevision, m.debut_reel, m.fin_prevision, m.fin_reel, d.nom AS nom_discipline, m.score_equipe_1, m.score_equipe_2, tm.nom AS nom_type_match, m.terrain FROM match m JOIN equipe_tournoi et1 ON m.id_equipe_tournoi_1 = et1.id_equipe_tournoi JOIN equipe e1 ON et1.id_equipe = e1.id_equipe JOIN equipe_tournoi et2 ON m.id_equipe_tournoi_2 = et2.id_equipe_tournoi JOIN equipe e2 ON et2.id_equipe = e2.id_equipe JOIN discipline d ON m.id_discipline = d.id_discipline JOIN type_match tm ON m.id_type = tm.id_type_match WHERE m.debut_reel IS NOT NULL AND m.fin_reel IS NULL and d.id_discipline=".$id_discipline.' order by m.debut_reel asc';
        $query = $db->query($sql);
        $result = $query->getResult();

        return $this->respond(['error' => null, 'status' => 8989, 'data' => $result]);
    }
    public function get_matche_en_cours_par_discipline_par_equipe($id_discipline = null, $id_equipe_tournoi = null): ResponseInterface
    {
        try {
            $db = \Config\Database::connect();
            if ($id_equipe_tournoi !=-1){
                $sql = "SELECT m.id_match, et1.id_tournoi, e1.nom_equipe AS nom_equipe_1, e2.nom_equipe AS nom_equipe_2, m.date_, d.id_discipline, m.debut_prevision, m.debut_reel, m.fin_prevision, m.fin_reel, d.nom AS nom_discipline, m.score_equipe_1, m.score_equipe_2, tm.nom AS nom_type_match, m.terrain FROM match m JOIN equipe_tournoi et1 ON m.id_equipe_tournoi_1 = et1.id_equipe_tournoi JOIN equipe e1 ON et1.id_equipe = e1.id_equipe JOIN equipe_tournoi et2 ON m.id_equipe_tournoi_2 = et2.id_equipe_tournoi JOIN equipe e2 ON et2.id_equipe = e2.id_equipe JOIN discipline d ON m.id_discipline = d.id_discipline JOIN type_match tm ON m.id_type = tm.id_type_match WHERE m.debut_reel IS NOT NULL AND m.fin_reel IS NULL and d.id_discipline=".$id_discipline.' and (et1.id_equipe_tournoi = '.$id_equipe_tournoi.' or et2.id_equipe_tournoi = '.$id_equipe_tournoi.') order by m.debut_reel asc';
            }
            else{
                $sql = "SELECT m.id_match, et1.id_tournoi, e1.nom_equipe AS nom_equipe_1, e2.nom_equipe AS nom_equipe_2, m.date_, d.id_discipline, m.debut_prevision, m.debut_reel, m.fin_prevision, m.fin_reel, d.nom AS nom_discipline, m.score_equipe_1, m.score_equipe_2, tm.nom AS nom_type_match, m.terrain FROM match m JOIN equipe_tournoi et1 ON m.id_equipe_tournoi_1 = et1.id_equipe_tournoi JOIN equipe e1 ON et1.id_equipe = e1.id_equipe JOIN equipe_tournoi et2 ON m.id_equipe_tournoi_2 = et2.id_equipe_tournoi JOIN equipe e2 ON et2.id_equipe = e2.id_equipe JOIN discipline d ON m.id_discipline = d.id_discipline JOIN type_match tm ON m.id_type = tm.id_type_match WHERE m.debut_reel IS NOT NULL AND m.fin_reel IS NULL and d.id_discipline=".$id_discipline.' order by m.debut_reel asc';
            }
            $query = $db->query($sql);
            $result = $query->getResult();

            return $this->respond(['error' => null, 'status' => 1, 'data' => $result]);
        } catch (Exception $th) {
            return $this->respond(['error' => 'Erreur lors de l\'exécution de la requête', 'status' => 0, 'data' => null], 403);
        }
    }
    public function get_matche_a_suivre_par_discipline($id_discipline = null): ResponseInterface
    {
        $db = \Config\Database::connect();
        $sql = "SELECT m.id_match, et1.id_tournoi, e1.nom_equipe AS nom_equipe_1, e2.nom_equipe AS nom_equipe_2, m.date_, d.id_discipline, m.debut_prevision, m.debut_reel, m.fin_prevision, m.fin_reel, d.nom AS nom_discipline, m.score_equipe_1, m.score_equipe_2, tm.nom AS nom_type_match, m.terrain FROM match m JOIN equipe_tournoi et1 ON m.id_equipe_tournoi_1 = et1.id_equipe_tournoi JOIN equipe e1 ON et1.id_equipe = e1.id_equipe JOIN equipe_tournoi et2 ON m.id_equipe_tournoi_2 = et2.id_equipe_tournoi JOIN equipe e2 ON et2.id_equipe = e2.id_equipe JOIN discipline d ON m.id_discipline = d.id_discipline JOIN type_match tm ON m.id_type = tm.id_type_match WHERE m.debut_reel IS NULL AND m.fin_reel IS NULL and d.id_discipline=".$id_discipline.' order by m.debut_prevision asc';
        $query = $db->query($sql);
        $result = $query->getResult();

        return $this->respond(['error' => null, 'status' => 8989, 'data' => $result]);
    }
    public function get_matche_a_suivre_par_discipline_par_equipe($id_discipline = null, $id_equipe_tournoi = null): ResponseInterface
    {
        try {
            $db = \Config\Database::connect();
            if ($id_equipe_tournoi !=-1){
                $sql = "SELECT m.id_match, et1.id_tournoi, e1.nom_equipe AS nom_equipe_1, e2.nom_equipe AS nom_equipe_2, m.date_, d.id_discipline, m.debut_prevision, m.debut_reel, m.fin_prevision, m.fin_reel, d.nom AS nom_discipline, m.score_equipe_1, m.score_equipe_2, tm.nom AS nom_type_match, m.terrain FROM match m JOIN equipe_tournoi et1 ON m.id_equipe_tournoi_1 = et1.id_equipe_tournoi JOIN equipe e1 ON et1.id_equipe = e1.id_equipe JOIN equipe_tournoi et2 ON m.id_equipe_tournoi_2 = et2.id_equipe_tournoi JOIN equipe e2 ON et2.id_equipe = e2.id_equipe JOIN discipline d ON m.id_discipline = d.id_discipline JOIN type_match tm ON m.id_type = tm.id_type_match WHERE m.debut_reel IS NULL AND m.fin_reel IS NULL and d.id_discipline=".$id_discipline.' and (et1.id_equipe_tournoi = '.$id_equipe_tournoi.' or et2.id_equipe_tournoi = '.$id_equipe_tournoi.') order by m.debut_prevision asc';
            }
            else{
                $sql = "SELECT m.id_match, et1.id_tournoi, e1.nom_equipe AS nom_equipe_1, e2.nom_equipe AS nom_equipe_2, m.date_, d.id_discipline, m.debut_prevision, m.debut_reel, m.fin_prevision, m.fin_reel, d.nom AS nom_discipline, m.score_equipe_1, m.score_equipe_2, tm.nom AS nom_type_match, m.terrain FROM match m JOIN equipe_tournoi et1 ON m.id_equipe_tournoi_1 = et1.id_equipe_tournoi JOIN equipe e1 ON et1.id_equipe = e1.id_equipe JOIN equipe_tournoi et2 ON m.id_equipe_tournoi_2 = et2.id_equipe_tournoi JOIN equipe e2 ON et2.id_equipe = e2.id_equipe JOIN discipline d ON m.id_discipline = d.id_discipline JOIN type_match tm ON m.id_type = tm.id_type_match WHERE m.debut_reel IS NULL AND m.fin_reel IS NULL and d.id_discipline=".$id_discipline.' order by m.debut_prevision asc';
            }
            $query = $db->query($sql);
            $result = $query->getResult();

            return $this->respond(['error' => null, 'status' => 1, 'data' => $result]);
        } catch (Exception $th) {
            return $this->respond(['error' => 'Erreur lors de l\'exécution de la requête', 'status' => 0, 'data' => null], 403);
        }
    }
   
    public function get_matche_termine_par_discipline($id_discipline = null): ResponseInterface
    {
        $db = \Config\Database::connect();
        $sql = "SELECT m.id_match, et1.id_tournoi, e1.nom_equipe AS nom_equipe_1, e2.nom_equipe AS nom_equipe_2, m.date_, d.id_discipline, m.debut_prevision, m.debut_reel, m.fin_prevision, m.fin_reel, d.nom AS nom_discipline, m.score_equipe_1, m.score_equipe_2, tm.nom AS nom_type_match, m.terrain FROM match m JOIN equipe_tournoi et1 ON m.id_equipe_tournoi_1 = et1.id_equipe_tournoi JOIN equipe e1 ON et1.id_equipe = e1.id_equipe JOIN equipe_tournoi et2 ON m.id_equipe_tournoi_2 = et2.id_equipe_tournoi JOIN equipe e2 ON et2.id_equipe = e2.id_equipe JOIN discipline d ON m.id_discipline = d.id_discipline JOIN type_match tm ON m.id_type = tm.id_type_match WHERE m.debut_reel IS not  NULL AND m.fin_reel IS not  NULL and d.id_discipline=".$id_discipline.' order by m.debut_reel desc';
        $query = $db->query($sql);
        $result = $query->getResult();

        return $this->respond(['error' => null, 'status' => 8989, 'data' => $result]);
    }
    public function get_matche_termine_par_discipline_par_equipe($id_discipline = null, $id_equipe_tournoi = null): ResponseInterface
    {
        try {
            $db = \Config\Database::connect();
            if ($id_equipe_tournoi !=-1){
                $sql = "SELECT m.id_match, et1.id_tournoi, e1.nom_equipe AS nom_equipe_1, e2.nom_equipe AS nom_equipe_2, m.date_, d.id_discipline, m.debut_prevision, m.debut_reel, m.fin_prevision, m.fin_reel, d.nom AS nom_discipline, m.score_equipe_1, m.score_equipe_2, tm.nom AS nom_type_match, m.terrain FROM match m JOIN equipe_tournoi et1 ON m.id_equipe_tournoi_1 = et1.id_equipe_tournoi JOIN equipe e1 ON et1.id_equipe = e1.id_equipe JOIN equipe_tournoi et2 ON m.id_equipe_tournoi_2 = et2.id_equipe_tournoi JOIN equipe e2 ON et2.id_equipe = e2.id_equipe JOIN discipline d ON m.id_discipline = d.id_discipline JOIN type_match tm ON m.id_type = tm.id_type_match WHERE m.debut_reel IS not  NULL AND m.fin_reel IS not  NULL and d.id_discipline=".$id_discipline.' and (et1.id_equipe_tournoi = '.$id_equipe_tournoi.' or et2.id_equipe_tournoi = '.$id_equipe_tournoi.') order by m.debut_reel desc';
            }
            else{
                $sql = "SELECT m.id_match, et1.id_tournoi, e1.nom_equipe AS nom_equipe_1, e2.nom_equipe AS nom_equipe_2, m.date_, d.id_discipline, m.debut_prevision, m.debut_reel, m.fin_prevision, m.fin_reel, d.nom AS nom_discipline, m.score_equipe_1, m.score_equipe_2, tm.nom AS nom_type_match, m.terrain FROM match m JOIN equipe_tournoi et1 ON m.id_equipe_tournoi_1 = et1.id_equipe_tournoi JOIN equipe e1 ON et1.id_equipe = e1.id_equipe JOIN equipe_tournoi et2 ON m.id_equipe_tournoi_2 = et2.id_equipe_tournoi JOIN equipe e2 ON et2.id_equipe = e2.id_equipe JOIN discipline d ON m.id_discipline = d.id_discipline JOIN type_match tm ON m.id_type = tm.id_type_match WHERE m.debut_reel IS not  NULL AND m.fin_reel IS not  NULL and d.id_discipline=".$id_discipline.' order by m.debut_reel desc';
            }
            $query = $db->query($sql);
            $result = $query->getResult();

            return $this->respond(['error' => null, 'status' => 1, 'data' => $result]);
        } catch (Exception $th) {
            return $this->respond(['error' => 'Erreur lors de l\'exécution de la requête', 'status' => 0, 'data' => null], 403);
        }
    }
}