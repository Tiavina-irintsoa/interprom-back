<?php

namespace App\Models;

use CodeIgniter\Model;

class TournoiModel extends Model
{
    protected $table = 'tournoi';
    protected $primaryKey = 'id_tournoi';
    protected $allowedFields = ['nom'];
}
