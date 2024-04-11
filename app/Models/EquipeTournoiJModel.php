<?php

use App\Models\EquipeJModel;
use App\Models\PouleJModel;
use CodeIgniter\Model;

class EquipeTournoiJModel extends Model
{
    protected $table = 'equipe_tournoi';
    protected $primaryKey = 'id_equipe_tournoi';
    public $timestamps = false;

    protected $fillable = [
        'id_equipe',
        'id_tournoi',
        'id_poule',
    ];

    public function equipe()
    {
        return $this->belongsTo(EquipeJModel::class, 'id_equipe');
    }

    public function tournoi()
    {
        return $this->belongsTo(TournoiJModel::class, 'id_tournoi');
    }

    public function poule()
    {
        return $this->belongsTo(PouleJModel::class, 'id_poule', 'id_poule');
    }
}
