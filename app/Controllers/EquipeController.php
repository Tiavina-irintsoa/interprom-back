<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VEquipeTournoiLibCompModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

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

        return $this->respond($data, 403);
    }
}
