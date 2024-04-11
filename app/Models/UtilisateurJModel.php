<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilisateurJModel extends Model
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'mdp'];
}