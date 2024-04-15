<?php

namespace App\Controllers;

helper('date_helper');

use App\Controllers\BaseController;
use App\Models\MatchJModel;
use App\Models\MatchModel;
use App\Models\ResultatJModel;
use App\Models\VMatchLibModel;
use App\Models\EquipeTournoiJModel;
use App\Models\DisciplineJModel;
use App\Models\TypeMatchJModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class MatchController extends ResourceController
{
    protected $format = 'json';


    public function create()
    {
        helper('my_date_helper');
        $data = $this->request->getJSON();
        $equipe_tournoi_model = new EquipeTournoiJModel();
        if($data->id_equipe_tournoi_1 == $data->id_equipe_tournoi_2){
            return $this->respond(array('error'=>'Les équipes doivent être différentes','data'=>null,'status'=>0), 403);
        }
        $eq_t_1=$equipe_tournoi_model->find($data->id_equipe_tournoi_1);
        if(!$eq_t_1){
            return $this->respond(array('error'=>'L\'équipe 1 choisie ne participe pas à ce tournoi','data'=>null,'status'=>0), 403);
        }
        $eq_t_2=$equipe_tournoi_model->find($data->id_equipe_tournoi_2);
        if(!$eq_t_2){
            return $this->respond(array('error'=>'L\'équipe 2 choisie ne participe pas à ce tournoi','data'=>null,'status'=>0), 403);
        }
        
        if(is_valid_date($data->date_)==false){
            return $this->respond(array('error'=>'Date invalide','data'=>null,'status'=>0), 403);
        }

        if(is_before($data->debut_prevision, $data->fin_prevision)==false){
            return $this->respond(array('error'=>'L\'heure de début doit être antérieure à l\'heure de fin','data'=>null,'status'=>0), 403);
        }
        $discpline_model = new DisciplineJModel();
        $discipline=$discpline_model->find($data->id_discipline);
        if(!$discipline){
            return $this->respond(array('error'=>'Discipline invalide','data'=>null,'status'=>0), 403);
        }
        $type_match_model = new TypeMatchJModel();
        $type_match=$type_match_model->find($data->id_type);
        if(!$type_match){
            return $this->respond(array('error'=>'Type de match invalide','data'=>null,'status'=>0), 403);
        }
        $model = new MatchModel();
        $match=$model->insert($data);
        return $this->respondCreated(array('error'=>null,'data'=>$match,'status'=>1), 403);
    }

    public function update($id = null)
    {
        $model = new MatchModel();
        $data = $this->request->getJSON();
        $match = $model->update($id, $data);
        return $this->respond(array('error' => null, 'data' => $match, 'status' => 1));
    }

    public function show($id = null)
    {
        $model = new VMatchLibModel();
        $resp=$model->find($id);
        if(!$resp){
            return $this->respond(array('error'=>'Ce match n\'existe pas','data'=>null,'status'=>0), 403);
        }
        return $this->respond(array('error' => null, 'data' => $resp, 'status' => 1));
    }

    // Tous les matchs ordered by prevision date
    public function list_match_ordered($id_tournoi = 1)
    {
        $model = new VMatchLibModel();
        $matchs = $model->where('id_tournoi', $id_tournoi)->findAll();

        $data = [
            'status' => 1,
            'data' => $matchs,
            'error' => null
        ];

        return $this->respond($data);
    }

    // Match par discipline par tournoi selon ordered by prevision date
    public function list_match_by_discipline($id_discipline, $id_tournoi)
    {
        $model = new VMatchLibModel();
        $matchs = $model->where('id_tournoi', $id_tournoi)->where('id_discipline', $id_discipline)->findAll();

        $data = [
            'status' => 1,
            'data' => $matchs,
            'error' => null
        ];

        return $this->respond($data);
    }

    public function update_score()
    {
        $model = new MatchModel();
        $data = $this->request->getJSON();
        $match = $model->find($data->idmatch);
        if($data->points<0 || is_numeric($data->points)==false){
            return $this->respond(array('error'=>'Points invalides','data'=>null,'status'=>0), 403);
        }
        if (!$match) {
            return $this->respond(array('error'=>'Ce match n\'existe pas','data'=>null,'status'=>0), 403);
        }
        else{
            if($match['fin_reel']!=''){
                return $this->respond(array('error'=>'Ce match est déjà terminé','data'=>null,'status'=>0), 403);
            }
            if($match['debut_reel']==''){
                return $this->respond(array('error'=>'Ce match n\' a pas encore commencé','data'=>null,'status'=>0), 403);
            }
        }
        if($data->equipe!=1 && $data->equipe!=2){
            return $this->respond(array('error'=>'L\'equipe doit être 1 ou 2','data'=>null,'status'=>0), 403);
        }
        $match = $model->updateScore($data, $match);
        return $this->respond(array('error' => null, 'data' => $match, 'status' => 1));
    }

    // Commencer le match 
    public function start_match($id_match)
    {
        $match_model = new MatchJModel();

        $match = $match_model->find($id_match);
        if (!isset($match)) {
            return $this->respond([
                'status' => 0,
                'error' => "Le match que vous voulez commencer n' éxiste pas",
                'data' => null
            ], 403);
        }

        if (isset($match['debut_reel'])) {
            return $this->respond([
                'status' => 0,
                'error' => "Le match que vous voulez spécifier a déja commencé !",
                'data' => null
            ], 403);
        }

        date_default_timezone_set('Indian/Antananarivo');

        $update_data = [
            'debut_reel' => date('H:i:s')
        ];

        $match_model->update($id_match, $update_data);

        return $this->respond([
            'status' => 1,
            'data' => 'Match commencé avec success !',
            'error' => null
        ]);
    }

    public function end_match($id_match)
    {
        $this->db = \Config\Database::connect();
        $this->db->transStart(); // Démarre la transaction

        $match_model = new MatchJModel();

        $match = $match_model->find($id_match);
        if (!isset($match)) {
            $this->db->transRollback(); // Annule la transaction
            return $this->respond([
                'status' => 0,
                'error' => "Le match que vous voulez terminer n'existe même pas",
                'data' => null
            ], 403);
        }

        if (isset($match['fin_reel'])) {
            $this->db->transRollback(); // Annule la transaction
            return $this->respond([
                'status' => 0,
                'error' => "Le match que vous voulez spécifier est déjà terminé !",
                'data' => null
            ], 403);
        }

        date_default_timezone_set('Indian/Antananarivo');

        $update_data = [
            'fin_reel' => date('H:i:s')
        ];

        $update_success = $match_model->update($id_match, $update_data);

        if (!$update_success) {
            $this->db->transRollback(); // Annule la transaction
            return $this->respond([
                'status' => 0,
                'error' => "Échec de la mise à jour du match",
                'data' => null
            ], 500);
        }

        // Insérer le résultat seulement si la mise à jour du match réussit
        $insert_resultat_success = $this->insert_resultat($match);

        if (!$insert_resultat_success) {
            $this->db->transRollback(); // Annule la transaction
            return $this->respond([
                'status' => 0,
                'error' => "Échec de l'insertion des résultats",
                'data' => null
            ], 500);
        }

        $this->db->transCommit(); // Valide la transaction

        return $this->respond([
            'status' => 1,
            'data' => 'Match terminé avec succès !',
            'error' => null
        ]);
    }


    public function get_point($match, $equipe_1_or_2)
    {
        if($match['score_equipe_1'] > $match['score_equipe_2'])
        {
            if($equipe_1_or_2 == 1)return 3;
            else return 0;
        }
        else if($match['score_equipe_1'] < $match['score_equipe_2'])
        {
            if($equipe_1_or_2 == 1)return 0;
            else return 3;
        }else{
            return 1;
        }

    }

    public function insert_resultat($match)
    {
        $resultat = new ResultatJModel();

        // Récupération des points et des données de résultat pour la première équipe
        $point_1 = $this->get_point($match, 1);
        $first_resultat = [
            'id_equipe_tournoi' => $match['id_equipe_tournoi_1'],
            'id_match' => $match['id_match'],
            'point' => $point_1,
            'score_marque' => $match['score_equipe_1'],
            'score_encaisse' => $match['score_equipe_2']
        ];

        // Récupération des points et des données de résultat pour la deuxième équipe
        $point_2 = $this->get_point($match, 2);
        $second_resultat = [
            'id_equipe_tournoi' => $match['id_equipe_tournoi_2'],
            'id_match' => $match['id_match'],
            'point' => $point_2,
            'score_marque' => $match['score_equipe_2'],
            'score_encaisse' => $match['score_equipe_1']
        ];

        // Insertion des résultats dans la base de données
        $resultat->insert($first_resultat);
        $resultat->insert($second_resultat);

        return $this->respond([
            'status' => 1,
            'data' => 'Résultats insérés avec succès !',
            'error' => null
        ]);
    }

    public function import_match()
    {
        try {
            $inserted = false;
            $request = $this->request->getJSON();
            if (!isset($request->base_64_file)) {
                return $this->respond(['message' => 'base_64_file not found in the request'], 400);
            }
            $base64File = $request->base_64_file;
            $csvData = base64_decode($base64File);
            if ($csvData === false) {
                return $this->respond(['message' => 'Failed to decode base64-encoded file'], 400);
            }
            $rows = explode("\n", $csvData);
            $headers = str_getcsv(array_shift($rows));
            $matchModel = new MatchModel();
            $notInsertedIndices = [];
            foreach ($rows as $row) {
                $fields = str_getcsv($row);
                $trimmedFields = [];
                foreach ($fields as $index => $field) {
                    $columnName = $headers[$index];
                    $trimmedFields[] = in_array($columnName, [], true) ? trim($field) : $field;
                }
                $trimmedFields = array_map('trim', $fields);
                if (count($headers) === count($trimmedFields)) {
                    $data = array_combine($headers, $trimmedFields);
                    foreach ($data as $key => $value) {
                        if ($value === '') {
                            $data[$key] = null;
                        }
                    }
                    if ($matchModel->insert($data)) {
                        $inserted = true;
                    } else {
                        $notInsertedIndices[] = $index + 1;
                    }
                }
                else{
                    $notInsertedIndices[] = $index + 1;
                }
            }
            if (!$inserted) {
                return $this->respond(['message' => 'No data inserted, verify the csv file'], 400);
            }
            if (count($notInsertedIndices) > 0) {
                return $this->respond(['message' => 'Some data are not inserted', 'not_inserted_on_lines' => $notInsertedIndices], 400);
            }
            return $this->respond(['message' => 'Import succes'], 200);
        } catch (\Exception $e) {
            return $this->respond(['message' => 'An error occurred during the import process'], 500);
        } catch (DatabaseException $e){
            return $this->respond(['message' => 'An error occurred during the import process'], 500);
        }
    }
}
