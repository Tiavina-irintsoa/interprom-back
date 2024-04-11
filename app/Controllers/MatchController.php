<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MatchJModel;
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
}
