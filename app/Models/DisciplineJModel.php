<?php

namespace App\Models;

use CodeIgniter\Model;

class DisciplineJModel extends Model
{
    protected $table = 'discipline';
    protected $primaryKey = 'id_discipline';
    public $timestamps = false;

    protected $fillable = [
        'nom',
    ];
}
