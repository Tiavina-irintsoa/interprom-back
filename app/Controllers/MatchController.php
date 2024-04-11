<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VMatchLibModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class MatchController extends ResourceController
{
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
}
