<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeMatchModel extends Model
{
    protected $table = 'type_match';
    protected $primaryKey = 'id_type_match';
    protected $allowedFields = ['nom', 'rang'];
}
