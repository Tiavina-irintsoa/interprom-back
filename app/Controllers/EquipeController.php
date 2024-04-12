<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VEquipeTournoiLibCompModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\EquipeJModel;

class EquipeController extends ResourceController
{
    public function tournoi($id_tournoi = 1)
    {
        $equipe_tournoi = new VEquipeTournoiLibCompModel();
        $equipe_tournoi->select('id_equipe, nom_equipe, nom_poule, nom_discipline');
        $equipes = $equipe_tournoi->where('id_tournoi', $id_tournoi)->findAll();

        $data = [
            'status' => 1,
            'data' => $equipes,
            'error' => null
        ];

        return $this->respond($data);
    }

    public function import_equipe()
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
            $equipeModel = new EquipeJModel();
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
                    if ($equipeModel->insert($data)) {
                        $inserted = true;
                    } else {
                        $notInsertedIndices[] = $index + 1;
                    }
                } else {
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
    
    public function get_equipes_by_tournoi_discipline($id_discipline, $id_tournoi)
    {
        $equipe_tournoi = new VEquipeTournoiLibCompModel();
        $equipe_tournoi->select('id_equipe_tournoi, nom_equipe, nom_poule, nom_discipline, nom_tournoi');
        $equipes = $equipe_tournoi->where('id_tournoi', $id_tournoi)->where('id_discipline', $id_discipline)->findAll();

        $data = [
            'status' => 1,
            'data' => $equipes,
            'error' => null
        ];

        return $this->respond($data);
    }
}
