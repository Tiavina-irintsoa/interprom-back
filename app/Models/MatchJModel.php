<?php

namespace App\Models;

use CodeIgniter\Model;

class MatchJModel extends Model
{
    protected $table = 'match';
    protected $primaryKey = 'id_match';
    public $timestamps = false;

    protected $fillable = [
        'id_equipe_tournoi_1',
        'id_equipe_tournoi_2',
        'date_',
        'debut_prevision',
        'debut_reel',
        'fin_prevision',
        'fin_reel',
        'id_discipline',
        'score_equipe_1',
        'score_equipe_2',
        'id_type',
    ];

    protected $allowedFields = ['debut_reel', 'fin_reel'];

    public function equipeTournoi1()
    {
        return $this->belongsTo(EquipeTournoiJModel::class, 'id_equipe_tournoi_1');
    }

    public function equipeTournoi2()
    {
        return $this->belongsTo(EquipeTournoiJModel::class, 'id_equipe_tournoi_2');
    }

    public function discipline()
    {
        return $this->belongsTo(DisciplineJModel::class, 'id_discipline');
    }

    public function typeMatch()
    {
        return $this->belongsTo(TypeMatchJModel::class, 'id_type');
    }
}
