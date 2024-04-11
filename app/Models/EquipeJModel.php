<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipeJModel extends Model
{
    protected $table = 'equipe';
    protected $primaryKey = 'id_equipe';
    public $timestamps = false;

    protected $fillable = [
        'nom_equipe',
        'id_poule',
    ];

    public function poule()
    {
        return $this->belongsTo(PouleModel::class, 'id_poule', 'id_poule');
    }
}
