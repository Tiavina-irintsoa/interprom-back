<?php

use CodeIgniter\Model;

class TournoiJModel extends Model
{
    protected $table = 'tournoi';
    protected $primaryKey = 'id_tournoi';
    protected $allowedFields = ['nom'];
}
