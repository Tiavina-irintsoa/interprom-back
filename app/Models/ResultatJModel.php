<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultatJModel extends Model
{
    protected $table = 'resultat';
    protected $primaryKey = 'id_resultat';
    public $timestamps = false;

    protected $fillable = [
        'id_equipe_tournoi',
        'id_match',
        'point',
        'score_marque',
        'score_encaisse',
    ];

    public function equipe_tournoi()
    {
        return $this->belongsTo(EquipeJModel::class, 'id_equipe_tournoi');
    }

    public function match()
    {
        return $this->belongsTo(MatchJModel::class, 'id_match');
    }
}
