<?php namespace App\Models;

use CodeIgniter\Model;

class MatchModel extends Model
{
    protected $table = 'match';
    protected $primaryKey = 'id_match';
    protected $allowedFields = ['id_equipe_tournoi_1', 'id_equipe_tournoi_2', 'date', 'debut_prevision','debut_reel','fin_prevision','fin_reel','id_discipline','score_equipe_1','score_equipe_2','id_type'];
}
