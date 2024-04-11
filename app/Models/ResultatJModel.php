<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultatJModel extends Model
{
    protected $table = 'resultat';
    protected $primaryKey = 'id_resultat';
    public $timestamps = false;

    protected $fillable = [
        'id_equipe',
        'id_match',
        'point',
        'score_marque',
        'score_encaisse',
    ];

    public function equipe()
    {
        return $this->belongsTo(Equipe::class, 'id_equipe');
    }

    public function match()
    {
        return $this->belongsTo(Match::class, 'id_match');
    }
}
