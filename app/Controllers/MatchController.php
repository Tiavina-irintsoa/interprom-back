<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MatchJModel;
use App\Models\MatchModel;
use App\Models\VMatchLibModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class MatchController extends ResourceController
{
    protected $format = 'json';

    public function create()
    {
        $model = new MatchModel();
        $data = $this->request->getJSON();
        $model->insert($data);
        return $this->respondCreated($data);
    }

    public function update($id = null)
    {
        $model = new MatchModel();
        $data = $this->request->getJSON();
        $model->update($id, $data);
        return $this->respond($data);
    }

    public function show($id = null)
    {
    }

    // Match par discipline par tournoi selon ordered by prevision date
    public function list_match_by_discipline($id_discipline, $id_tournoi)
    {
        $model = new VMatchLibModel();
        $matchs = $model->where('id_tournoi', $id_tournoi)->where('id_discipline', $id_discipline)->findAll();

        $data = [
            'status' => 1,
            'data' => $matchs
        ];

        return $this->respond($data);
    }

    public function update_score()
    {
        $model = new MatchModel();
        $data = $this->request->getJSON();
        $match = $model->find($data->idmatch);
        if ($data->points < 0 || is_numeric($data->points) == false) {
            return $this->respond(array('error' => 'Points invalides', 'data' => null, 'status' => 0));
        }
        if (!$match) {
            return $this->respond(array('error' => 'Ce match n\'existe pas', 'data' => null, 'status' => 0));
        } else {
            if ($match['fin_reel'] != '') {
                return $this->respond(array('error' => 'Ce match est déjà terminé', 'data' => null, 'status' => 0));
            }
            if ($match['debut_reel'] == '') {
                return $this->respond(array('error' => 'Ce match n\' a pas encore commencé', 'data' => null, 'status' => 0));
            }
        }


        if ($data->equipe != 1 && $data->equipe != 2) {
            return $this->respond(array('error' => 'L\'equipe doit être 1 ou 2', 'data' => null, 'status' => 0));
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
                'error' => "Le match que vous voulez commencer n' éxiste même pas"
            ]);
        }

        if (isset($match['debut_reel'])) {
            return $this->respond([
                'status' => 0,
                'error' => "Le match que vous voulez spécifier a déja commencé !"
            ]);
        }

        date_default_timezone_set('Indian/Antananarivo');

        $update_data = [
            'debut_reel' => date('H:i:s')
        ];

        $match_model->update($id_match, $update_data);

        return $this->respond([
            'status' => 1,
            'data' => 'Match commencé avec success !'
        ]);
    }

    public function end_match($id_match)
    {
        $match_model = new MatchJModel();

        $match = $match_model->find($id_match);
        if (!isset($match)) {
            return $this->respond([
                'status' => 0,
                'error' => "Le match que vous voulez terminer n' éxiste même pas"
            ]);
        }

        if (isset($match['fin_reel'])) {
            return $this->respond([
                'status' => 0,
                'error' => "Le match que vous voulez spécifié est déja terminer !"
            ]);
        }

        date_default_timezone_set('Indian/Antananarivo');

        $update_data = [
            'fin_reel' => date('H:i:s')
        ];

        $match_model->update($id_match, $update_data);

        return $this->respond([
            'status' => 1,
            'data' => 'Match terminé avec success !'
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
        }
    }
}
