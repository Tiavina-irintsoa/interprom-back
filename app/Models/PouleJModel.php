<?php

namespace App\Models;

use CodeIgniter\Model;

class PouleModel extends Model
{
    protected $table = 'poule';
    protected $primaryKey = 'id_poule';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nom', 'id_discipline'];

    protected $useTimestamps = false;

    protected $validationRules = [
        'nom' => 'required',
        'id_discipline' => 'permit_empty|integer'
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $afterInsert = ['storeInDiscipline'];
    protected $afterUpdate = ['storeInDiscipline'];

    protected function storeInDiscipline(array $data)
    {
        $disciplineModel = new \App\Models\DisciplineJModel();
        $disciplineModel->insert(['id_discipline' => $data['data']['id_discipline']]);

        return $data;
    }
}