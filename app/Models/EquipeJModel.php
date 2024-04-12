<?php

namespace App\Models;

use CodeIgniter\Model;

class EquipeJModel extends Model
{
    protected $table = 'equipe';
    protected $primaryKey = 'id_equipe';
    public $timestamps = false;

    protected $fillable = [
        'nom_equipe'
    ];

    public function poule()
    {
        return $this->belongsTo(PouleJModel::class, 'id_poule', 'id_poule');
    }
}
