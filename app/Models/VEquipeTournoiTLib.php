<?php
namespace App\Models;
use App\Models\EquipeJModel;
use App\Models\PouleJModel;
use CodeIgniter\Model;

class VEquipeTournoiTLib extends Model
{
    protected $table = 'v_equipe_tournoi_t_lib';
    protected $primaryKey = 'id_equipe_tournoi';

    public function get_teams_of_this_tournament(){
        $data = $this->where('id_tournoi', 1)->findAll();
        return $data;
    }
}