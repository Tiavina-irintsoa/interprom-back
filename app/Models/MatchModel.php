<?php namespace App\Models;

use CodeIgniter\Model;

class MatchModel extends Model
{
    protected $table = 'match';
    protected $primaryKey = 'id_match';
    protected $allowedFields = ['id_equipe_tournoi_1', 'id_equipe_tournoi_2', 'date_', 'debut_prevision','debut_reel','fin_prevision','fin_reel','id_discipline','score_equipe_1','score_equipe_2','id_type', 'terrain'];
    // Méthode pour décrémenter le score de l'equipe 1 ou 2  d'un match spécifique
    public function updateScore($data,$match)
    {
        $builder = $this->builder();
        if($data->equipe==1){
            $builder->where('id_match', $data->idmatch)
                ->set('score_equipe_1', $data->points)
                ->update();
            $match['score_equipe_1']=$data->points;
        }
        else if($data->equipe==2){
            $builder->where('id_match', $data->idmatch)
                ->set('score_equipe_2', $data->points)
                ->update();
            $match['score_equipe_2']=$data->points;
        }
        return $match;
    }
    
}
